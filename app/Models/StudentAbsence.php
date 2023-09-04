<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAbsence extends Model
{
    // You don't need a table associated with this model since it's used for querying only.

    public static function getStudentAbsencesWithDetails()
    {
        return Eleve::with('absences', 'classe') // Eager loading relationships
            ->get();
    }
}
