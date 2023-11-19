<?php

namespace App\Http\Controllers\web;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class StudentController extends BaseController
{
    /**
     * Retrieves all students from the database.
     *
     * @throws \Exception if an error occurs during the retrieval process.
     * @return array|null An array of student objects or null if an error occurred.
     */
    public static function index()
    {
        try {
            $students = Student::select('student_id', 'title', 'forename_1', 'forename_2', 'surname', 'gender', 'date_of_birth', 'username', 'email')->where('deleted_at', null) ->get();
            return $students;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    /**
     * Store a new student record.
     *
     * @param Request $request The request object containing the student data.
     * @throws \Exception if an error occurs during the storage process.
     * @return Student The newly created student record.
     */
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

    /**
     * Checks if a student exists in the database based on the given request.
     *
     * @param Request $request The request object containing the student information.
     * @throws \Exception If an error occurs while checking the student existence.
     * @return bool Returns true if the student does not exist, false otherwise.
     */
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

    /**
     * Retrieve and return the specified student's details.
     *
     * @param string $id The ID of the student to retrieve.
     * @throws \Exception If an error occurs during the retrieval process.
     * @return array|null The selected fields of the student if found, or null if not found.
     */
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

    /**
     * Deletes a student record from the database.
     *
     * @param string $id The ID of the student record to delete.
     * @throws \Exception If an error occurred during the deletion process.
     * @return bool Returns true if the student record was successfully deleted, false otherwise.
     */
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

    /**
     * Updates a student record in the database.
     *
     * @param Request $request The HTTP request object.
     * @param string $id The ID of the student record to update.
     * @return Student|null The updated student record, or null if the record does not exist.
     * @throws \Exception if an error occurs during the update process.
     */
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
