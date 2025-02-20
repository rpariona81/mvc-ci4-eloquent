<?php

namespace App\Controllers;

use App\Eloquent\Role_Eloquent;
use App\Eloquent\User_Eloquent;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class Home extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $data['info_db'] = $db->getPlatform();
        $data['version_db'] = $db->getConnectDuration(5.2);
        return view('welcome_message', $data);
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
        $roles =Role_Eloquent::all();
        //$data = User_Eloquent::all();
        $data = User_Eloquent::getUsersRoles(1,NULL,NULL);
        return json_encode($data);
        // $db = db_connect();
        // $data['info_db'] = $db->getPlatform();
        // $data['version_db'] = $db->getConnectDuration(5.2);
        //print_r($data);
        //return view('welcome_message',compact(['data','roles']));
    }

    public function infophp()
    {
        phpinfo();
    }

    public function generateExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Sheet 1'); // This is where you set the title 
        $sheet->setCellValue('A1', 'No'); // This is where you set the column header
        $sheet->setCellValue('B1', 'Name'); // This is where you set the column header
        $sheet->setCellValue('C1', 'Email'); // This is where you set the column header
        $row = 2; // Initialize row counter

        $data = User_Eloquent::all();
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item->id);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->email);
            $row++;
        }
        // This is the loop to populate data
        /*for ($i = 1; $i < 5; $i++) {
            $sheet->setCellValue('A' . $row, $i);
            $sheet->setCellValue('B' . $row, "People " . $i);
            $row++;
        }*/
        $writer = new Xlsx($spreadsheet);
        $fileName = "Test.xlsx";
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        $writer->save("php://output");
        exit();
    }
}
