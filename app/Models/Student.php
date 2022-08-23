<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;
use Laravel\Passport\HasApiTokens;

class Student extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'parents_details'
    ];

    public static function insertStudentData($data)
    {
        $model = new Self;
        return ($model->create($data)) ? true : false ;
    }

    public static function assignTeacher($student_id, $teacher_id)
    {
        $update = Self::where('user_id', $student_id)
                        ->update([
                            'assigned_teacher' => $teacher_id,
                        ]);

        return ($update) ? true : false ;

    }

    public static function updateStudentData($parentsDetails, $id)
    {
        $update = Self::where('user_id', $id)
                        ->update([
                            'parents_details' => $parentsDetails,
                        ]);

        return ($update) ? true : false ;
    }
}
