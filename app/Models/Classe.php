<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classe
 *
 * @property int $id_classe
 * @property string|null $nom_classe_ar
 * @property string|null $nom_classe_fr
 *
 * @property Collection|Eleve[] $eleves
 * @property Seance $seance
 *
 * @package App\Models
 */
class Classe extends Model
{
	protected $table = 'classes';
	protected $primaryKey = 'id_classe';
	public $timestamps = false;

	protected $fillable = [
		'nom_classe_ar',
		'nom_classe_fr'
	];

	public function session()
	{
		return $this->belongsTo(Session::class, 'id_session');
	}

	public function eleves()
	{
		return $this->hasMany(Eleve::class, 'id_classe');
	}

	public function seance()
	{
		return $this->hasOne(Seance::class, 'id_classe');
	}
}
