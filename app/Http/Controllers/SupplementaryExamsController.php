<?php

namespace App\Http\Controllers;

use App\Models\SupplementaryExams;
use App\Models\ExameManages;
use App\Models\StudentYearTwo;
use App\Models\User;
use Illuminate\Http\Request;

class SupplementaryExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('DashBoard.exameManage.supplementary.home');
    }
    public function addMarkSupplement()
    {
        return view('DashBoard.exameManage.supplementary.AddMark');
    }
    public function addMarkSupplementDepProg()
    {
        return view('DashBoard.exameManage.supplementary.AddMarkDepProg');
    }
    public function addMarkSupplementDepNetwork()
    {
        return view('DashBoard.exameManage.supplementary.AddMarkDepNetWork');
    }
    public function addMarkSupplementDepMain()
    {
        return view('DashBoard.exameManage.supplementary.AddMarkDepMain');
    }





    public function addMarkSupplementDepProgrammingOne()
    {
        // جلب الطلاب الذين لديهم علامات أقل من 60
        $failedStudents = ExameManages::where('academic_year', 'السنة الاولى')
            ->where('specializations_id', 'قسم البرمجة')
            ->whereRaw('(degree_n + degree_p + exam_n + exam_p) < 60')
            ->with('student') // تحميل بيانات الطلاب المرتبطة
            ->get();
    
        // تجهيز البيانات للنقل إلى الـ View
        $studentsWithFailedSubjects = [];
        foreach ($failedStudents as $exam) {
            $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
            $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
        }
    
        return view('DashBoard.exameManage.supplementary.AddMarkDepartment.programmingOne', compact('studentsWithFailedSubjects'));
    }
    
    public function storeAddMarkProgrammingOne(Request $request)
{
    // Validate the incoming request data
    $this->validate($request, [
        'student_id' => 'required',
        'subject_id' => 'required',
        'degree_n' => 'required|numeric|min:0|max:20',
        'degree_p' => 'required|numeric|min:0|max:20',
        'exam_n' => 'required|numeric|min:0|max:30',
        'exam_p' => 'required|numeric|min:0|max:30',
    ]);

    // Fetch the student by their ID
    $student = User::where('role', 'student')
                   ->where('student_id', $request->student_id)
                   ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
        return redirect()->back();
    }

    // Fetch the existing exam record or create a new one if it doesn't exist
    $exam = ExameManages::updateOrCreate(
        [
            'student_id' => $student->student_id,
            'subject_id' => $request->subject_id,
            'academic_year' => 'السنة الاولى', // Assuming this is the correct academic year
        ],
        [
            'degree_n' => $request->degree_n,
            'degree_p' => $request->degree_p,
            'exam_n' => $request->exam_n,
            'exam_p' => $request->exam_p,
        ]
    );

    // Calculate the total marks for the subject
    $firstSemesterTotal = $request->degree_n + $request->degree_p;
    $secondSemesterTotal = $request->exam_n + $request->exam_p;
    $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

    // Store the supplementary exam details in SupplementaryExams table if the student has failed
    if ($overallTotal < 60) {
        // Check if the record already exists in the supplementary table
        $existingSupplementary = SupplementaryExams::where('student_id', $student->student_id)
                                                   ->where('exam_id', $exam->id)
                                                   ->exists();

        if (!$existingSupplementary) {
            $supplementary = new SupplementaryExams();
            $supplementary->student_id = $student->student_id;
            $supplementary->student_name = $student->name;
            $supplementary->specializations_id = 'قسم البرمجة';
            $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
            $supplementary->save();
        }
    }

    // Fetch all subjects the student took in the first year from Exame
    $exams = ExameManages::where('student_id', $student->student_id)
                         ->where('academic_year', 'السنة الاولى')
                         ->get();

    $totalSubjectsInExame = $exams->count(); // Total subjects the student took in the first year in Exame

    // Calculate the number of failed subjects in Exame
    $failedSubjectsCount = 0;
    foreach ($exams as $exam) {
        $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
        $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
        $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

        if ($overallTotal < 60) {
            $failedSubjectsCount++;
        }
    }

    // If the student has failed less than three subjects and completed all subjects in Exame, advance them to the second year
    if ($failedSubjectsCount <= 3 && $totalSubjectsInExame == 13) {
        // Check if the student is already in the second year
        $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
        if (!$existingStudentYearTwo) {
            $studentTwo = new StudentYearTwo();
            $studentTwo->student_id = $student->student_id;
            $studentTwo->student_name = $student->name;
            $studentTwo->specializations_id = 'قسم البرمجة';
            $studentTwo->year_one_student = 'السنة الثانية';
            $student->is_hidden = true;
            $student->save();
            $studentTwo->save();
        }
    }

    session()->flash('success', 'تم تحديث النتيجة بنجاح');
    return redirect()->back();
}

// public function addMarkSupplementDepProgrammingOne()
// {
//     $failedStudents = ExameManages::where('academic_year', 'السنة الاولى')
//     ->where('specializations_id', 'قسم البرمجة')
//     ->where(function ($query) {
//         $query->where('degree_n', '<', 12)
//               ->orWhere('degree_p', '<', 12)
//               ->orWhereRaw('(degree_n + degree_p + exam_n + exam_p) < 60');
//     })
//     ->with('student') // تحميل بيانات الطلاب المرتبطة
//     ->get();
//         // تجهيز البيانات للنقل إلى الـ View
//         $studentsWithFailedSubjects = [];
//         foreach ($failedStudents as $exam) {
//         $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
//         $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
//         }
//     return view('DashBoard.exameManage.supplementary.AddMarkDepartment.programmingOne' , compact('studentsWithFailedSubjects'));
// }


// public function storeAddMarkProgrammingOne(Request $request)
// {
//     // Validate the incoming request data
//     $this->validate($request, [
//         'student_id' => 'required',
//         'subject_id' => 'required',
//         'degree_n' => 'required|numeric|min:0|max:20',
//         'degree_p' => 'required|numeric|min:0|max:20',
//         'exam_n' => 'required|numeric|min:0|max:30',
//         'exam_p' => 'required|numeric|min:0|max:30',
//     ]);

//     // Fetch the student by their ID
//     $student = User::where('role', 'student')
//                    ->where('student_id', $request->student_id)
//                    ->first();

//     if (!$student) {
//         session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
//         return redirect()->back();
//     }

//     // Fetch the existing exam record or create a new one if it doesn't exist
//     $exam = ExameManages::updateOrCreate(
//         [
//             'student_id' => $student->student_id,
//             'subject_id' => $request->subject_id,
//             'academic_year' => 'السنة الاولى', // Assuming this is the correct academic year
//         ],
//         [
//             'degree_n' => $request->degree_n,
//             'degree_p' => $request->degree_p,
//             'exam_n' => $request->exam_n,
//             'exam_p' => $request->exam_p,
//         ]
//     );

//     // Store the supplementary exam details in SupplementaryExams table
//     $supplementary = new SupplementaryExams();
//     $supplementary->student_id = $student->student_id;
//     $supplementary->student_name = $student->name;
//     $supplementary->specializations_id = 'قسم البرمجة';
//     $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
//     $supplementary->save();

//     // Fetch all subjects the student took in the first year from Exame
//     $exams = ExameManages::where('student_id', $student->student_id)
//                          ->where('academic_year', 'السنة الاولى')
//                          ->get();

//     $totalSubjectsInExame = $exams->count(); // Total subjects the student took in the first year in Exame

//     // Calculate the number of failed subjects in Exame
//     $failedSubjectsCount = 0;
//     foreach ($exams as $exam) {
//         $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
//         $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
//         $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

//         if ( $overallTotal < 60) {
//             $failedSubjectsCount++;
//         }
//     }

//     // If the student has failed less than three subjects and completed all subjects in Exame, advance them to the second year
//     if ($failedSubjectsCount <=3 && $totalSubjectsInExame == 13) {
//         // Check if the student is already in the second year
//         $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
//         if (!$existingStudentYearTwo) {
//             $studentTwo = new StudentYearTwo();
//             $studentTwo->student_id = $student->student_id;
//             $studentTwo->student_name = $student->name;
//             $studentTwo->specializations_id = 'قسم البرمجة';
//             $studentTwo->year_one_student = 'السنة الثانية';
//             $student->is_hidden = true;
//             $student->save();
//             $studentTwo->save();
//         }
//     }

//     session()->flash('success', 'تم تحديث النتيجة بنجاح');
//     return redirect()->back();
// }


public function addMarkSupplementDepProgrammingTwo()
{
    // $failedStudents = ExameManages::where('academic_year', 'السنة الثاني')
    // ->where('specializations_id', 'قسم البرمجة')
    // ->orWhereRaw('(degree_n + degree_p + exam_n + exam_p) < 60')
    // ->with('student') // تحميل بيانات الطلاب المرتبطة
    // ->get();
    //     // تجهيز البيانات للنقل إلى الـ View
    //     $studentsWithFailedSubjects = [];
    //     foreach ($failedStudents as $exam) {
    //     $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
    //     $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
    //     }
    
        // جلب الطلاب الذين رسبوا في قسم البرمجة للسنة الثانية
        $failedStudents = ExameManages::where('academic_year', 'السنة الثاني')
        ->where('specializations_id', 'قسم البرمجة')
        ->whereRaw('(degree_n + degree_p + exam_n + exam_p) < 60') // التحقق من الرسوب بناءً على المجموع
        ->with('student') // تحميل بيانات الطلاب المرتبطة
        ->get();

    // تجهيز البيانات للنقل إلى الـ View
    $studentsWithFailedSubjects = [];
    foreach ($failedStudents as $exam) {
        // التحقق من نجاح الطالب في الامتحان التكميلي
        $totalScore = $exam->degree_n + $exam->degree_p + $exam->exam_n + $exam->exam_p;

        if ($totalScore < 60) {
            $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
            $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
        }
    }
    return view('DashBoard.exameManage.supplementary.AddMarkDepartment.programmingTwo' , compact('studentsWithFailedSubjects'));
}



public function storeAddMarkProgrammingTwo(Request $request)
{
    // Validate the incoming request data
    $this->validate($request, [
        'student_id' => 'required',
        'subject_id' => 'required',
        'degree_n' => 'required|numeric|min:0|max:20',
        'degree_p' => 'required|numeric|min:0|max:20',
        'exam_n' => 'required|numeric|min:0|max:30',
        'exam_p' => 'required|numeric|min:0|max:30',
    ]);

    // Fetch the student by their ID
    $student = User::where('role', 'student')
        ->where('student_id', $request->student_id)
        ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
        return redirect()->back();
    }

    // Fetch the existing exam record or create a new one if it doesn't exist
    $exam = ExameManages::updateOrCreate(
        [
            'student_id' => $student->student_id,
            'subject_id' => $request->subject_id,
            'academic_year' => 'السنة الثاني', // Assuming this is the correct academic year
        ],
        [
            'degree_n' => $request->degree_n,
            'degree_p' => $request->degree_p,
            'exam_n' => $request->exam_n,
            'exam_p' => $request->exam_p,
        ]
    );

     // حساب مجموع الدرجات للمادة
     $firstSemesterTotal = $request->degree_n + $request->degree_p;
     $secondSemesterTotal = $request->exam_n + $request->exam_p;
     $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
 
     // تسجيل تفاصيل الامتحان التكميلي فقط إذا كان الطالب راسبًا
     if ($overallTotal < 60) {
         // تحقق من وجود السجل في جدول الامتحانات التكميلية
         $existingSupplementary = SupplementaryExams::where('student_id', $student->student_id)
                                                    ->where('exam_id', $exam->id)
                                                    ->exists();
 
         if (!$existingSupplementary) {
             $supplementary = new SupplementaryExams();
             $supplementary->student_id = $student->student_id;
             $supplementary->student_name = $student->name;
             $supplementary->specializations_id = 'قسم البرمجة';
             $supplementary->exam_id = $exam->id; // تأكد من وجود الحقل id في جدول ExameManages
             $supplementary->save();
         }
     }
 
     // إرسال رسالة نجاح
     session()->flash('success', 'تم تحديث النتيجة بنجاح');
     return redirect()->back();
    
    // // Store the supplementary exam details in SupplementaryExams table
    // $supplementary = new SupplementaryExams();
    // $supplementary->student_id = $student->student_id;
    // $supplementary->student_name = $student->name;
    // $supplementary->specializations_id = 'قسم البرمجة';
    // $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
    // $supplementary->save();
    // session()->flash('success', 'تم تحديث النتيجة بنجاح');
    // return redirect()->back();
}


public function addMarkSupplementDepNetworkOne()
{
    $failedStudents = ExameManages::where('academic_year', 'السنة الاولى')
    ->where('specializations_id', 'قسم الشبكات')
    ->whereRaw('(degree_n + degree_p + exam_n + exam_p) < 60')
    ->with('student') // تحميل بيانات الطلاب المرتبطة
    ->get();

// تجهيز البيانات للنقل إلى الـ View
    $studentsWithFailedSubjects = [];
    foreach ($failedStudents as $exam) {
        $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
        $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
    }
    return view('DashBoard.exameManage.supplementary.AddMarkDepartment.NetworkOne' , compact('studentsWithFailedSubjects'));
}


public function storeAddMarkNetworkOne(Request $request)
{
    // التحقق من صحة البيانات الواردة من الطلب
    $this->validate($request, [
        'student_id' => 'required',
        'subject_id' => 'required',
        'degree_n' => 'required|numeric|min:0|max:20',
        'degree_p' => 'required|numeric|min:0|max:20',
        'exam_n' => 'required|numeric|min:0|max:30',
        'exam_p' => 'required|numeric|min:0|max:30',
    ]);

    // جلب الطالب باستخدام المعرف الخاص به
    $student = User::where('role', 'student')
        ->where('student_id', $request->student_id)
        ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
        return redirect()->back();
    }

    // جلب سجل الامتحان الحالي أو إنشاء واحد جديد إذا لم يكن موجودًا
    $exam = ExameManages::updateOrCreate(
        [
            'student_id' => $student->student_id,
            'subject_id' => $request->subject_id,
            'academic_year' => 'السنة الاولى', // تأكد من استخدام السنة الدراسية الصحيحة
        ],
        [
            'degree_n' => $request->degree_n,
            'degree_p' => $request->degree_p,
            'exam_n' => $request->exam_n,
            'exam_p' => $request->exam_p,
        ]
    );

    // حساب مجموع الدرجات للمادة
    $firstSemesterTotal = $request->degree_n + $request->degree_p;
    $secondSemesterTotal = $request->exam_n + $request->exam_p;
    $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

    // تسجيل تفاصيل الامتحان التكميلي إذا كان الطالب راسبًا
    if ($overallTotal < 60) {
        // تحقق من وجود السجل في جدول الامتحانات التكميلية
        $existingSupplementary = SupplementaryExams::where('student_id', $student->student_id)
                                                   ->where('exam_id', $exam->id)
                                                   ->exists();

        if (!$existingSupplementary) {
            $supplementary = new SupplementaryExams();
            $supplementary->student_id = $student->student_id;
            $supplementary->student_name = $student->name;
            $supplementary->specializations_id = 'قسم الشبكات';
            $supplementary->exam_id = $exam->id; // تأكد من وجود الحقل id في جدول ExameManages
            $supplementary->save();
        }
    }

    // جلب جميع المواد التي درسها الطالب في السنة الأولى من جدول Exame
    $exams = ExameManages::where('student_id', $student->student_id)
        ->where('academic_year', 'السنة الاولى')
        ->get();

    $totalSubjectsInExame = $exams->count(); // إجمالي عدد المواد التي درسها الطالب في السنة الأولى

    // حساب عدد المواد التي رسب فيها الطالب في جدول Exame
    $failedSubjectsCount = 0;
    foreach ($exams as $exam) {
        $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
        $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
        $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

        if ($overallTotal < 60) {
            $failedSubjectsCount++;
        }
    }

    // إذا رسب الطالب في ثلاث مواد أو أقل وأكمل جميع المواد في Exame، قم بنقله إلى السنة الثانية
    if ($failedSubjectsCount <= 3 && $totalSubjectsInExame == 13) {
        // تحقق من أن الطالب غير مسجل بالفعل في السنة الثانية
        $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
        if (!$existingStudentYearTwo) {
            $studentTwo = new StudentYearTwo();
            $studentTwo->student_id = $student->student_id;
            $studentTwo->student_name = $student->name;
            $studentTwo->specializations_id = 'قسم الشبكات';
            $studentTwo->year_one_student = 'السنة الثانية';
            $student->is_hidden = true; // إخفاء الطالب في السنة الأولى
            $student->save();
            $studentTwo->save();
        }
    }

    // إرسال رسالة نجاح
    session()->flash('success', 'تم تحديث النتيجة بنجاح');
    return redirect()->back();
}


// public function storeAddMarkNetworkOne(Request $request)
// {
//     // Validate the incoming request data
//     $this->validate($request, [
//         'student_id' => 'required',
//         'subject_id' => 'required',
//         'degree_n' => 'required|numeric|min:0|max:20',
//         'degree_p' => 'required|numeric|min:0|max:20',
//         'exam_n' => 'required|numeric|min:0|max:30',
//         'exam_p' => 'required|numeric|min:0|max:30',
//     ]);

//     // Fetch the student by their ID
//     $student = User::where('role', 'student')
//         ->where('student_id', $request->student_id)
//         ->first();

//     if (!$student) {
//         session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
//         return redirect()->back();
//     }

//     // Fetch the existing exam record or create a new one if it doesn't exist
//     $exam = ExameManages::updateOrCreate(
//         [
//             'student_id' => $student->student_id,
//             'subject_id' => $request->subject_id,
//             'academic_year' => 'السنة الاولى', // Assuming this is the correct academic year
//         ],
//         [
//             'degree_n' => $request->degree_n,
//             'degree_p' => $request->degree_p,
//             'exam_n' => $request->exam_n,
//             'exam_p' => $request->exam_p,
//         ]
//     );

//     // Store the supplementary exam details in SupplementaryExams table
//     $supplementary = new SupplementaryExams();
//     $supplementary->student_id = $student->student_id;
//     $supplementary->student_name = $student->name;
//     $supplementary->specializations_id = 'قسم الشبكات ';
//     $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
//     $supplementary->save();

//     // Fetch all subjects the student took in the first year from Exame
//     $exams = ExameManages::where('student_id', $student->student_id)
//         ->where('academic_year', 'السنة الاولى')
//         ->get();

//     $totalSubjectsInExame = $exams->count(); // Total subjects the student took in the first year in Exame

//     // Calculate the number of failed subjects in Exame
//     $failedSubjectsCount = 0;
//     foreach ($exams as $exam) {
//         $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
//         $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
//         $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

//         if ($overallTotal < 60) {
//             $failedSubjectsCount++;
//         }
//     }

//     // If the student has failed less than three subjects and completed all subjects in Exame, advance them to the second year
//     if ($failedSubjectsCount <= 3 && $totalSubjectsInExame == 13) {
//         // Check if the student is already in the second year
//         $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
//         if (!$existingStudentYearTwo) {
//             $studentTwo = new StudentYearTwo();
//             $studentTwo->student_id = $student->student_id;
//             $studentTwo->student_name = $student->name;
//             $studentTwo->specializations_id = 'قسم الشبكات';
//             $studentTwo->year_one_student = 'السنة الثانية';
//             $student->is_hidden = true;
//             $student->save();
//             $studentTwo->save();
//         }
//     }

//     session()->flash('success', 'تم تحديث النتيجة بنجاح');
//     return redirect()->back();
// }





public function addMarkSupplementDepNetworkTwo()
{
    // $failedStudents = ExameManages::where('academic_year', 'السنة الثاني')
    // ->where('specializations_id', 'قسم الشبكات')
    // ->orWhereRaw('(degree_n + degree_p + exam_n + exam_p) < 60')
    // ->with('student') // تحميل بيانات الطلاب المرتبطة
    // ->get();
    //     // تجهيز البيانات للنقل إلى الـ View
    //     $studentsWithFailedSubjects = [];
    //     foreach ($failedStudents as $exam) {
    //     $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
    //     $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
    //     }

         // جلب الطلاب الذين رسبوا في قسم البرمجة للسنة الثانية
         $failedStudents = ExameManages::where('academic_year', 'السنة الثاني')
         ->where('specializations_id', 'قسم البرمجة')
         ->whereRaw('(degree_n + degree_p + exam_n + exam_p) < 60') // التحقق من الرسوب بناءً على المجموع
         ->with('student') // تحميل بيانات الطلاب المرتبطة
         ->get();
 
     // تجهيز البيانات للنقل إلى الـ View
     $studentsWithFailedSubjects = [];
     foreach ($failedStudents as $exam) {
         // التحقق من نجاح الطالب في الامتحان التكميلي
         $totalScore = $exam->degree_n + $exam->degree_p + $exam->exam_n + $exam->exam_p;
 
         if ($totalScore < 60) {
             $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
             $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
         }
     }

    return view('DashBoard.exameManage.supplementary.AddMarkDepartment.networkTwo' , compact('studentsWithFailedSubjects'));
}

public function storeAddMarkNetworkTwo(Request $request)
{
    // Validate the incoming request data
    $this->validate($request, [
        'student_id' => 'required',
        'subject_id' => 'required',
        'degree_n' => 'required|numeric|min:0|max:20',
        'degree_p' => 'required|numeric|min:0|max:20',
        'exam_n' => 'required|numeric|min:0|max:30',
        'exam_p' => 'required|numeric|min:0|max:30',
    ]);

    // Fetch the student by their ID
    $student = User::where('role', 'student')
        ->where('student_id', $request->student_id)
        ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
        return redirect()->back();
    }

    // Fetch the existing exam record or create a new one if it doesn't exist
    $exam = ExameManages::updateOrCreate(
        [
            'student_id' => $student->student_id,
            'subject_id' => $request->subject_id,
            'academic_year' => 'السنة الثاني', // Assuming this is the correct academic year
        ],
        [
            'degree_n' => $request->degree_n,
            'degree_p' => $request->degree_p,
            'exam_n' => $request->exam_n,
            'exam_p' => $request->exam_p,
        ]
    );

         // حساب مجموع الدرجات للمادة
         $firstSemesterTotal = $request->degree_n + $request->degree_p;
         $secondSemesterTotal = $request->exam_n + $request->exam_p;
         $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
     
         // تسجيل تفاصيل الامتحان التكميلي فقط إذا كان الطالب راسبًا
         if ($overallTotal < 60) {
             // تحقق من وجود السجل في جدول الامتحانات التكميلية
             $existingSupplementary = SupplementaryExams::where('student_id', $student->student_id)
                                                        ->where('exam_id', $exam->id)
                                                        ->exists();
     
             if (!$existingSupplementary) {
                 $supplementary = new SupplementaryExams();
                 $supplementary->student_id = $student->student_id;
                 $supplementary->student_name = $student->name;
                 $supplementary->specializations_id = 'قسم الشبكات';
                 $supplementary->exam_id = $exam->id; // تأكد من وجود الحقل id في جدول ExameManages
                 $supplementary->save();
             }
         }
       session()->flash('success', 'تم تحديث النتيجة بنجاح');
    return redirect()->back();
    
    // Store the supplementary exam details in SupplementaryExams table
    // $supplementary = new SupplementaryExams();
    // $supplementary->student_id = $student->student_id;
    // $supplementary->student_name = $student->name;
    // $supplementary->specializations_id = 'قسم الشبكات';
    // $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
    // $supplementary->save();
  
}





public function addMarkSupplementDepMainOne()
{
    $failedStudents = ExameManages::where('academic_year', 'السنة الاولى')
    ->where('specializations_id', 'قسم الصيانة')
    ->whereRaw('(degree_n + degree_p + exam_n + exam_p) < 60')
    ->with('student') // تحميل بيانات الطلاب المرتبطة
    ->get();

// تجهيز البيانات للنقل إلى الـ View
    $studentsWithFailedSubjects = [];
    foreach ($failedStudents as $exam) {
        $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
        $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
    }
    return view('DashBoard.exameManage.supplementary.AddMarkDepartment.mainOne' , compact('studentsWithFailedSubjects'));
}


public function storeAddMarkMainOne(Request $request)
{
    // التحقق من صحة البيانات الواردة من الطلب
    $this->validate($request, [
        'student_id' => 'required',
        'subject_id' => 'required',
        'degree_n' => 'required|numeric|min:0|max:20',
        'degree_p' => 'required|numeric|min:0|max:20',
        'exam_n' => 'required|numeric|min:0|max:30',
        'exam_p' => 'required|numeric|min:0|max:30',
    ]);

    // جلب الطالب باستخدام المعرف الخاص به
    $student = User::where('role', 'student')
        ->where('student_id', $request->student_id)
        ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
        return redirect()->back();
    }

    // جلب سجل الامتحان الحالي أو إنشاء واحد جديد إذا لم يكن موجودًا
    $exam = ExameManages::updateOrCreate(
        [
            'student_id' => $student->student_id,
            'subject_id' => $request->subject_id,
            'academic_year' => 'السنة الاولى', // تأكد من استخدام السنة الدراسية الصحيحة
        ],
        [
            'degree_n' => $request->degree_n,
            'degree_p' => $request->degree_p,
            'exam_n' => $request->exam_n,
            'exam_p' => $request->exam_p,
        ]
    );

    // حساب مجموع الدرجات للمادة
    $firstSemesterTotal = $request->degree_n + $request->degree_p;
    $secondSemesterTotal = $request->exam_n + $request->exam_p;
    $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

    // تسجيل تفاصيل الامتحان التكميلي إذا كان الطالب راسبًا
    if ($overallTotal < 60) {
        // تحقق من وجود السجل في جدول الامتحانات التكميلية
        $existingSupplementary = SupplementaryExams::where('student_id', $student->student_id)
                                                   ->where('exam_id', $exam->id)
                                                   ->exists();

        if (!$existingSupplementary) {
            $supplementary = new SupplementaryExams();
            $supplementary->student_id = $student->student_id;
            $supplementary->student_name = $student->name;
            $supplementary->specializations_id = 'قسم الصيانة';
            $supplementary->exam_id = $exam->id; // تأكد من وجود الحقل id في جدول ExameManages
            $supplementary->save();
        }
    }

    // جلب جميع المواد التي درسها الطالب في السنة الأولى من جدول Exame
    $exams = ExameManages::where('student_id', $student->student_id)
        ->where('academic_year', 'السنة الاولى')
        ->get();

    $totalSubjectsInExame = $exams->count(); // إجمالي عدد المواد التي درسها الطالب في السنة الأولى

    // حساب عدد المواد التي رسب فيها الطالب في جدول Exame
    $failedSubjectsCount = 0;
    foreach ($exams as $exam) {
        $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
        $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
        $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

        if ($overallTotal < 60) {
            $failedSubjectsCount++;
        }
    }

    // إذا رسب الطالب في ثلاث مواد أو أقل وأكمل جميع المواد في Exame، قم بنقله إلى السنة الثانية
    if ($failedSubjectsCount <= 3 && $totalSubjectsInExame == 13) {
        // تحقق من أن الطالب غير مسجل بالفعل في السنة الثانية
        $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
        if (!$existingStudentYearTwo) {
            $studentTwo = new StudentYearTwo();
            $studentTwo->student_id = $student->student_id;
            $studentTwo->student_name = $student->name;
            $studentTwo->specializations_id = 'قسم الصيانة';
            $studentTwo->year_one_student = 'السنة الثانية';
            $student->is_hidden = true; // إخفاء الطالب في السنة الأولى
            $student->save();
            $studentTwo->save();
        }
    }

    // إرسال رسالة نجاح
    session()->flash('success', 'تم تحديث النتيجة بنجاح');
    return redirect()->back();
}


// public function storeAddMarkMainOne(Request $request)
// {
//     // Validate the incoming request data
//     $this->validate($request, [
//         'student_id' => 'required',
//         'subject_id' => 'required',
//         'degree_n' => 'required|numeric|min:0|max:20',
//         'degree_p' => 'required|numeric|min:0|max:20',
//         'exam_n' => 'required|numeric|min:0|max:30',
//         'exam_p' => 'required|numeric|min:0|max:30',
//     ]);

//     // Fetch the student by their ID
//     $student = User::where('role', 'student')
//         ->where('student_id', $request->student_id)
//         ->first();

//     if (!$student) {
//         session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
//         return redirect()->back();
//     }

//     // Fetch the existing exam record or create a new one if it doesn't exist
//     $exam = ExameManages::updateOrCreate(
//         [
//             'student_id' => $student->student_id,
//             'subject_id' => $request->subject_id,
//             'academic_year' => 'السنة الاولى', // Assuming this is the correct academic year
//         ],
//         [
//             'degree_n' => $request->degree_n,
//             'degree_p' => $request->degree_p,
//             'exam_n' => $request->exam_n,
//             'exam_p' => $request->exam_p,
//         ]
//     );

//     // Store the supplementary exam details in SupplementaryExams table
//     $supplementary = new SupplementaryExams();
//     $supplementary->student_id = $student->student_id;
//     $supplementary->student_name = $student->name;
//     $supplementary->specializations_id = 'قسم الصيانة ';
//     $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
//     $supplementary->save();

//     // Fetch all subjects the student took in the first year from Exame
//     $exams = ExameManages::where('student_id', $student->student_id)
//         ->where('academic_year', 'السنة الاولى')
//         ->get();

//     $totalSubjectsInExame = $exams->count(); // Total subjects the student took in the first year in Exame

//     // Calculate the number of failed subjects in Exame
//     $failedSubjectsCount = 0;
//     foreach ($exams as $exam) {
//         $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
//         $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
//         $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

//         if ($overallTotal < 60) {
//             $failedSubjectsCount++;
//         }
//     }

//     // If the student has failed less than three subjects and completed all subjects in Exame, advance them to the second year
//     if ($failedSubjectsCount <=3 && $totalSubjectsInExame == 13) {
//         // Check if the student is already in the second year
//         $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
//         if (!$existingStudentYearTwo) {
//             $studentTwo = new StudentYearTwo();
//             $studentTwo->student_id = $student->student_id;
//             $studentTwo->student_name = $student->name;
//             $studentTwo->specializations_id = 'قسم الصيانة';
//             $studentTwo->year_one_student = 'السنة الثانية';
//             $student->is_hidden = true;
//             $student->save();
//             $studentTwo->save();
//         }
//     }

//     session()->flash('success', 'تم تحديث النتيجة بنجاح');
//     return redirect()->back();
// }





public function addMarkSupplementDepMainTwo()
{
    // $failedStudents = ExameManages::where('academic_year', 'السنة الثاني')
    // ->where('specializations_id', 'قسم الصيانة')
    // ->orWhereRaw('(degree_n + degree_p + exam_n + exam_p) < 60')
    // ->with('student') // تحميل بيانات الطلاب المرتبطة
    // ->get();
    //     // تجهيز البيانات للنقل إلى الـ View
    //     $studentsWithFailedSubjects = [];
    //     foreach ($failedStudents as $exam) {
    //     $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
    //     $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
        // }

        $failedStudents = ExameManages::where('academic_year', 'السنة الثاني')
        ->where('specializations_id', 'قسم الصيانة')
        ->whereRaw('(degree_n + degree_p + exam_n + exam_p) < 60') // التحقق من الرسوب بناءً على المجموع
        ->with('student') // تحميل بيانات الطلاب المرتبطة
        ->get();

    // تجهيز البيانات للنقل إلى الـ View
    $studentsWithFailedSubjects = [];
    foreach ($failedStudents as $exam) {
        // التحقق من نجاح الطالب في الامتحان التكميلي
        $totalScore = $exam->degree_n + $exam->degree_p + $exam->exam_n + $exam->exam_p;

        if ($totalScore < 60) {
            $studentsWithFailedSubjects[$exam->student_id]['student'] = $exam->student;
            $studentsWithFailedSubjects[$exam->student_id]['failed_subjects'][] = $exam;
        }
    }
    return view('DashBoard.exameManage.supplementary.AddMarkDepartment.mainTwo' , compact('studentsWithFailedSubjects'));
}

public function storeAddMarkMainTwo(Request $request)
{
    // Validate the incoming request data
    $this->validate($request, [
        'student_id' => 'required',
        'subject_id' => 'required',
        'degree_n' => 'required|numeric|min:0|max:20',
        'degree_p' => 'required|numeric|min:0|max:20',
        'exam_n' => 'required|numeric|min:0|max:30',
        'exam_p' => 'required|numeric|min:0|max:30',
    ]);

    // Fetch the student by their ID
    $student = User::where('role', 'student')
        ->where('student_id', $request->student_id)
        ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الاسم المقدم');
        return redirect()->back();
    }

    // Fetch the existing exam record or create a new one if it doesn't exist
    $exam = ExameManages::updateOrCreate(
        [
            'student_id' => $student->student_id,
            'subject_id' => $request->subject_id,
            'academic_year' => 'السنة الثاني', // Assuming this is the correct academic year
        ],
        [
            'degree_n' => $request->degree_n,
            'degree_p' => $request->degree_p,
            'exam_n' => $request->exam_n,
            'exam_p' => $request->exam_p,
        ]
    );

    
         // حساب مجموع الدرجات للمادة
         $firstSemesterTotal = $request->degree_n + $request->degree_p;
         $secondSemesterTotal = $request->exam_n + $request->exam_p;
         $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
     
         // تسجيل تفاصيل الامتحان التكميلي فقط إذا كان الطالب راسبًا
         if ($overallTotal < 60) {
             // تحقق من وجود السجل في جدول الامتحانات التكميلية
             $existingSupplementary = SupplementaryExams::where('student_id', $student->student_id)
                                                        ->where('exam_id', $exam->id)
                                                        ->exists();
     
             if (!$existingSupplementary) {
                 $supplementary = new SupplementaryExams();
                 $supplementary->student_id = $student->student_id;
                 $supplementary->student_name = $student->name;
                 $supplementary->specializations_id = 'قسم الشبكات';
                 $supplementary->exam_id = $exam->id; // تأكد من وجود الحقل id في جدول ExameManages
                 $supplementary->save();
             }
         }

    // Store the supplementary exam details in SupplementaryExams table
    // $supplementary = new SupplementaryExams();
    // $supplementary->student_id = $student->student_id;
    // $supplementary->student_name = $student->name;
    // $supplementary->specializations_id = 'قسم الصيانة';
    // $supplementary->exam_id = $exam->id; // Assuming you have an id field in ExameManages table
    // $supplementary->save();
    session()->flash('success', 'تم تحديث النتيجة بنجاح');
    return redirect()->back();
}


// View All Mark Student(Supplemenet)

public function allMarkSupplement()
{
    return view('DashBoard.exameManage.supplementary.allMarkSupplement.allMarkSupplement');
}

public function viewMarkSupplementprogYearOne()
{
    // جلب الطلاب الذين هم في السنة الأولى فقط وفي قسم البرمجة وغير مخفيين
    $examsprg = SupplementaryExams::whereHas('exams', function($query) {
        $query->where('academic_year', 'السنة الاولى')
              ->where('specializations_id', 'قسم البرمجة');
    })
    
    ->with(['exams' => function($query) {
        $query->where('academic_year', 'السنة الاولى')
              ->where('specializations_id', 'قسم البرمجة');
    }])
    ->get();

   
   

    return view('DashBoard.exameManage.supplementary.allMarkSupplement.prog_year_supplement_one', compact('examsprg'));
}


public function viewMarkSupplementprogYearTwo()
{
    // جلب جميع الامتحانات التكميلية للطلاب في السنة الثانية في قسم البرمجة
    $examsprg = SupplementaryExams::whereHas('exams', function($query) {
        $query->where('academic_year', 'السنة الثاني')
              ->where('specializations_id', 'قسم البرمجة');
    })
    ->with(['exams' => function($query) {
        $query->where('academic_year', 'السنة الثاني')
              ->where('specializations_id', 'قسم البرمجة');
    }])
    ->get();

    return view('DashBoard.exameManage.supplementary.allMarkSupplement.prog_year_supplement_two', compact('examsprg'));
}
    
public function viewMarkSupplementNetworkYearOne()
{
    // جلب الطلاب الذين هم في السنة الأولى فقط وفي قسم البرمجة وغير مخفيين
    $examsprg = SupplementaryExams::whereHas('exams', function($query) {
        $query->where('academic_year', 'السنة الاولى')
              ->where('specializations_id', 'قسم الشبكات');
    })
    ->with(['exams' => function($query) {
        $query->where('academic_year', 'السنة الاولى')
              ->where('specializations_id', 'قسم الشبكات');
    }])
    ->get();

    return view('DashBoard.exameManage.supplementary.allMarkSupplement.net_year_supplement_one', compact('examsprg'));
}

public function viewMarkSupplementNetworkYearTwo()
{
    // جلب جميع الامتحانات التكميلية للطلاب في السنة الثانية في قسم البرمجة
    $examsprg = SupplementaryExams::whereHas('exams', function($query) {
        $query->where('academic_year', 'السنة الثاني')
              ->where('specializations_id', 'قسم الشبكات');
    })
    ->with(['exams' => function($query) {
        $query->where('academic_year', 'السنة الثاني')
              ->where('specializations_id', 'قسم الشبكات');
    }])
    ->get();

    return view('DashBoard.exameManage.supplementary.allMarkSupplement.net_year_supplement_two', compact('examsprg'));
}
public function viewMarkSupplementMainYearOne()
{
        $examsprg = SupplementaryExams::whereHas('exams', function($query) {
            $query->where('academic_year', 'السنة الاولى')
                ->where('specializations_id', 'قسم الصيانة');
        })
        ->with(['exams' => function($query) {
            $query->where('academic_year', 'السنة الاولى')
                ->where('specializations_id', 'قسم الصيانة');
        }])
        ->get();

    return view('DashBoard.exameManage.supplementary.allMarkSupplement.main_year_supplementone', compact('examsprg'));
}


public function viewMarkSupplementMainYearTwo()
{
    // جلب جميع الامتحانات التكميلية للطلاب في السنة الثانية في قسم البرمجة
    $examsprg = SupplementaryExams::whereHas('exams', function($query) {
        $query->where('academic_year', 'السنة الثاني')
              ->where('specializations_id', 'قسم الصيانة');
    })
    ->with(['exams' => function($query) {
        $query->where('academic_year', 'السنة الثاني')
              ->where('specializations_id', 'قسم الصيانة');
    }])
    ->get();

    return view('DashBoard.exameManage.supplementary.allMarkSupplement.main_year_supplement_two', compact('examsprg'));
}
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SupplementaryExams $supplementaryExams)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupplementaryExams $supplementaryExams)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupplementaryExams $supplementaryExams)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplementaryExams $supplementaryExams)
    {
        //
    }
}
