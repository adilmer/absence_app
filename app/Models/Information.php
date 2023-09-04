<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Information
 * 
 * @property int $id_info
 * @property string $etablissement
 * @property string|null $academie
 * @property string|null $commune
 * @property string|null $direction
 * @property int $id_session
 * 
 * @property Session $session
 *
 * @package App\Models
 */
class Information extends Model
{
	protected $table = 'informations';
	protected $primaryKey = 'id_info';
	public $timestamps = false;

	protected $casts = [
		'id_session' => 'int'
	];

	protected $fillable = [
		'etablissement',
		'academie',
		'commune',
		'direction',
		'id_session'
	];

	public function session()
	{
		return $this->belongsTo(Session::class, 'id_session');
	}
}
