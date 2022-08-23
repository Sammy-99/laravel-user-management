<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_img',
        'address',
        'current_school',
        'previous_school',
        'password',
        'role',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];


    public static function saveUser($data)
    {
        $role = (array_key_exists("experience", $data)) ? 1 : 2 ;

        $data["role"]  = $role;

        $model = new Self;

        if($model->create($data)){
            $userId = Self::select('id')->where('email', $data['email'])->first();
            return $userId->id;
        }

        return false;

    }

    public static function getUsersData($currentTab)
    {
        if($currentTab == "student"){
            $userData = Self::select('users.*', 'students.parents_details', 'students.assigned_teacher')
                                ->join("students", "users.id", "students.user_id")
                                ->where([
                                    "users.role" => 2,
                                    "users.status" => 1
                                ])
                                ->get();

            if(count($userData) > 0){
                return $userData;
            }
            
            return null;
        }

        if($currentTab == "teacher"){
            $userData = Self::select('users.*', 'teachers.experience', 'teachers.expert_in_subj')
                                ->join("teachers", "users.id", "teachers.user_id")
                                ->where([
                                    "users.role" => 1,
                                    "users.status" => 1
                                ])
                                ->get();

            if(count($userData) > 0){
                return $userData;
            }

            return null;
        }

        if($currentTab == "pending-req"){
            $userData = Self::select('users.*', 'students.parents_details', 'teachers.experience', 'teachers.expert_in_subj')
                                ->leftjoin("teachers", "users.id", "teachers.user_id")
                                ->leftjoin("students", "users.id", "students.user_id")
                                ->where([
                                    "users.status" => 0
                                ])
                                ->get();

            if(count($userData) > 0){
                return $userData;
            }

            return null;
        }
    }

    public static function getPendingRequest()
    {
        $userData = Self::select('users.*', 'students.parents_details', 'teachers.experience', 'teachers.expert_in_subj')
                                ->leftjoin("teachers", "users.id", "teachers.user_id")
                                ->leftjoin("students", "users.id", "students.user_id")
                                ->where([
                                    "users.status" => 0
                                ])
                                ->get();

            if(count($userData) > 0){
                return $userData;
            }

            return null;
    }

    public static function getSingleUsersData($user)
    {
        if($user->role == 1){
            $allData = Self::getTeacher($user->id);
        }
        else{
            $allData = Self::getStudent($user->id);
        }

       return $allData;
    }


    public static function getTeacher($user_id){
        $userData = Self::select('users.*', 'teachers.experience', 'teachers.expert_in_subj', 'subjects.subject_name')
                                ->join("teachers", "users.id", "teachers.user_id")
                                ->join("subjects", "subjects.id", "teachers.expert_in_subj")
                                ->where([
                                    "users.id" => $user_id
                                ])
                                ->first();

        return $userData;
           
    }

    public static function getStudent($user_id)
    {
        $userData = Self::select('users.*', 'students.parents_details', 'students.assigned_teacher', 'u.name as teacher')
                            ->join("students", "users.id", "students.user_id")
                            ->leftjoin("users as u", "students.assigned_teacher", "u.id")
                            ->where([
                                "users.id" => $user_id
                            ])
                            ->first();

        return $userData;
    }

    public static function getAllTeacherList()
    {
        $teacher = Self::select('id', 'name')
                        ->where([
                            'status' => 1,
                            'role' => 1
                        ])
                        ->orderBy('name', "ASC")
                        ->get();

        return $teacher;

    }

    public static function updateUser($data, $user_id)
    {
        $update = Self::where('id', $user_id)
                        ->update($data);

        return ($update) ? true : false ;
    }
}
