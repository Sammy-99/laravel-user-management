<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User as UserModel;

class User extends Controller
{
    public function getDashboardData(Request $request)
    {
        if($request->session()->has('email')){
            $email = $request->session()->get('email');
            $userData = UserModel::where('email', $email)->first();
        }
        
        if($userData->role == 0){
            return view('dashboard.admindashboard');
        }
        if($userData->role == 1 && $userData->status == 1){
            $getUserRelation = UserModel::getTeacher($userData->id);
        }
        if($userData->role == 2 && $userData->status == 1){
            $getUserRelation = UserModel::getStudent($userData->id);
        }
        
        if($getUserRelation != null){
            $data = [
                'userRole' => $userData->role,
                'userData' => $getUserRelation
            ];
            
            return view('dashboard.dashboard', $data);
        }
    }

    public function updateStudentData(Request $request, $id)
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

        $updateUser = UserModel::updateUser($studentData, $id);

        if($updateUser){
            $storeStudentData = Student::updateStudentData($request->parents_details, $id);
            return redirect()->back()->with('success', 'Your Profile Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Profile not updated for some reasons');
        }
    }

    public function updateTeacherData(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'email' => 'required|min:5|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'updated_user_mage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required',
            'c_school' => 'required',
            'p_school' => 'required',
            'experience' => 'required|numeric',
        ];
    
        $customMessages = [
            'name.required' => 'Please enter your name',
            'email.required' => 'Please enter your email',
            'updated_user_mage.image' => 'File mnust be an image',
            'address.required' => 'Please enter your address',
            'c_school.required' => 'Please enter your current school',
            'p_school.required' => 'Please enter your previous school',
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

        $updateUser = UserModel::updateUser($teacherData, $id);

        if($updateUser){
            $teacherData = [
                "experience" => $request->experience
            ];
            $storeTeacherData = Teacher::updateTeacherData($teacherData, $id);
            return redirect()->back()->with('success', 'Your Profile Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Profile not updated for some reasons');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('signin');
    }
}
