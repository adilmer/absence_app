<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id_notif
 * @property string $titre_notif
 * @property string $message_notif
 * @property int $status_notif
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';
	protected $primaryKey = 'id_notif';
	public $timestamps = false;

	protected $casts = [
		'status_notif' => 'int'
	];

	protected $fillable = [
		'titre_notif',
		'message_notif',
		'status_notif'
	];
}
