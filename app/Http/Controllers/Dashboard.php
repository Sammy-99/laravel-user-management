<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestApproved;
use App\Notifications\AssignTeacher;

class Dashboard extends Controller
{
    public function getUsersData(Request $req)
    {
        if($req->current_tab != null || !empty($req->current_tab)){
            $userData = User::getUsersData($req->current_tab);

            if($userData != null){
                $html = $this->createHtml($userData);
                return json_encode(["status" => true, "message" => "Data found", "data" => $html, "count" => count($userData)]);
            }

            return json_encode(["status" => false, "message" => "No data found"]);
        }
    }

    public function createHtml($data)
    {
        $html = '';
        $i = 1;

        $html .= '<table class="table table-hover" id="datatable">';
        $html .= '<thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Type</th>
                        <th scope="col">Requested On</th>
                        <th scope="col"></th>
                    </tr></thead>';
        $html .= '<tbody>';
        
        foreach($data as $val){
            $type = ($val->role == 1) ? "Teacher" : "Student" ;
            $html .= '<tr>
                        <th scope="row">'.$i.'<input type="hidden" value="'.$val->id.'"></th>
                        <td>'. $val->name .'</td>
                        <td>'. $val->email .'</td>
                        <td>'. $type .'</td>
                        <td>'. $val->created_at .'</td>';
            if($val->status == 0){
                $html .='<td>
                            <button type="button" id="approve" class="btn btn-outline-success btn-sm action-btn" value="'.$val->id.'">Approve</button>
                            <button type="button" id="delete" class="btn btn-outline-danger btn-sm action-btn" value="'.$val->id.'">Delete</button>
                        </td>';                
            }else{
                $html .= '<td><button type="button" id="delete" class="btn btn-outline-danger btn-sm action-btn" value="'.$val->id.'">Delete</button></td>';
            }
            $html .= '</tr>';
            
            $i++;
        }

        $html .= '</tbody></table>';
        return $html;
    }

    public function getSingleUsersData(Request $req)
    {
        if($req->user_id != null || !empty($req->user_id)){
            $user = User::find($req->user_id);
            $userData = User::getSingleUsersData($user);

            if($user->role == 2){

                $allTeacher = User::getAllTeacherList();
                $teacherhtml = $this->teacherNameHtml($allTeacher);
                
                return json_encode(["status" => true, "message" => "Data found with Teachers", "data" => $userData->toArray(), "teachers" => $teacherhtml]);
            }

            return json_encode(["status" => true, "message" => "Data found", "data" => $userData->toArray()]);
        }

        return json_encode(["status" => false, "message" => "Data not found"]);
    }

    public function teacherNameHtml($data)
    {
        $html = '';
        if(count($data) > 0){
            $html .= "<option selected value=''>Select Teacher</option>";
            foreach($data as $teacher){
                $html .= "<option value='". $teacher->id ."'> " . $teacher->name . " </option>";
            }

            return $html;
        }

        return $html;
    }

    public function assignTeacher(Request $req)
    {
        if(!empty($req->current_stu) && !empty($req->teacher)){
            $assignTeacher = Student::assignTeacher($req->current_stu, $req->teacher);
            if($assignTeacher){
                $this->sendNotificationToTeacher($req->current_stu, $req->teacher);
                return json_encode(["status" => true, "message" => "Teacher Assigned"]);
            }
            
            return json_encode(["status" => false, "message" => "Something went wrong"]);
        }
    }

    public function actionOnUserRequest(Request $req)
    {
        if(!empty($req->user_id) || $req->user_id != null){

            if($req->id == "approve"){
                $approveReq = User::where('id', $req->user_id)->update(['status' => 1]);
                if($approveReq){
                    $this->sendNotification($req->user_id);
                    return json_encode(["status" => true, "type" => "request_approved"]);
                }

                return json_encode(["status" => false, "type" => "request_not_approved"]);
            }

            if($req->id == "delete"){
                $deleteReq = User::where('id', $req->user_id)->delete();
                if($deleteReq){
                    return json_encode(["status" => true, "type" => "request_deleted"]);
                }

                return json_encode(["status" => false, "type" => "request_not_deleted"]);
            }
        }
    }

    public function getPendingRequest()
    {
        $pendingRequest = User::getPendingRequest();
        $count = ($pendingRequest != null) ? count($pendingRequest) : null ;

        return json_encode(["status" => true, "data" => $count]);
    }

    public function sendNotification($user_id)
    {
        $user = User::where('id', $user_id)->first();
        Notification::send($user, new RequestApproved($user->toArray()));
        
        return true;
    }

    public function sendNotificationToTeacher($student_id, $teacher_id)
    {
        $studentData = User::where('id', $student_id)->first();
        $teacherData = User::where('id', $teacher_id)->first();

        Notification::send($teacherData, new AssignTeacher($studentData->toArray(), $teacherData->id));

        return true;
    }
}
