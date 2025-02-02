<?php

namespace Config;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Events\Dispatcher;

/**
 * https://faroti.com/blog/2020/07/06/how-to-integrate-laravel-eloquent-orm-in-codeigniter-4/
 */
class Eloquent
{

    function __construct()
    {

        $capsule = new Capsule;
        $db_config = config('Database');
        // // DBDriver
        $capsule->addConnection([
            //'driver'    => 'mysql', // $db_config->default['DBDriver']
            'driver'    => $db_config->default['DBConnect'],
            'host'      => $db_config->default['hostname'],
            'database'  => $db_config->default['database'],
            'username'  => $db_config->default['username'],
            'password'  => $db_config->default['password'],
            'charset'  =>  $db_config->default['charset'],
            'collation' => $db_config->default['DBCollat'],
            'prefix'    => $db_config->default['DBPrefix']
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        Relation::morphMap([
		]);
    }
}
