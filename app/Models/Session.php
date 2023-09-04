<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 *
 * @property int $id_session
 * @property string|null $nom_session
 * @property int|null $annee_session
 * @property int $status_session
 *
 * @property Collection|Classe[] $classes
 * @property Collection|Eleve[] $eleves
 *
 * @package App\Models
 */
class Session extends Model
{
	protected $table = 'sessions';
	protected $primaryKey = 'id_session';
	public $timestamps = false;

	protected $casts = [
		'annee_session' => 'int',
		'status_session' => 'int'
	];

	protected $fillable = [
		'nom_session',
		'annee_session',
		'status_session'
	];

	public function classes()
	{
		return $this->hasMany(Classe::class, 'id_session');
	}

	public function eleves()
	{
		return $this->hasMany(Eleve::class, 'id_session');
	}

    public function information()
	{
		return $this->hasMany(Information::class, 'id_session');
	}
}
