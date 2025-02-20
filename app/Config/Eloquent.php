<?php

namespace Config;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Events\Dispatcher;
use PDO;

/**
 * https://faroti.com/blog/2020/07/06/how-to-integrate-laravel-eloquent-orm-in-codeigniter-4/
 */
class Eloquent
{

    function __construct()
    {

        $options = [];
        $trust_server_certificate = NULL;
        if (env('DB_DRIVER') == 'sqlsrv') {
            $options = array(
                PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE => true,
                PDO::SQLSRV_ATTR_QUERY_TIMEOUT => 60,
                PDO::SQLSRV_ATTR_FETCHES_DATETIME_TYPE => true
            );
        } else {
            $options = array(
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
        }

        $capsule = new Capsule;
        $db_config = config('Database');
        // // DBDriver
        $capsule->addConnection([
            //'driver'    => 'mysql', // $db_config->default['DBDriver']
            /*'driver'    => $db_config->default['DBConnect'],
            'host'      => $db_config->default['hostname'],
            'database'  => $db_config->default['database'],
            'username'  => $db_config->default['username'],
            'password'  => $db_config->default['password'],
            'charset'  =>  $db_config->default['charset'],
            'collation' => $db_config->default['DBCollat'],
            'prefix'    => $db_config->default['DBPrefix'],
            'port'      => $db_config->default['port'],
            'options' => $options,
            */
            'driver' => env('DB_DRIVER', 'mysql'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'encrypt' => env('DB_ENCRYPT', 'yes'),
            'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
            'options' => $options,
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        Relation::morphMap([]);
    }
}
