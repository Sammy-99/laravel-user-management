<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Subject extends Controller
{
    public function getSubjects(Request $req)
    {
        $html = '';
        $subjects = DB::table('subjects')
                        ->select('id', 'subject_name')
                        ->where('status', 1)
                        ->get();

        foreach($subjects->toArray() as $key=>$value){
            $html .= "<option value='". $value->id ."'> " . $value->subject_name . " </option>";
        }

        return response()->json(['status' => true, 'subjects' => $html, "message" => "Subjects Found"]);
    }
}
