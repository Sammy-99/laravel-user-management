<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;

class UserController extends Controller
{
    public function show(Request $request, $id = null)
    {
        $user = auth()->user(); 

        if($user->role == 0){

            $list = ($id != null) ? User::find($id) : $list = USer::all();
            
            if($list != null){
                return response()->json([
                    "status" => true,
                    "message" => "Users Data Found",
                    "userList" => $list 
                ], 200);
            }

            return response()->json([
                "status" => false,
                "message" => "Users not exist" 
            ], 400);

        }

        if($user->role == 1 && $user->status == 1){

            $teacher = User::getTeacher($user->id);

            return response()->json([
                "status" => true,
                "message" => "User Data Found",
                "user" => $teacher
            ], 200);
        }

        if($user->role == 2 && $user->status == 1){

            $student = User::getStudent($user->id);

            return response()->json([
                "status" => true,
                "message" => "User Data Found",
                "user" => $student
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        
        if($user->id != $id || empty(trim($id))){
            return response()->json([
                "status" => false,
                "message" => "Unauthorized Attempt"
            ], 401);
        }
        
        if($user->role == 1){
            $update = $this->updateTeacher($request, $id);
        }

        if($user->role == 2){
            $update = $this->updateStudent($request, $id);
        }

        if($update){
            return response()->json([
                "status" => true,
                "message" => "Data Updated"
            ], 200);
        }

        return response()->json([
            "status" => false,
            "message" => "Data not Updated"
        ], 500);
    }

    public function updateTeacher($request, $id)
    {
        $rules = [
            'name' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'email' => 'required|min:5|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'updated_user_mage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'experience' => 'required|numeric',
        ];
    
        $customMessages = [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'updated_user_mage.image' => 'File mnust be an image',
            'address.required' => 'Please enter your address',
            'experience.required' => 'Please enter your parent details name'
        ];

        $this->validate($request, $rules, $customMessages);
        
        if($request->hasFile('updated_user_mage')){
            $file = $request->file('updated_user_mage');
            $imageName = time() . '-' . $file->getClientOriginalName();
            $moveFile = $file->move(public_path('uploads'), $imageName);
            
        }
        
        $teacherData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'current_school' => $request->c_school,
            'previous_school' => $request->p_school
        ];
        
        if($request->hasFile('updated_user_mage')){
            $teacherData['user_img'] = $imageName;
        }

        $updateUser = User::updateUser($teacherData, $id);

        if($updateUser){
            $teacherData = ["experience" => $request->experience];
            $storeTeacherData = Teacher::updateTeacherData($teacherData, $id);

            return ($storeTeacherData) ? true : false ;

        }
        return false ;
    }

    public function updateStudent($request, $id)
    {
        $rules = [
            'name' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'email' => 'required|min:5|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'updated_user_mage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'c_school' => 'required',
            'p_school' => 'required',
            'parents_details' => 'required',
        ];
    
        $customMessages = [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'updated_user_mage.image' => 'File mnust be an image',
            'address.required' => 'Please enter your address',
            'c_school.required' => 'Please enter your current school',
            'p_school.required' => 'Please enter your previous school',
            'parents_details.required' => 'Please enter your parent details name'
        ];

        $this->validate($request, $rules, $customMessages);
        
        if($request->hasFile('updated_user_mage')){
            $file = $request->file('updated_user_mage');
            $imageName = time() . '-' . $file->getClientOriginalName();
            $moveFile = $file->move(public_path('uploads'), $imageName);
            
        }

        $studentData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'current_school' => $request->c_school,
            'previous_school' => $request->p_school
        ];

        if($request->hasFile('updated_user_mage')){
            $studentData['user_img'] = $imageName;
        }

        $updateUser = User::updateUser($studentData, $id);

        if($updateUser){
            $storeStudentData = Student::updateStudentData($request->parents_details, $id);
            return ($storeStudentData) ? true : false ;
        }

        return false;
    }

    public function delete(Request $request, $id)
    {
        $user = auth()->user();

        if($user->role != 0 || empty(trim($id))){
            return response()->json([
                "status" => false,
                "message" => "Unauthorized Attempt"
            ], 401);
        }

        $userData = User::find($id);

        if($userData->role == 1){
            $deleteUser = User::where('id', $id)->delete();

            if($deleteUser){
                Teacher::where('user_id', $id)->delete();

                return response()->json([
                    "status" => true,
                    "message" => "User Data Deleted"
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Not Deleted"
            ], 500);

        }
        else{

            $deleteUser = User::where('id', $id)->delete();

            if($deleteUser){
                Student::where('user_id', $id)->delete();

                return response()->json([
                    "status" => true,
                    "message" => "User Data Deleted"
                ], 200);
            }
            return response()->json([
                "status" => false,
                "message" => "Not Deleted"
            ], 500);
        }
    }
}
