<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Parente
 *
 * @property int $id_parent
 * @property int $id_eleve
 * @property string|null $type_parent
 * @property string|null $nom_parent_ar
 * @property string|null $prenom_parent_ar
 * @property string|null $prenom_parent_fr
 * @property string|null $nom_parent_fr
 * @property string|null $cin
 * @property string|null $profession
 * @property string|null $tel
 * @property string|null $adresse
 *
 * @property Eleve $eleve
 *
 * @package App\Models
 */
class Parente extends Model
{
	protected $table = 'parentes';
	protected $primaryKey = 'id_parent';
	public $timestamps = false;

	protected $casts = [
		'id_eleve' => 'int'
	];

	protected $fillable = [
		'id_eleve',
		'type_parent',
		'nom_parent_ar',
		'prenom_parent_ar',
		'prenom_parent_fr',
		'nom_parent_fr',
		'cin',
		'profession',
		'tel',
		'adresse'
	];

	public function eleve()
	{
		return $this->belongsTo(Eleve::class, 'id_eleve');
	}
}
