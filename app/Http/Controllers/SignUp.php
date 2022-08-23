<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CreateAccountRequest;

class SignUp extends Controller
{
    public function index()
    {
        return view('signup.student-signup');
    }

    public function getStudentData(Request $request)
    {
        
        $rules = [
            'username' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'useremail' => 'required|min:5|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'password' => 'required|min:6|confirmed',
            'user-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user-address' => 'required',
            'current-school' => 'required',
            'previous-school' => 'required',
            'parents-details' => 'required',
        ];
    
        $customMessages = [
            'username.required' => 'Please enter your name',
            'useremail.required' => 'Please enter your email',
            'password.required' => 'Please enter your password',
            'user-image.required' => 'Please choose profile picture',
            'user-address.required' => 'Please enter your address',
            'current-school.required' => 'Please enter your current school',
            'previous-school.required' => 'Please enter your previous school',
            'parents-details.required' => 'Please enter your parent details name'
        ];

        $this->validate($request, $rules, $customMessages);

        $file = $request->file('user-image');
        $imageName = time() . '-' . $file->getClientOriginalName();
        $moveFile = $file->move(public_path('uploads'), $imageName);

        $studentData = [
            'name' => $request->input('username'),
            'email' => $request->input('useremail'),
            'password' => Hash::make($request->password),
            'user_img' => $imageName,
            'address' => $request->input('user-address'),
            'current_school' => $request->input('current-school'),
            'previous_school' => $request->input('previous-school'),
            'parents_details' => $request->input('parents-details'),
            'status' => 0
        ];

        $saveUser = User::saveUser($studentData);

        if($saveUser){
            $studentData['user_id'] = $saveUser;
            $storeStudentData = Student::insertStudentData($studentData);
            $this->sendNotification($studentData);
            return redirect()->back()->with('success', 'Thank you, We are sending your request to admin. We will inform you once its approved by admin.');
            
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }
    
    }

    public function getTeacherData(Request $request)
    {
        $rules = [
            'username' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'useremail' => 'required|min:5|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'password' => 'required|min:6|confirmed',
            'user-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user-address' => 'required',
            'experience' => 'required|numeric',
            'expertise' => 'regex:/^[1-9]+$/i'
        ];

        $customMessages = [
            'username.required' => 'Please enter your name',
            'useremail.required' => 'Please enter your email',
            'password.required' => 'Please enter your password',
            'user-image.required' => 'Please choose profile picture',
            'user-address.required' => 'Please enter your address',
            'experience.required' => 'Please enter your experience',
            'expertise.regex' => 'Please select your subject'
        ];

        $this->validate($request, $rules, $customMessages);

        $file = $request->file('user-image');
        $imageName = time() . '-' . $file->getClientOriginalName();
        $moveFile = $file->move(public_path('uploads'), $imageName);

        $teacherData = [
            'name' => $request->input('username'),
            'email' => $request->input('useremail'),
            'password' => Hash::make($request->password),
            'user_img' => $imageName,
            'address' => $request->input('user-address'),
            'current_school' => $request->input('current-school'),
            'previous_school' => $request->input('previous-school'),
            'experience' => $request->input('experience'),
            'expert_in_subj' => $request->input('expertise'),
            'status' => 0
        ];

        $saveUser = User::saveUser($teacherData);
        
        if($saveUser){
            $teacherData['user_id'] = $saveUser;
            $storeTeacherData = Teacher::insertTeacherData($teacherData);
            $this->sendNotification($teacherData);
            return redirect()->back()->with('success', 'Thank you, We are sending your request to admin. We will inform you once its approved by admin.');
        }else{
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }

    public function sendNotification($data)
    {
        $admin = User::where('role', 0)->first();

        $data['type'] = (array_key_exists('experience', $data)) ? 'Teacher' : 'Student' ;
        
        Notification::send($admin, new CreateAccountRequest($data));
        
        return true;
    }
}
