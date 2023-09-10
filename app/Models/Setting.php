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
 * @property int $id_user
 * @property int $nbr_seance_limit
 * @property int $nbr_jour_limit
 * @property int $periode_jours
 * @property float|null $w_paper
 * @property float|null $h_paper
 * @property string $colors
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
		'periode_jours' => 'int',
		'w_paper' => 'float',
		'h_paper' => 'float'
	];

	protected $fillable = [
		'id_user',
		'nbr_seance_limit',
		'nbr_jour_limit',
		'periode_jours',
		'w_paper',
		'h_paper',
		'colors'
	];
}
