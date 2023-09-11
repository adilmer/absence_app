<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property int $status_user
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon $created_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{

    protected $guarded = [];
	protected $table = 'users';
	public $timestamps = false;

	protected $casts = [
		'email_verified_at' => 'datetime',
        'status_user'=> 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
        'status_user',
		'password',
		'remember_token'
	];
}
