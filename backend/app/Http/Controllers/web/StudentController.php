<?php

namespace App\Http\Controllers\web;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class StudentController extends BaseController
{
    public static function index()
    {
        try {
            $students = Student::select('student_id', 'title', 'forename_1', 'forename_2', 'surname', 'gender', 'date_of_birth', 'username', 'email')->where('deleted_at', null) ->get();
            return $students;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    public static function store(Request $request){
        try{
            $student = new Student();
            $student->student_id = $request->input('student_id');
            $student->title = $request->input('title');
            $student->forename_1 = $request->input('forename_1');
            $student->forename_2 = $request->input('forename_2');
            $student->surname = $request->input('surname');
            $student->gender = $request->input('gender');
            $student->date_of_birth = $request->input('date_of_birth');
            $student->username = $request->input('username');
            $student->email = $request->input('email');
            $student->save();
            return $student;
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    public static function checkStudentExists(Request $request){
        try{
            $student_id = Student::where('student_id',$request->input('student_id'))->first();
            $email = Student::where('email', $request->input('email'))->first();
            $username = Student::where('username', $request->input('username'))->first();
            return $student_id == null && $email == null && $username == null;
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    public static function show(string $id){
        try{
            $student = Student::find($id);
            if($student != null && $student['deleted_at'] == null ){
                $selectedFields = $student ->only(['student_id', 'title', 'forename_1', 'forename_2', 'surname', 'gender', 'date_of_birth', 'username', 'email']);
                return $selectedFields;
            }
            return null;
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    public static function destroy(string $id){
        try{
            $student = Student::find($id);
            if($student != null){
                $student->delete();
                return true;
            }
            return false;
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    public static function update(Request $request, string $id){
        try{
            $student = Student::find($id);
            if($student != null){
                $student->title = $request->input('title');
                $student->forename_1 = $request->input('forename_1');
                $student->forename_2 = $request->input('forename_2');
                $student->surname = $request->input('surname');
                $student->gender = $request->input('gender');
                $student->date_of_birth = $request->input('date_of_birth');
                $student->username = $request->input('username');
                $student->email = $request->input('email');
                $student->save();
                return $student;
            }
            return null;
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }
}
