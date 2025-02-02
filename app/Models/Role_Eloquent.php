<?php

namespace App\Models;

class Role_Eloquent extends BaseModel
{

	protected $table = 't_roles';
	//protected $dateFormat = 'Ymd H:i:s';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'rolename',
		'guard_name', //lowercase
		'description', // optional
		//'level' //optional, set to 1 by default
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'description',
		'guard_name',
		//'level',
		'roleflag'
	];

	protected $appends = ['roleflag'];

	public function getRoleflagAttribute()
	{
		//return date_diff(date_create($this->date_vigency), date_create('now'))->d;
		//https://blog.devgenius.io/how-to-find-the-number-of-days-between-two-dates-in-php-1404748b1e84
		//return date_diff(date_create('now'),date_create($this->date_vigency))->format('%R%a days');return date_diff(date_create('now'),date_create($this->date_vigency))->format('%R%a days');
		if ($this->status) {
			return 'Activo';
		} else {
			return 'Suspendido';
		}
	}

	public static function getRoleOpciones($role_level)
	{
		$opcionesRole = array();
		$opcionesRole[NULL] = 'Seleccione rol';
		$lista = Role_Eloquent::where('id', '>=', $role_level)->select('id', 'rolename')->get();
		foreach ($lista as $registro) {
			$opcionesRole[$registro->id] = $registro->rolename;
		}
		return $opcionesRole;
	}

	public static function all_by_name($rolename)
	{
		$model = Role_Eloquent::where('rolename', '=', $rolename)->first();
		return $model;
	}

	public static function all_filter($field, $value)
	{
		$model = Role_Eloquent::where($field, '=', $value)->get();
		return $model;
	}

	public static function findRecord($id)
	{
		$model = Role_Eloquent::findOrFail('id', $id);
		return $model;
	}

	public static function insertRecord($registro)
	{

		$model = new Role_Eloquent();
		$model->fill($registro);
		$model->save($registro);

		return $model;
	}

	public static function updateRecord($registro)
	{
		$model = Role_Eloquent::findOrFail('id', $registro['id']);
		$model->fill($registro);
		$model->save($registro);
		return $model;
	}

	public static function countRecords()
	{
		$model_count = Role_Eloquent::count();
		return $model_count;
	}
}