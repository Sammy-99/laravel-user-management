<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Teacher extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id',
        'experience',
        'expert_in_subj'
    ];

    public static function insertTeacherData($data)
    {
        $model = new Self;
        return ($model->create($data)) ? true : false ;
    }

    public static function updateTeacherData($data, $id)
    {
        $update = Self::where("user_id", $id)->update($data);

        return ($update) ? true : false ;
    }
}
