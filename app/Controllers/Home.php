<?php

namespace App\Controllers;

use App\Models\Role_Eloquent;
use App\Models\User_Eloquent;

class Home extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $data['info_db'] = $db->getPlatform();
        $data['version_db'] = $db->getConnectDuration(5.2);
        return view('welcome_message',$data);
    }

    public function hola()
    {
        $db = db_connect();
        $data['info_db'] = $db->getPlatform();
        $data['version_db'] = $db->getConnectDuration(5.2);
        print_r($data);
    }

    public function listUsers()
    {
        //$data =Role_Eloquent::all();
        $data =User_Eloquent::all();
        return json_encode($data);
    }
}
