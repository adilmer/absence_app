<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Absence
 *
 * @property int $id_absence
 * @property int|null $id_eleve
 * @property Carbon|null $date
 * @property int $h1
 * @property int $h2
 * @property int $h3
 * @property int $h4
 * @property int $h5
 * @property int $h6
 * @property int $h7
 * @property int $h8
 * @property int $status_absence
 * @property int $total_seances
 * @property int $total_jours
 *
 * @property MotifAbsence|null $motif_absence
 * @property Eleve|null $eleve
 *
 * @package App\Models
 */
class Absence extends Model
{
	protected $table = 'absences';
	protected $primaryKey = 'id_absence';
	public $timestamps = false;

	protected $casts = [
		'id_eleve' => 'int',
		'date' => 'datetime',
		'h1' => 'int',
		'h2' => 'int',
		'h3' => 'int',
		'h4' => 'int',
		'h5' => 'int',
		'h6' => 'int',
		'h7' => 'int',
		'h8' => 'int',
		'status_absence' => 'int',
		'total_seances' => 'int',
		'total_jours' => 'int'
	];

	protected $fillable = [
		'id_eleve',
		'date',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'h7',
		'h8',
		'status_absence',
		'total_seances',
		'total_jours'
	];
    public function motif_absence()
	{
		return $this->belongsTo(MotifAbsence::class, 'status_absence');
	}

	public function eleve()
	{
		return $this->belongsTo(Eleve::class, 'id_eleve');
	}

	public function classe()
	{
		return $this->hasMany(Eleve::class, 'id_eleve')->classe;
	}
}
