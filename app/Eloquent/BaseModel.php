<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Capsule\Manager as DB;

//https://stackoverflow.com/questions/41331137/how-to-set-language-for-carbon
setlocale(LC_TIME, 'es_ES');
Carbon::setLocale('es');

class BaseModel extends Model
{
	//
	//https://gist.github.com/Ademking/d6132680539af6e9ccaab6c5fc6e0619
	//https://stackoverflow.com/questions/49999319/error-converting-nvarchar-to-datetime-data-type-using-laravel-and-mssql
	//https://stackoverflow.com/questions/35457412/laravel-sqlsrv-unable-to-create-timestamps

	

	// Fix SQL server date format 
	// Only for MSSQL
	public function fromDateTime($value)
	{
		if (env('DB_DRIVER') == 'sqlsrv') {
			return Carbon::parse(parent::fromDateTime($value))->format('Y-m-d H:i:s');
		}
		return $value;
	}
}
