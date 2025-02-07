<?php

namespace App\Libraries;

use CodeIgniter\Session\Handlers\DatabaseHandler;

class MySession extends DatabaseHandler{

    public function write($id, $data): bool
    {
        if ($this->lock === false) {
            return $this->fail();
        }

        if ($this->sessionID !== $id) {
            $this->rowExists = false;
            $this->sessionID = $id;
        }

        if ($this->rowExists === false) {
            $insertData = [
                'id'         => $this->idPrefix . $id,
                'ip_address' => $this->ipAddress,
                'data'       => $this->prepareData($data),
            ];

            if (env('DB_DRIVER') == 'sqlsrv') {
                if (! $this->db->table($this->table)->set('timestamp', 'getdate()', false)->insert($insertData)) {
                    return $this->fail();
                }
            } else {

                if (! $this->db->table($this->table)->set('timestamp', 'now()', false)->insert($insertData)) {
                    return $this->fail();
                }
            }
            $this->fingerprint = md5($data);
            $this->rowExists   = true;

            return true;
        }

        $builder = $this->db->table($this->table)->where('id', $this->idPrefix . $id);

        if ($this->matchIP) {
            $builder = $builder->where('ip_address', $this->ipAddress);
        }

        $updateData = [];

        if ($this->fingerprint !== md5($data)) {
            $updateData['data'] = $this->prepareData($data);
        }

        if (env('DB_DRIVER') == 'sqlsrv') {
            if (! $builder->set('timestamp', 'getdate()', false)->update($updateData)) {
                return $this->fail();
            }
        } else {
            if (! $builder->set('timestamp', 'now()', false)->update($updateData)) {
                return $this->fail();
            }
        }
        $this->fingerprint = md5($data);

        return true;
    }

}