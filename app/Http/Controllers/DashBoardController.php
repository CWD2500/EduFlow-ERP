<?php

namespace App\Http\Controllers;

use App\Models\ExameManages;
use App\Models\User;
use App\Models\Subject;
use App\Models\Objection;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{


    public function index() {
        $user_student = User::where('role', 'student')->get();
        $user_student_prog = User::where('role', 'student')->where('specializations_id', 'قسم البرمجة')->get();
        $user_student_network = User::where('role', 'student')->where('specializations_id', 'قسم الشبكات')->get();
        $user_student_mani = User::where('role', 'student')->where('specializations_id', 'قسم الصيانة')->get();
        $user_teacher = User::where('role', 'teacher')->get();
        $exame_manages = ExameManages::all();
        $subject = Subject::all();
        $objection = Objection::where('is_hidden' , false)->get();
    
        $count_student = $user_student->count();
        $count_student_prog = $user_student_prog->count();
        $count_student_net = $user_student_network->count();
        $count_student_main = $user_student_mani->count();
        $count_teacher = $user_teacher->count();
        $count_exame_manage = $exame_manages->count();
        $count_subject = $subject->count();
        $objection_count = $objection->count();
    
        $count_successful_students = 0;
        $count_failed_students = 0;


     
    
        //  الطلاب الناجحون
        foreach ($exame_manages as $exam) {
            // Calculate total degree and exam scores
            $total_degree = $exam->degree_n + $exam->degree_p;
            $total_exam = $exam->exam_n + $exam->exam_p;
            $total = $total_exam + $exam->exam_p;
    
            // Check if student is successful or failed
            if ($total_degree >= 24 ) {
                if($total >=60)
                {
                    $count_successful_students++;
                }else
                {
                    $count_failed_students++;
                }
              
            } else {
                $count_failed_students++;
            }
        }
    
        // احصاء عدد الطلاب الناجحين والراسبين لكل سنة في كل تخصص
        $success_counts = [
            'programming' => ['year1' => 0, 'year2' => 0],
            'networking' => ['year1' => 0, 'year2' => 0],
            'maintenance' => ['year1' => 0, 'year2' => 0],
        ];
        
        $fail_counts = [
            'programming' => ['year1' => 0, 'year2' => 0],
            'networking' => ['year1' => 0, 'year2' => 0],
            'maintenance' => ['year1' => 0, 'year2' => 0],
        ];
        
        // اجمالي عدد الطلاب لكل سنة في كل تخصص
        $total_counts = [
            'programming' => ['year1' => 0, 'year2' => 0],
            'networking' => ['year1' => 0, 'year2' => 0],
            'maintenance' => ['year1' => 0, 'year2' => 0],
        ];
    
        foreach ($exame_manages as $exam) {
            $total_degree = $exam->degree_n + $exam->degree_p;
            $total_exam = $exam->exam_n + $exam->exam_p;
            $total = $total_degree + $total_exam;
    
            $year = $exam->academic_year == 'السنة الاولى' ? 'year1' : 'year2';
    
            // تحويل specializations_id إلى اسماء المفاتيح المستخدمة في المصفوفات
            $specialization = '';
            switch ($exam->specializations_id) {
                case 'قسم البرمجة':
                    $specialization = 'programming';
                    break;
                case 'قسم الشبكات':
                    $specialization = 'networking';
                    break;
                case 'قسم الصيانة':
                    $specialization = 'maintenance';
                    break;
            }
    
            if ($specialization) {
                // زيادة عدد الطلاب في التخصص والسنة
                $total_counts[$specialization][$year]++;
                
                if ($total_degree >= 24 && $total >= 60) {
                    $success_counts[$specialization][$year]++;
                } else {
                    $fail_counts[$specialization][$year]++;
                }
            }
        }
    
        // حساب النسبة المئوية للطلاب الناجحين والراسبين
        $success_percentages = [
            'programming' => ['year1' => 0, 'year2' => 0],
            'networking' => ['year1' => 0, 'year2' => 0],
            'maintenance' => ['year1' => 0, 'year2' => 0],
        ];
        
        $fail_percentages = [
            'programming' => ['year1' => 0, 'year2' => 0],
            'networking' => ['year1' => 0, 'year2' => 0],
            'maintenance' => ['year1' => 0, 'year2' => 0],
        ];
    
        foreach ($total_counts as $specialization => $years) {
            foreach ($years as $year => $total) {
                if ($total > 0) {
                    $success_percentages[$specialization][$year] = ($success_counts[$specialization][$year] / $total) * 100;
                    $fail_percentages[$specialization][$year] = ($fail_counts[$specialization][$year] / $total) * 100;
                }
            }
        }
    
        return view('dashBoard.home', compact(
            'count_student', 'count_teacher', 'count_exame_manage',
            'count_successful_students', 'count_failed_students',
            'count_subject', 'objection_count',
            'count_student_prog', 'count_student_net', 'count_student_main',
            'success_counts', 'fail_counts',
            'success_percentages', 'fail_percentages'
        ));
    }
    

//     public function index() {
//         $user_student = User::where('role', 'student')->get();
//         $user_student_prog = User::where('role', 'student')->where('specializations_id', 'قسم البرمجة')->get();
//         $user_student_network = User::where('role', 'student')->where('specializations_id', 'قسم الشبكات')->get();
//         $user_student_mani = User::where('role', 'student')->where('specializations_id', 'قسم الصيانة')->get();
//         $user_teacher = User::where('role', 'teacher')->get();
//         $exame_manages = ExameManages::all();
//         $subject = Subject::all();
//         $objection = Objection::all();
    
//         $count_student = $user_student->count();
//         $count_student_prog = $user_student_prog->count();
//         $count_student_net = $user_student_network->count();
//         $count_student_main = $user_student_mani->count();
//         $count_teacher = $user_teacher->count();
//         $count_exame_manage = $exame_manages->count();
//         $count_subject = $subject->count();
//         $objection_count = $objection->count();
    

//         $count_successful_students = 0;
//         $count_failed_students = 0;
    
//         //  الطلاب الناجحون
//         foreach ($exame_manages as $exam) {
//             // Calculate total degree and exam scores
//             $total_degree = $exam->degree_n + $exam->degree_p;
//             $total_exam = $exam->exam_n + $exam->exam_p;
//             $total = $total_exam + $exam->exam_p;
    
//             // Check if student is successful or failed
//             if ($total_degree >= 24 ) {
//                 if($total >=60)
//                 {
//                     $count_successful_students++;
//                 }else
//                 {
//                     $count_failed_students++;
//                 }
              
//             } else {
//                 $count_failed_students++;
//             }
//         }
    
//     // احصاء عدد الطلاب الناجحين والراسبين لكل سنة في كل تخصص
//     $success_counts = [
//         'programming' => ['year1' => 0, 'year2' => 0],
//         'networking' => ['year1' => 0, 'year2' => 0],
//         'maintenance' => ['year1' => 0, 'year2' => 0],
//     ];
    
//     $fail_counts = [
//         'programming' => ['year1' => 0, 'year2' => 0],
//         'networking' => ['year1' => 0, 'year2' => 0],
//         'maintenance' => ['year1' => 0, 'year2' => 0],
//     ];
    
//     // اجمالي عدد الطلاب لكل سنة في كل تخصص
//     $total_counts = [
//         'programming' => ['year1' => 0, 'year2' => 0],
//         'networking' => ['year1' => 0, 'year2' => 0],
//         'maintenance' => ['year1' => 0, 'year2' => 0],
//     ];

//     foreach ($exame_manages as $exam) {
//         $total_degree = $exam->degree_n + $exam->degree_p;
//         $total_exam = $exam->exam_n + $exam->exam_p;
//         $total = $total_degree + $total_exam;

//         $year = $exam->academic_year == 'السنة الاولى' ? 'year1' : 'year2';
//         $specialization = $exam->specializations_id;

//         // زيادة عدد الطلاب في التخصص والسنة
//         $total_counts[$specialization][$year]++;
        
//         if ($total_degree >= 24 && $total >= 60) {
//             $success_counts[$specialization][$year]++;
//         } else {
//             $fail_counts[$specialization][$year]++;
//         }
//     }

//     // حساب النسبة المئوية للطلاب الناجحين والراسبين
//     $success_percentages = [
//         'programming' => ['year1' => 0, 'year2' => 0],
//         'networking' => ['year1' => 0, 'year2' => 0],
//         'maintenance' => ['year1' => 0, 'year2' => 0],
//     ];
    
//     $fail_percentages = [
//         'programming' => ['year1' => 0, 'year2' => 0],
//         'networking' => ['year1' => 0, 'year2' => 0],
//         'maintenance' => ['year1' => 0, 'year2' => 0],
//     ];

//     foreach ($total_counts as $specialization => $years) {
//         foreach ($years as $year => $total) {
//             if ($total > 0) {
//                 $success_percentages[$specialization][$year] = ($success_counts[$specialization][$year] / $total) * 100;
//                 $fail_percentages[$specialization][$year] = ($fail_counts[$specialization][$year] / $total) * 100;
//             }
//         }
//     }

//     return view('dashBoard.home', compact(
//         'count_student', 'count_teacher', 'count_exame_manage',
//         'count_successful_students', 'count_failed_students',
//         'count_subject', 'objection_count',
//         'count_student_prog', 'count_student_net', 'count_student_main',
//         'success_counts', 'fail_counts',
//         'success_percentages', 'fail_percentages'
//     ));
 
// }
















    // public function index(){
    //     $user_student = User::where('role' , 'student')->get();
    //     $user_student_prog = User::where('role' , 'student')->where('specializations_id' , 'قسم البرمجة')->get();
    //     $user_student_network = User::where('role' , 'student')->where('specializations_id' , 'قسم الشبكات')->get();
    //     $user_student_mani = User::where('role' , 'student')->where('specializations_id' , 'قسم الصيانة')->get();
    //     $user_teacher = User::where('role' , 'teacher')->get();
    //     $exame_manages = ExameManages::all();
    //     $subject = Subject::all();
    //     $objection   = Objection::all();
        
    //     $count_student = $user_student->count();
    //     $count_student_prog = $user_student_prog->count();
    //     $count_student_net = $user_student_network->count();
    //     $count_student_main = $user_student_mani->count();
    //     $count_teacher = $user_teacher->count();
    //     $count_exame_manage = $exame_manages->count();
    //     $count_subject = $subject->count();

    //     $objection_count  = $objection->count();

    //     $count_successful_students = 0;
    //     $count_failed_students = 0;
    
    //     //  الطلاب الناجحون
    //     foreach ($exame_manages as $exam) {
    //         // Calculate total degree and exam scores
    //         $total_degree = $exam->degree_n + $exam->degree_p;
    //         $total_exam = $exam->exam_n + $exam->exam_p;
    //         $total = $total_exam + $exam->exam_p;
    
    //         // Check if student is successful or failed
    //         if ($total_degree >= 24 ) {
    //             if($total >=60)
    //             {
    //                 $count_successful_students++;
    //             }else
    //             {
    //                 $count_failed_students++;
    //             }
              
    //         } else {
    //             $count_failed_students++;
    //         }
    //     }


    //     return view('dashBoard.home'
    // , compact('count_student' , 'count_teacher', 'count_exame_manage'
    // ,'count_successful_students' ,'count_failed_students' , 
    // 'count_subject' , 'objection_count'
    // ,'count_student_prog',
    // 'count_student_net',
    // 'count_student_main')
    // );
    // }
}
