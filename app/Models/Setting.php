<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 *
 * @property int $id_setting
 * @property int|null $id_user
 * @property int $nbr_seance_limit
 * @property int $nbr_jour_limit
 * @property int $periode_jours
 *
 * @package App\Models
 */
class Setting extends Model
{
	protected $table = 'settings';
	protected $primaryKey = 'id_setting';
	public $timestamps = false;

	protected $casts = [
		'id_user' => 'int',
		'nbr_seance_limit' => 'int',
		'nbr_jour_limit' => 'int',
		'periode_jours' => 'int'
	];

	protected $fillable = [
		'id_user',
		'nbr_seance_limit',
		'nbr_jour_limit',
		'colors',
		'periode_jours'
	];
}
