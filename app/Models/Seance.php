<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Seance
 *
 * @property int $id_seance
 * @property int|null $id_classe
 * @property int|null $code_jours
 * @property int|null $nbr_seance
 * @property int $s1
 * @property int $s2
 * @property int $s3
 * @property int $s4
 * @property int $s5
 * @property int $s6
 * @property int $s7
 * @property int $s8
 *
 * @property Classe|null $class
 *
 * @package App\Models
 */
class Seance extends Model
{
	protected $table = 'seances';
	protected $primaryKey = 'id_seance';
	public $timestamps = false;

	protected $casts = [
		'id_classe' => 'int',
		'code_jours' => 'int',
		'nbr_seance' => 'int',
		's1' => 'int',
		's2' => 'int',
		's3' => 'int',
		's4' => 'int',
		's5' => 'int',
		's6' => 'int',
		's7' => 'int',
		's8' => 'int'
	];

	protected $fillable = [
		'id_classe',
		'code_jours',
		'nbr_seance',
		's1',
		's2',
		's3',
		's4',
		's5',
		's6',
		's7',
		's8'
	];

	public function classe()
	{
		return $this->belongsTo(Classe::class, 'id_classe');
	}
}
