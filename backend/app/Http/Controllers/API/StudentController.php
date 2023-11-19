<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\web\StudentController as WebStudentController;
use App\Http\Controllers\Controller as BaseController;

class StudentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $students = WebStudentController::index();
            if($students->count() > 0) {

                return response()->json([
                    'status' => 200,
                    'students' => $students,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No students found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'in:'. implode(',', array('Dr','Mr', 'Mrs', 'Ms', 'Mx', 'Professor')),
                'forename_1' => 'string|max:100',
                'forename_2' => 'string|max:100',
                'surname' => 'required|string|max:100',
                'gender' => 'required|in:'. implode(',', array('Male', 'Female', 'Other')),
                'date_of_birth' => 'required|date',
                'username' => 'required|string|max:6',
                'email' => 'required|email|max:255',
            ]);
            if($validator->fails()){
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->messages(),
                ], 422);
            }else{
                $studentExists = WebStudentController::checkStudentExists($request);
                if($studentExists){
                    $student_id = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
                    $request-> merge(['student_id' => $student_id]);
                    $student = WebStudentController::store($request);
                    return response()->json([
                        'status' => 200,
                        'message' => 'Student created successfully with ID : '.$student_id
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 409,
                        'message' => 'Student already exists with ID or email or username'
                    ], 409);
                }
            }
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            if(strlen($id) == 8){
                $student = WebStudentController::show($id);
                if($student != null){
                    return response()->json([
                        'status' => 200,
                        'student' => $student,
                    ], 200);
                }else{
                    return response()->json([
                        'status' => 404,
                        'message' => 'Student not found',
                    ], 404);
                }
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'The student ID must be 8 digits',
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            if(strlen($id) == 8){
                $validator = Validator::make($request->all(), [
                    'title' => 'in:'. implode(',', array('Dr','Mr', 'Mrs', 'Ms', 'Mx', 'Professor')),
                    'forename_1' => 'string|max:100',
                    'forename_2' => 'string|max:100',
                    'surname' => 'required|string|max:100',
                    'gender' => 'required|in:'. implode(',', array('Male', 'Female', 'Other')),
                    'date_of_birth' => 'required|date',
                    'username' => 'required|string|max:6',
                    'email' => 'required|email|max:255',
                ]);
                if($validator->fails()){
                    return response()->json([
                        'status' => 422,
                        'errors' => $validator->messages(),
                    ], 422);
                }else{
                    $student = WebStudentController::update($request, $id);
                    if($student){
                        return response()->json([
                            'status' => 200,
                            'message' => 'Student updated successfully with ID : '.$id,
                            'student' => $student
                        ], 200);
                    }
                    return response()->json([
                        'status' => 404,
                        'message' => 'Student not found with ID : '.$id,
                    ], 404);
                }
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'The student ID must be 8 digits',
                ]);
            }
        }  catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            if(strlen($id) == 8){
                $student = WebStudentController::destroy($id);
                if($student){
                    $students = WebStudentController::index();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Student deleted successfully with ID : '.$id,
                        'students' => $students
                    ], 200);
                }
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found with ID : '.$id,
                ], 404);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'The student ID must be 8 digits',
                ], 404);
            }
        }catch(\Exception $e){
            return response()->json(['error' => 'Error occurred : '.$e->getMessage()], 500);
        }
    }
}
