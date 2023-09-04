<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MotifAbsence
 *
 * @property int $id_motif
 * @property string|null $nom_motif
 *
 * @property Collection|Absence[] $absences
 *
 * @package App\Models
 */
class MotifAbsence extends Model
{
	protected $table = 'motif_absences';
	protected $primaryKey = 'id_motif';
	public $timestamps = false;

	protected $fillable = [
		'nom_motif'
	];

	public function absences()
	{
		return $this->hasMany(Absence::class, 'status_absence');
	}
}
