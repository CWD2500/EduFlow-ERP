<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExameManages;
use App\Models\User;

class HomeController extends Controller
{
    public function home()
    {
        return view('site.home');
    }

    public function login(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'name' => 'required',
            'selectYear' => 'required',
            'semesterStudent' => 'required',
        ]);
    
        $student_id = $request->input('student_id');
        $name = $request->input('name');
        $selectYear = $request->input('selectYear');
        $semesterStudent = $request->input('semesterStudent');
    
        // Query the database for the user with role 'student', student_id, and name
        $user_student = User::where('role', 'student')
                            ->where('student_id', $student_id)
                            ->where('name', $name)
                            ->first();
    
        if ($user_student) {
            // Fetch exams for the student for the selected year
            $exams = ExameManages::where('student_id', $student_id)
                                 ->where('academic_year', $selectYear)
                                 ->where('semester', $semesterStudent)
                                 ->get();
    
            // Pass $exams and $user_student to your view to display them
            return view('site.dashboard', compact('exams', 'user_student', 'selectYear'));
        } else {
            // User does not exist, redirect back with an error message
            return redirect()->back()->withInput()->withErrors(['error' => 'Invalid credentials']);
        }
    }
}
