<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SignUp;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Teacher;

class PassportAuthController extends Controller
{
    /**
     * Student Registration
     */
    public function registerStudent(Request $request)
    {
        $rules = [
            'username' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'useremail' => 'required|min:5|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'password' => 'required|min:6',
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
            // $storeStudentData = Student::insertStudentData($studentData);
            $user = Student::create($studentData);
            $token = $user->createToken('LaravelAuthApp')->accessToken;
            $notify = new SignUp;
            $notify->sendNotification($studentData);
            return response()->json(['token' => $token], 200);
            
        }else{
            return response()->json(['status' => false, "Unsuccessful registartion."], 500);
        }

    }

    /**
     * Teacher Registration
     */
    public function registerTeacher(Request $request)
    {
        $rules = [
            'username' => 'required|min:3|regex:/^[\pL\s]+$/u',
            'useremail' => 'required|min:5|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i|email',
            'password' => 'required|min:6',
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
            $user = Teacher::create($teacherData);
            $token = $user->createToken('LaravelAuthApp')->accessToken;
            $notify = new SignUp;
            $notify->sendNotification($teacherData);
            return response()->json(['token' => $token], 200);
        }else{
            return response()->json(['status' => false, "Unsuccessful registartion."], 500);
        }
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1
        ];
        
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   
}
