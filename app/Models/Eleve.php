<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Parente;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Eleve
 *
 * @property int $id_eleve
 * @property int|null $num_eleve
 * @property string|null $mat
 * @property int|null $id_classe
 * @property int|null $id_session
 * @property string|null $nom_ar
 * @property string|null $nom_fr
 * @property string|null $prenom_ar
 * @property string|null $prenom_fr
 * @property Carbon|null $date_naiss
 * @property string|null $lieu_naiss_fr
 * @property string|null $lieu_naiss_ar
 * @property string|null $sexe
 * @property int $status_eleve
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Session|null $session
 * @property Classe|null $class
 * @property Collection|Absence[] $absences
 * @property Collection|Parente[] $parentes
 *
 * @package App\Models
 */
class Eleve extends Model
{
	protected $table = 'eleves';
	protected $primaryKey = 'id_eleve';

	protected $casts = [
		'num_eleve' => 'int',
		'id_classe' => 'int',
		'id_session' => 'int',
		'id_user' => 'int',
		'date_naiss' => 'datetime',
		'status_eleve' => 'int'
	];

	protected $fillable = [
		'num_eleve',
		'mat',
		'id_classe',
		'id_session',
		'id_user',
		'nom_ar',
		'nom_fr',
		'prenom_ar',
		'prenom_fr',
		'date_naiss',
		'lieu_naiss_fr',
		'lieu_naiss_ar',
		'sexe',
		'status_eleve'
	];

	public function session()
	{
		return $this->belongsTo(Session::class, 'id_session');
	}
    public function user()
	{
		return $this->belongsTo(User::class, 'id_user');
	}
	public function classe()
	{
		return $this->belongsTo(Classe::class, 'id_classe');
	}

	public function absences()
	{
		return $this->hasMany(Absence::class, 'id_eleve');
	}
    public function parentes()
	{
		return $this->hasMany(Parente::class, 'id_eleve');
	}
}
