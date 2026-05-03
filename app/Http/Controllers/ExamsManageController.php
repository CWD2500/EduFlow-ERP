<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Specialization;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ExameManages;
use App\Models\SupplementaryExams;

use App\Models\Objection;
use App\Models\StudentYearTwo;
use Illuminate\Support\Stringable;
use Illuminate\Support\Str;



class ExamsManageController extends Controller
{
    public function  indexExames (){
        return view('DashBoard.exameManage.homeExame');
    }

    public function addMark(){
        return view('DashBoard.exameManage.homeAddMark');
    }

    //  Categories Year Programming 
    public function viewprogramming()
    {
        return view('DashBoard.exameManage.viewAllCategories.prog_year_one');
    }
    
    public function viewNetwork()
    {
        return view('DashBoard.exameManage.viewAllCategories.net_category');
    }
    
    public function viewMain()
    {
        return view('DashBoard.exameManage.viewAllCategories.main_category');
    }
    
    public function StudentAddProgrammingExame()
{
    $students = User::where('role', 'student')
                    ->where('specializations_id', 'قسم البرمجة')  ->where('is_hidden', false)
                    ->get();
                  

    $specialization = Specialization::where('name', 'قسم البرمجة')->first();

    $subject_first_year = collect();
    $subject_second_year = collect();

    if ($specialization) {
        $subject_first_year = $specialization->subjects()
                                             ->where('semester', 'الفصل الاول')
                                             ->where('year', 'السنة الاولى')
                                             ->get();

        $subject_second_year = $specialization->subjects()
                                              ->where('semester', 'الفصل الثاني')
                                              ->where('year', 'السنة الاولى')
                                              ->get();
    }

    return view('DashBoard.exameManage.addMarkExamProgra', compact('students', 'subject_first_year', 'subject_second_year'));
}

public function fetchSubjectsBySemester(Request $request)
{
    $year = $request->year;
    $semester = $request->semester;
    $specialization_id = Specialization::where('name', 'قسم البرمجة')->first()->id;

    $subjects = Subject::whereHas('specializations', function ($query) use ($specialization_id) {
                        $query->where('specialization_id', $specialization_id);
                    })
                    ->where('year', $year)
                    ->where('semester', $semester)
                    ->get();

    return response()->json($subjects);
}

    
public function storeAddMarkProgramming(Request $request)
{
    $this->validate($request, [
        'subject_id' => 'required',
        'student_id' => 'required',
        'degree_n' => 'required',
        'degree_p' => 'required',
        'exam_n' => 'required',
        'exam_p' => 'required',
        'semester' => 'required',
    ]);

    // Fetch the student by their ID
    $student = User::where('role', 'student')
        ->where('student_id', $request->student_id)
        ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
        return redirect()->back();
    }

    // Check if the student has already taken the same subject
    $existingExame = ExameManages::where('student_id', $student->student_id)
        ->where('subject_id', $request->subject_id)
        ->exists();

    if ($existingExame) {
        session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
        return redirect()->back();
    }

    $exameManage = new ExameManages();
    $exameManage->subject_id = $request->subject_id;
    $exameManage->student_id = $student->student_id;
    $exameManage->student_number_id = $student->student_id;
    $exameManage->specializations_id = 'قسم البرمجة'; // تغيير التخصص إلى قسم الشبكات
    $exameManage->Supplementary_course = $request->Supplementary_course;
    $exameManage->academic_year = 'السنة الاولى';
    $exameManage->degree_n = $request->degree_n;
    $exameManage->degree_p = $request->degree_p;
    $exameManage->exam_n = $request->exam_n;
    $exameManage->exam_p = $request->exam_p;
    $exameManage->semester = $request->semester;
    $exameManage->save();

    // Fetch all subjects the student took in the first year
    $exams = ExameManages::where('student_id', $student->student_id)
        ->where('academic_year', 'السنة الاولى')
        ->get();

    $failedSubjectsCount = 0;

    // Calculate the number of failed subjects
    foreach ($exams as $exam) {
        $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
        $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
        $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

        if ($overallTotal < 60) { // Assuming 60 is the passing grade
            $failedSubjectsCount++;
        }
    }

    // If the student has failed less than three subjects and completed twelve subjects, advance them to the second year
    if ($failedSubjectsCount <= 3 && $exams->count() == 13) {
        // Check if the student is already in the second year
        $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
        if (!$existingStudentYearTwo) {
            $studentTwo = new StudentYearTwo();
            $studentTwo->student_id = $student->student_id;
            $studentTwo->student_name = $student->name;
            $studentTwo->specializations_id = 'قسم البرمجة'; // تغيير التخصص إلى قسم البرمجة
            $studentTwo->year_one_student = 'السنة الثانية';
            $student->is_hidden = true;
            $exameManage->is_hidden = true;
            $student->save();
            $studentTwo->save();
            session()->flash('successprg', 'مبروك تم انتقال الطلاب الى السنة الثانية');
        }
    }

    session()->flash('success', 'تم إضافة النتيجة بنجاح');
    return redirect()->back();
}

    
    public function StudentAddNetworkgExame()
    {
        $students = User::where('role', 'student')
        ->where('specializations_id', 'قسم الشبكات')->where('is_hidden', false)
        ->get();

        $specialization = Specialization::where('name', 'قسم الشبكات')->first();

        $subject_first_year = collect();
        $subject_second_year = collect();

        if ($specialization) {
        $subject_first_year = $specialization->subjects()
                                        ->where('semester', 'الفصل الاول')
                                        ->where('year', 'السنة الاولى')
                                        ->get();

        $subject_second_year = $specialization->subjects()
                                        ->where('semester', 'الفصل الثاني')
                                        ->where('year', 'السنة الاولى')
                                        ->get();
        }
        // إرجاع البيانات لقالب العرض
        return view('DashBoard.exameManage.addMarkExamNetwork', compact('students', 'subject_first_year', 'subject_second_year'));
    }
    



    public function fetchSubjectsBySemesterNetwork(Request $request)
    {      
          $year = $request->year;
        $semester = $request->semester;
        $specialization_id = Specialization::where('name', 'قسم الشبكات')->first()->id;
    
        $subjects = Subject::whereHas('specializations', function ($query) use ($specialization_id) {
                            $query->where('specialization_id', $specialization_id);
                        })
                        ->where('year', $year)
                        ->where('semester', $semester)
                        ->get();
    
        return response()->json($subjects);
    }
    
    


    public function storeAddMarkNetwork(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required',
        ]);
    
        // Fetch the student by their ID
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // Check if the student has already taken the same subject
        $existingExame = ExameManages::where('student_id', $student->student_id)
            ->where('subject_id', $request->subject_id)
            ->exists();
    
        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }
    
        $exameManage = new ExameManages();
        $exameManage->subject_id = $request->subject_id;
        $exameManage->student_id = $student->student_id;
        $exameManage->student_number_id = $student->student_id;
        $exameManage->specializations_id = 'قسم الشبكات'; // تغيير التخصص إلى قسم الشبكات
        $exameManage->Supplementary_course = $request->Supplementary_course;
        $exameManage->academic_year = 'السنة الاولى';
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p = $request->degree_p;
        $exameManage->exam_n = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
    
        // Fetch all subjects the student took in the first year
        $exams = ExameManages::where('student_id', $student->student_id)
            ->where('academic_year', 'السنة الاولى')
            ->get();
    
        $failedSubjectsCount = 0;
    
        // Calculate the number of failed subjects
        foreach ($exams as $exam) {
            $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
            $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
            $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
    
            if ($overallTotal < 60) { // Assuming 60 is the passing grade
                $failedSubjectsCount++;
            }
        }
    
        // If the student has failed less than three subjects and completed twelve subjects, advance them to the second year
        if ($failedSubjectsCount <= 3 && $exams->count() == 13) {
            // Check if the student is already in the second year
            $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
            if (!$existingStudentYearTwo) {
                $studentTwo = new StudentYearTwo();
                $studentTwo->student_id = $student->student_id;
                $studentTwo->student_name = $student->name;
                $studentTwo->specializations_id = 'قسم الشبكات'; // تغيير التخصص إلى قسم الشبكات
                $studentTwo->year_one_student = 'السنة الثانية';
                $student->is_hidden = true;
                $exameManage->is_hidden = true;
                $student->save();
                $studentTwo->save();
                session()->flash('successprg', 'مبروك تم انتقال الطلاب الى السنة الثانية');
            }
        }
    
        session()->flash('success', 'تم إضافة النتيجة بنجاح');
        return redirect()->back();
    }
    




    //  قسم الصيانة 
    public function studentAddMarkMaintans()
    {
    
        $students = User::where('role', 'student')
        ->where('specializations_id', 'قسم الصيانة')
        ->where('is_hidden', false)
        ->get();

        $specialization = Specialization::where('name', 'قسم الصيانة')->first();

        $subject_first_year = collect();
        $subject_second_year = collect();

        if ($specialization) {
        $subject_first_year = $specialization->subjects()
                                        ->where('semester', 'الفصل الاول')
                                        ->where('year', 'السنة الاولى')
                                        ->get();

        $subject_second_year = $specialization->subjects()
                                        ->where('semester', 'الفصل الثاني')
                                        ->where('year', 'السنة الثانية')
                                        ->get();
        }
            return view('DashBoard.exameManage.addMarkExamMaintiance', compact('students', 'subject_first_year', 'subject_second_year'));


        }
    

    public function fetchSubjectsBySemesterMain(Request $request)
    {
        $year = $request->year;
        $semester = $request->semester;
        $specialization_id = Specialization::where('name', 'قسم الصيانة')->first()->id;
    
        $subjects = Subject::whereHas('specializations', function ($query) use ($specialization_id) {
                            $query->where('specialization_id', $specialization_id);
                        })
                        ->where('year', $year)
                        ->where('semester', $semester)
                        ->get();
        return response()->json($subjects);
    }
    public function storeAddMarkMaintenance(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required',
        ]);
    
        // Fetch the student by their ID
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // Check if the student has already taken the same subject
        $existingExame = ExameManages::where('student_id', $student->student_id)
            ->where('subject_id', $request->subject_id)
            ->exists();
    
        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }
    
        $exameManage = new ExameManages();
        $exameManage->subject_id = $request->subject_id;
        $exameManage->student_id = $student->student_id;
        $exameManage->student_number_id = $student->student_id;
        $exameManage->specializations_id = 'قسم الصيانة'; // تحديث التخصص إلى قسم الصيانة
        $exameManage->Supplementary_course = $request->Supplementary_course;
        $exameManage->academic_year = 'السنة الاولى';
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p = $request->degree_p;
        $exameManage->exam_n = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
    
        // Fetch all subjects the student took in the first year
        $exams = ExameManages::where('student_id', $student->student_id)
            ->where('academic_year', 'السنة الاولى')
            ->get();
    
        $failedSubjectsCount = 0;
    
        // Calculate the number of failed subjects
        foreach ($exams as $exam) {
            $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
            $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
            $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
    
            if ($overallTotal < 60) { // Assuming 60 is the passing grade
                $failedSubjectsCount++;
            }
        }
    
        // If the student has failed less than three subjects and completed twelve subjects, advance them to the second year
        if ($failedSubjectsCount <= 3 && $exams->count() == 13) {
            // Check if the student is already in the second year
            $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
            if (!$existingStudentYearTwo) {
                $studentTwo = new StudentYearTwo();
                $studentTwo->student_id = $student->student_id;
                $studentTwo->student_name = $student->name;
                $studentTwo->specializations_id = 'قسم الصيانة'; // تغيير التخصص إلى قسم الصيانة
                $studentTwo->year_one_student = 'السنة الثانية';
                $studentTwo->save();
    
                // Update is_hidden status for student
                $student->is_hidden = true;
                $student->save();
    
                // Optionally, update is_hidden status for existing records if needed
                $exameManage->is_hidden = true;
                $exameManage->save();
    
                session()->flash('successprg', 'مبروك تم انتقال الطلاب الى السنة الثانية');
            }
        }
    
        session()->flash('success', 'تم إضافة النتيجة بنجاح');
        return redirect()->back();
    }
    




// View Result Student Year(One , Two):
    public function homeMark()
    {
        return view('DashBoard.exameManage.viewMark.homeMark');
    }
   
    public function viewMarkprogYearOne(Request $request){
        $semester = $request->input('semester'); // بدون افتراض فصل محدد
        $user_studentprog = User::where('role' , 'student')->get();
    
        $examsprgQuery = ExameManages::where('specializations_id', 'قسم البرمجة')
                                     ->where('academic_year', 'السنة الاولى');
    
        if ($semester) {
            $examsprgQuery->where('semester', $semester);
        }
    
        $examsprg = $examsprgQuery->orderBy('created_at', 'desc')->get();
    
        return view('DashBoard.exameManage.viewMark.prog_year_one', compact('examsprg', 'user_studentprog', 'semester'));
    }
    
    // public function viewMarkprogYearOne(){
   
        
    // $user_studentprog = User::where('role' , 'student')->get();
    // // take : get Element  Ex  : take(10) 
    // // $examsnet = ExameManages::where('specializations_id' , 'قسم الشبكات ')->get();
    // $examsprg = ExameManages::where('specializations_id' , 'قسم البرمجة ')
    // ->orderBy('created_at', 'desc')->get();
    // return view('DashBoard.exameManage.viewMark.prog_year_one' , compact(  'examsprg' , 'user_studentprog'));

    // }


    public function viewMarkprogYeartwo(Request $request){
        $semester = $request->input('semester'); // بدون افتراض فصل محدد
        // $user_studentprog = User::where('role' , 'student')->get();
        $user_studentprog = StudentYearTwo::where('year_one_student', 'السنة الثانية')
        ->where('specializations_id' ,'قسم البرمجة');

    
        $examsprgQuery = ExameManages::where('specializations_id', 'قسم البرمجة')
                                     ->where('academic_year', 'السنة الثاني');
    
        if ($semester) {
            $examsprgQuery->where('semester', $semester);
        }
    
        $examsprg = $examsprgQuery->orderBy('created_at', 'desc')->get();
    
        return view('DashBoard.exameManage.viewMark.prog_year_tow', compact('examsprg', 'user_studentprog', 'semester'));
    }
    
  
    // public function viewMarkprogYeartwo(){
    //     $examsprg = ExameManages::where('specializations_id' , 'قسم البرمجة ')
    //     ->orderBy('created_at', 'desc')->get();
    
    //     return view('DashBoard.exameManage.viewMark.prog_year_tow' , compact( 'examsprg'));

    // }

    public function viewMarknetworkYearone(Request $request) {
        $semester = $request->input('semester'); // بدون افتراض فصل محدد
        $user_studentprog = User::where('role', 'student')->get();
    
        $examsnetworkQuery = ExameManages::where('specializations_id', 'قسم الشبكات')
                                         ->where('academic_year', 'السنة الاولى');
    
        if ($semester) {
            $examsnetworkQuery->where('semester', $semester);
        }
    
        $examsnetwork = $examsnetworkQuery->orderBy('created_at', 'desc')->get();
    
        return view('DashBoard.exameManage.viewMark.net_year_one', compact('examsnetwork', 'user_studentprog', 'semester'));
    }
    
    
    // public function viewMarknetworkYearone(){
    //     $examsnetwork = ExameManages::where('specializations_id' , 'قسم الشبكات ')
    //     ->orderBy('created_at', 'desc')->get();
    //     return view('DashBoard.exameManage.viewMark.net_year_one' , compact( 'examsnetwork'));
    // }

    public function viewMarnetworkYeartwo(Request $request) {
        $semester = $request->input('semester'); // بدون افتراض فصل محدد
        $user_studentprog = User::where('role', 'student')->get();
    
        $examsnetworkQuery = ExameManages::where('specializations_id', 'قسم الشبكات')
                                         ->where('academic_year', 'السنة الثاني');
    
        if ($semester) {
            $examsnetworkQuery->where('semester', $semester);
        }
    
        $examsnetwork = $examsnetworkQuery->orderBy('created_at', 'desc')->get();
    
        return view('DashBoard.exameManage.viewMark.net_year_tow', compact('examsnetwork', 'user_studentprog', 'semester'));
    }
    
    // public function viewMarnetworkYeartwo(){
    //     $examsnetwork = ExameManages::where('specializations_id' , 'قسم الشبكات ')->get();
    //     return view('DashBoard.exameManage.viewMark.net_year_tow' , compact( 'examsnetwork'));
    // }

    public function viewMarkminYearone(Request $request) {
        $semester = $request->input('semester'); // بدون افتراض فصل محدد
        $user_studentprog = User::where('role', 'student')->get();
    
        $examsnetminQuery = ExameManages::where('specializations_id', 'قسم الصيانة')
                                        ->where('academic_year', 'السنة الاولى');
    
        if ($semester) {
            $examsnetminQuery->where('semester', $semester);
        }
    
        $examsnetmin = $examsnetminQuery->orderBy('created_at', 'desc')->get();
    
        return view('DashBoard.exameManage.viewMark.main_year_one', compact('examsnetmin', 'user_studentprog', 'semester'));
    }
    
    // public function viewMarkminYearone(){
    //     $examsnetmin = ExameManages::where('specializations_id' , 'قسم الصيانة ')->get();
    //     return view('DashBoard.exameManage.viewMark.main_year_one' , compact( 'examsnetmin'));
    // }


    public function viewMarkminYeartwo(Request $request) {
        $semester = $request->input('semester'); // بدون افتراض فصل محدد
        $user_studentprog = User::where('role', 'student')->get();
    
        $examsnetminQuery = ExameManages::where('specializations_id', 'قسم الصيانة')
                                        ->where('academic_year', 'السنة الثانية');
    
        if ($semester) {
            $examsnetminQuery->where('semester', $semester);
        }
    
        $examsnetmin = $examsnetminQuery->orderBy('created_at', 'desc')->get();
    
        return view('DashBoard.exameManage.viewMark.main_year_tow', compact('examsnetmin', 'user_studentprog', 'semester'));
    }
    
    // public function viewMarkminYeartwo(){
    //     $examsnetmin = ExameManages::where('specializations_id' , 'قسم الصيانة ')->get();
    //     return view('DashBoard.exameManage.viewMark.main_year_tow' , compact( 'examsnetmin'));

    // }


    public function destroy($id){
        try {
            $exame  = ExameManages::find($id);         
            $exame->delete();
            session()->flash('success' , 'تم الحذف  بالنجاح');
            return redirect()->back();

        } catch (\Throwable $th) {
            
            return redirect()->back();
        }
    }



    // ======================= View All Mark as Programming Yeaer One And Two   ===========
    
    public function programmingOne()
    {
        return view('DashBoard.exameManage.homeMark.mark');
    }
    public function NetworkOne()
    {
        return view('DashBoard.exameManage.homeMark.markNetwork');
    }
    public function MainOne()
    {
        return view('DashBoard.exameManage.homeMark.mark');
    }
    


    public function EditAllMarkStudentProgOne($id)
    {
        $exame_edit = ExameManages::find($id);
        $specialiation = Specialization::where('name', 'قسم البرمجة')->first();
    
        $student = User::where('role', 'student')->where('specializations_id', "قسم البرمجة")->get();
    
        $subject_first_year = collect();
        $subject_second_year = collect();
    
        if ($specialiation) {
            $subject_first_year = $specialiation->subjects()
                ->where('semester', 'الفصل الاول')
                ->where('year', 'السنة الاولى')
                ->get();
    
            $subject_second_year = $specialiation->subjects()
                ->where('semester', 'الفصل الثاني')
                ->where('year', 'السنة الاولى')
                ->get();
        }
    
        return view('DashBoard.exameManage.EditAllMarkStudent.edit_programming_one', compact('subject_first_year', 'subject_second_year', 'student', 'exame_edit'));
    }
    
    public function EditAllMarkStudentNetworkOne($id)
    {
        $exame_edit = ExameManages::find($id);
        $specialiation  = Specialization::where( 'name' ,  'قسم الشبكات')->first();
        // $subject_prog  = $specialiation ?  $specialiation->subjects :collect(); 
        // $student =  User::where('role' , 'student')->where('specializations_id' , 'قسم الشبكات')->get();


           
        $student = User::where('role', 'student')->where('specializations_id', "قسم الشبكات")->get();
    
        $subject_first_year = collect();
        $subject_second_year = collect();
    
        if ($specialiation) {
            $subject_first_year = $specialiation->subjects()
                ->where('semester', 'الفصل الاول')
                ->where('year', 'السنة الاولى')
                ->get();
    
            $subject_second_year = $specialiation->subjects()
                ->where('semester', 'الفصل الثاني')
                ->where('year', 'السنة الاولى')
                ->get();
        }

        return view('DashBoard.exameManage.EditAllMarkStudent.edit_network_one' , compact( 'subject_first_year' ,'subject_second_year' ,  'student','exame_edit'));

    }
    public function EditAllMarkStudentMainOne($id)
    {
        $exame_edit = ExameManages::find($id);
        $specialiation  = Specialization::where( 'name' ,  'قسم الصيانة')->first();
        // $subject_prog  = $specialiation ?  $specialiation->subjects :collect(); 
        // $student =  User::where('role' , 'student')->where('specializations_id' , 'قسم الصيانة')->get();

           
        $student = User::where('role', 'student')->where('specializations_id', "قسم الصيانة")->get();
    
        $subject_first_year = collect();
        $subject_second_year = collect();
    
        if ($specialiation) {
            $subject_first_year = $specialiation->subjects()
                ->where('semester', 'الفصل الاول')
                ->where('year', 'السنة الاولى')
                ->get();
    
            $subject_second_year = $specialiation->subjects()
                ->where('semester', 'الفصل الثاني')
                ->where('year', 'السنة الاولى')
                ->get();
        }
        return view('DashBoard.exameManage.EditAllMarkStudent.edit_main_one' , compact( 'subject_first_year' ,  'subject_second_year' , 'student','exame_edit'));

    }
    public function EditAllMarkStudentProgTwo($id)
    {
        $exame_edit = ExameManages::find($id);
        $specialiation  = Specialization::where( 'name' ,  'قسم البرمجة')->first();
        // $subject_prog  = $specialiation ?  $specialiation->subjects :collect(); 
        $student =  StudentYearTwo::where('specializations_id' , 'قسم البرمجة')->get();

        // $student = User::where('role', 'student')->where('specializations_id', "قسم الصيانة")->get();
    
        $subject_first_year = collect();
        $subject_second_year = collect();
    
        if ($specialiation) {
            $subject_first_year = $specialiation->subjects()
                ->where('semester', 'الفصل الاول')
                ->where('year', 'السنة الثانية')
                ->get();
    
            $subject_second_year = $specialiation->subjects()
                ->where('semester', 'الفصل الثاني')
                ->where('year', 'السنة الثانية')
                ->get();
        }
        return view('DashBoard.exameManage.EditAllMarkStudent.edit_programming_two' , compact( 'subject_second_year' ,'subject_first_year',  'student','exame_edit'));

    }
    public function EditAllMarkStudentNetworkTwo($id)
    {
        $exame_edit = ExameManages::find($id);
        $specialiation  = Specialization::where( 'name' ,  'قسم الشبكات')->first();
        // $subject_prog  = $specialiation ?  $specialiation->subjects :collect(); 
        $student =  StudentYearTwo::where('specializations_id' , 'قسم الشبكات')->get();


         
        $subject_first_year = collect();
        $subject_second_year = collect();
    
        if ($specialiation) {
            $subject_first_year = $specialiation->subjects()
                ->where('semester', 'الفصل الاول')
                ->where('year', 'السنة الثانية')
                ->get();
    
            $subject_second_year = $specialiation->subjects()
                ->where('semester', 'الفصل الثاني')
                ->where('year', 'السنة الثانية')
                ->get();
        }
        return view('DashBoard.exameManage.EditAllMarkStudent.edit_network_two' , compact( 'subject_first_year'  ,'subject_second_year' ,  'student','exame_edit'));

    }
    public function EditAllMarkStudentMainTwo($id)
    {
        $exame_edit = ExameManages::find($id);
        $specialiation  = Specialization::where( 'name' ,  'قسم الصيانة')->first();
        // $subject_prog  = $specialiation ?  $specialiation->subjects :collect(); 
        $student =  StudentYearTwo::where('specializations_id' , 'قسم الصيانة')->get();
        
         
        $subject_first_year = collect();
        $subject_second_year = collect();
    
        if ($specialiation) {
            $subject_first_year = $specialiation->subjects()
                ->where('semester', 'الفصل الاول')
                ->where('year', 'السنة الثانية')
                ->get();
    
            $subject_second_year = $specialiation->subjects()
                ->where('semester', 'الفصل الثاني')
                ->where('year', 'السنة الثانية')
                ->get();
        }
        return view('DashBoard.exameManage.EditAllMarkStudent.edit_main_two' , compact( 'subject_first_year' ,'subject_second_year' , 'student','exame_edit'));

    }


    // public function updateProgrammingYearOne(Request $request, $id)
    // {
    //     // Find the exam record by ID
    //     $exameManage = ExameManages::find($id);
    
    //     // Validate the request data
    //     $this->validate($request, [
    //         'subject_id' => 'required',
    //         'student_id' => 'required',
    //         'degree_n' => 'required',
    //         'degree_p' => 'required',
    //         'exam_n' => 'required',
    //         'exam_p' => 'required',
    //         'semester' => 'required'
    //     ]);
    
    //     // Search for the student
    //     $student = User::where('role', 'student')
    //                    ->where('student_id', $request->student_id)
    //                    ->first();
    
    //     if (!$student) {
    //         session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
    //         return redirect()->back();
    //     }
    
    //     // Check if the student has taken the same subject before, excluding the current exam record
    //     $existingExame = ExameManages::where('student_id', $student->student_id)
    //                                  ->where('subject_id', $request->subject_id)
    //                                  ->where('id', '!=', $id) // Exclude current exam from check
    //                                  ->exists();
    
    //     if ($existingExame) {
    //         session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
    //         return redirect()->back();
    //     }
    
    //     // Update the exam details
    //     $exameManage->subject_id = $request->subject_id;
    //     $exameManage->student_id = $student->student_id;
    //     $exameManage->student_number_id = $student->student_id;
    //     $exameManage->specializations_id = 'قسم البرمجة'; // Update specialization
    //     $exameManage->Supplementary_course = $request->Supplementary_course;
    //     $exameManage->academic_year = 'السنة الاولى';
    //     $exameManage->degree_n = $request->degree_n;
    //     $exameManage->degree_p = $request->degree_p;
    //     $exameManage->exam_n = $request->exam_n;
    //     $exameManage->exam_p = $request->exam_p;
    //     $exameManage->semester = $request->semester;
    //     $exameManage->save();
    
    //     // Fetch all subjects the student took in the first year
    //     $exams = ExameManages::where('student_id', $student->student_id)
    //                          ->where('academic_year', 'السنة الاولى')
    //                          ->get();
    
    //     // Check if the student completed exactly 13 subjects
    //     if ($exams->count() == 13) {
    //         $failedSubjectsCount = 0;
    
    //         // Calculate the number of failed subjects
    //         foreach ($exams as $exam) {
    //             $firstSemesterTotal = $exam->degree_n;
    //             $secondSemesterTotal = $exam->degree_p;
    //             $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
    
    //             // Check if the overall total for the exam is less than 60
    //             if ($overallTotal < 60) {
    //                 $failedSubjectsCount++;
    //             }
    //         }
    
    //         // If the student failed in more than three subjects
    //         if ($failedSubjectsCount > 3) {
    //             // Remove the student from the second year if they exist
    //             StudentYearTwo::where('student_id', $student->student_id)->delete();
    
    //             // Remove any supplementary records related to the first year
    //             SupplementaryExams::where('student_id', $student->student_id)
    //                               ->whereIn('exam_id', function ($query) {
    //                                   $query->select('id')
    //                                         ->from('exame_manages')
    //                                         ->where('academic_year', 'السنة الاولى');
    //                               })
    //                               ->delete();
    
    //             // Remove any objections or related records if applicable
    //             // Objections::where('student_id', $student->student_id)->delete();
    
    //             // Set student back to the first year
    //             $student->is_hidden = false; // Or any logic to "unhide" the student
    //             $student->save();
    
    //             session()->flash('error', 'تم إعادة الطالب إلى السنة الأولى بسبب الفشل في أكثر من ثلاث مواد.');
    //         } else {
    //             // If the student has not failed more than three subjects, update them to the second year if not already done
    //             $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
    //             if (!$existingStudentYearTwo) {
    //                 $studentTwo = new StudentYearTwo();
    //                 $studentTwo->student_id = $student->student_id;
    //                 $studentTwo->student_name = $student->name;
    //                 $studentTwo->specializations_id = 'قسم البرمجة';
    //                 $studentTwo->year_one_student = 'السنة الثانية';
    //                 $student->is_hidden = true; // Set student as hidden if needed
    //                 $student->save();
    //                 $studentTwo->save();
    //                 session()->flash('successprg', 'مبروك تم انتقال الطلاب الى السنة الثانية');
    //             }
    //         }
    //     }
    
    //     session()->flash('success', 'تم التعديل بنجاح');
    //     return redirect()->back();
    // }
    
    
   
    public function updateProgrammingYearOne(Request $request, $id)
{
    // Find the exam record by ID
    $exameManage = ExameManages::find($id);
    
    $this->validate($request, [
        'subject_id' => 'required',
        'student_id' => 'required',
        'degree_n' => 'required',
        'degree_p' => 'required',
        'exam_n' => 'required',
        'exam_p' => 'required',
        'semester' => 'required'
    ]);

    // Search for the student
    $student = User::where('role', 'student')
                    ->where('student_id', $request->student_id)
                    ->first();

    if (!$student) {
        session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
        return redirect()->back();
    }

    // Check if the student has taken the same subject before, excluding the current exam record
    $existingExame = ExameManages::where('student_id', $student->student_id)
                                ->where('subject_id', $request->subject_id)
                                ->where('id', '!=', $id) // Exclude current exam from check
                                ->exists();

    if ($existingExame) {
        session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
        return redirect()->back();
    }

    // Update the exam details
    $exameManage->subject_id = $request->subject_id;
    $exameManage->student_id = $student->student_id;
    $exameManage->student_number_id = $student->student_id;
    $exameManage->specializations_id = 'قسم البرمجة';
    $exameManage->Supplementary_course = $request->Supplementary_course;
    $exameManage->academic_year = 'السنة الاولى';
    $exameManage->degree_n = $request->degree_n;
    $exameManage->degree_p = $request->degree_p;
    $exameManage->exam_n = $request->exam_n;
    $exameManage->exam_p = $request->exam_p;
    $exameManage->semester = $request->semester;
    $exameManage->save();

    // Fetch all subjects the student took in the first year
    $exams = ExameManages::where('student_id', $student->student_id)
        ->where('academic_year', 'السنة الاولى')
        ->get();

    $failedSubjectsCount = 0;

    // Calculate the number of failed subjects
    foreach ($exams as $exam) {
        $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
        $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
        $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

        if ($overallTotal < 60) { // Assuming 60 is the passing grade
            $failedSubjectsCount++;
        }
    }

    // If the student has failed more than three subjects
    if ($failedSubjectsCount > 3) {
        // Remove student from second year
        StudentYearTwo::where('student_id', $student->student_id)->delete();

        // Reset student to first year
        $student->is_hidden = false;
        $student->save();

        session()->flash('error', 'تم إرجاع الطالب إلى السنة الأولى بسبب رسوبه في أكثر من ثلاث مواد');
    } else {
        // If the student has failed less than or equal to three subjects and completed all subjects
        if ($failedSubjectsCount <= 3 && $exams->count() == 13) {
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
                session()->flash('success', 'مبروك تم انتقال الطالب إلى السنة الثانية');
            }
        }

        session()->flash('success', 'تم التعديل بنجاح');
    }

    return redirect()->back();
}



    public function updateNetWorkYearOne(Request $request, $id)
    {
        // Find the exam record by ID
        $exameManage = ExameManages::find($id);
        
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required'
        ]);

        // Search for the student
        $student = User::where('role', 'student')
                        ->where('student_id', $request->student_id)
                        ->first();

        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }

        // Check if the student has taken the same subject before, excluding the current exam record
        $existingExame = ExameManages::where('student_id', $student->student_id)
                                    ->where('subject_id', $request->subject_id)
                                    ->where('id', '!=', $id) // Exclude current exam from check
                                    ->exists();

        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }

        // Update the exam details
        $exameManage->subject_id = $request->subject_id;
        $exameManage->student_id = $student->student_id;
        $exameManage->student_number_id = $student->student_id;
        $exameManage->specializations_id = 'قسم الشبكات'; 
        $exameManage->Supplementary_course = $request->Supplementary_course;
        $exameManage->academic_year = 'السنة الاولى';
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p = $request->degree_p;
        $exameManage->exam_n = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();

        // Fetch all subjects the student took in the first year
        $exams = ExameManages::where('student_id', $student->student_id)
            ->where('academic_year', 'السنة الاولى')
            ->get();

        $failedSubjectsCount = 0;

        // Calculate the number of failed subjects
        foreach ($exams as $exam) {
            $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
            $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
            $overallTotal = $firstSemesterTotal + $secondSemesterTotal;

            if ($overallTotal < 60) { // Assuming 60 is the passing grade
                $failedSubjectsCount++;
            }
        }

        // If the student has failed more than three subjects
        if ($failedSubjectsCount > 3) {
            // Remove student from second year
            StudentYearTwo::where('student_id', $student->student_id)->delete();

            // Reset student to first year
            $student->is_hidden = false;
            $student->save();

            session()->flash('error', 'تم إرجاع الطالب إلى السنة الأولى بسبب رسوبه في أكثر من ثلاث مواد');
        } else {
            // If the student has failed less than or equal to three subjects and completed all subjects
            if ($failedSubjectsCount <= 3 && $exams->count() == 13) {
                // Check if the student is already in the second year
                $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
                if (!$existingStudentYearTwo) {
                    $studentTwo = new StudentYearTwo();
                    $studentTwo->student_id = $student->student_id;
                    $studentTwo->student_name = $student->name;
                    $studentTwo->specializations_id = 'قسم الشبكات'; // Update specialization
                    $studentTwo->year_one_student = 'السنة الثانية';
                    $student->is_hidden = true;
                    $student->save();
                    $studentTwo->save();
                    session()->flash('success', 'مبروك تم انتقال الطالب إلى السنة الثانية');
                }
            }

            session()->flash('success', 'تم التعديل بنجاح');
        }

        return redirect()->back();
    }









    public function updateMainYearOne(Request $request, $id)
    {
        // Find the exam record by ID
        $exameManage = ExameManages::find($id);
        
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required'
        ]);
    
        // Search for the student
        $student = User::where('role', 'student')
                        ->where('student_id', $request->student_id)
                        ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // Check if the student has taken the same subject before, excluding the current exam record
        $existingExame = ExameManages::where('student_id', $student->student_id)
                                    ->where('subject_id', $request->subject_id)
                                    ->where('id', '!=', $id) // Exclude current exam from check
                                    ->exists();
    
        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }
    
        // Update the exam details
        $exameManage->subject_id = $request->subject_id;
        $exameManage->student_id = $student->student_id;
        $exameManage->student_number_id = $student->student_id;
        $exameManage->specializations_id = 'قسم الصيانة'; // Update specialization
        $exameManage->Supplementary_course = $request->Supplementary_course;
        $exameManage->academic_year = 'السنة الاولى';
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p = $request->degree_p;
        $exameManage->exam_n = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
    
        // Fetch all subjects the student took in the first year
        $exams = ExameManages::where('student_id', $student->student_id)
            ->where('academic_year', 'السنة الاولى')
            ->get();
    
        $failedSubjectsCount = 0;
    
        // Calculate the number of failed subjects
        foreach ($exams as $exam) {
            $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
            $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
            $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
    
            if ($overallTotal < 60) { // Assuming 60 is the passing grade
                $failedSubjectsCount++;
            }
        }
    
        // If the student has failed more than three subjects
        if ($failedSubjectsCount > 3) {
            // Remove student from second year
            StudentYearTwo::where('student_id', $student->student_id)->delete();
    
            // Reset student to first year
            $student->is_hidden = false;
            $student->save();
    
            session()->flash('error', 'تم إرجاع الطالب إلى السنة الأولى بسبب رسوبه في أكثر من ثلاث مواد');
        } else {
            // If the student has failed less than or equal to three subjects and completed all subjects
            if ($failedSubjectsCount <= 3 && $exams->count() == 13) {
                // Check if the student is already in the second year
                $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
                if (!$existingStudentYearTwo) {
                    $studentTwo = new StudentYearTwo();
                    $studentTwo->student_id = $student->student_id;
                    $studentTwo->student_name = $student->name;
                    $studentTwo->specializations_id = 'قسم الصيانة'; // Update specialization
                    $studentTwo->year_one_student = 'السنة الثانية';
                    $student->is_hidden = true;
                    $student->save();
                    $studentTwo->save();
                    session()->flash('success', 'مبروك تم انتقال الطالب إلى السنة الثانية');
                }
            }
    
            session()->flash('success', 'تم التعديل بنجاح');
        }
    
        return redirect()->back();
    }
    

















    // public function updateMainYearOne(Request $request, $id)
    // {
    //     $exameManage = ExameManages::find($id);
    
    //     $this->validate($request, [
    //         'subject_id' => 'required',
    //         'student_id' => 'required',
    //         'degree_n' => 'required',
    //         'degree_p' => 'required',
    //         'exam_n' => 'required',
    //         'exam_p' => 'required',
    //         'semester' => 'required',
    //     ]);
    
    //     // Search for the student
    //     $student = User::where('role', 'student')
    //         ->where('student_id', $request->student_id)
    //         ->first();
    
    //     if (!$student) {


    //         session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
    //         return redirect()->back();
    //     }
    
    //     // Check if the student has taken the same subject before
    //     $existingExame = ExameManages::where('student_id', $student->student_id)
    //         ->where('subject_id', $request->subject_id)
    //         ->where('id', '!=', $id) // Exclude current exam from check
    //         ->exists();
    
    //     if ($existingExame) {
    //         session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
    //         return redirect()->back();
    //     }
    
    //     // Update the exam details
    //     $exameManage->subject_id = $request->subject_id;
    //     $exameManage->student_id = $student->student_id;
    //     $exameManage->student_number_id = $student->student_id;
    //     $exameManage->specializations_id = 'قسم الصيانة'; // Update specialization
    //     $exameManage->Supplementary_course = $request->Supplementary_course;
    //     $exameManage->academic_year = 'السنة الاولى';
    //     $exameManage->degree_n = $request->degree_n;
    //     $exameManage->degree_p = $request->degree_p;
    //     $exameManage->exam_n = $request->exam_n;
    //     $exameManage->exam_p = $request->exam_p;
    //     $exameManage->semester = $request->semester;
    //     $exameManage->save();
    
    //     // Fetch all subjects the student took in the first year
    //     $exams = ExameManages::where('student_id', $student->student_id)
    //         ->where('academic_year', 'السنة الاولى')
    //         ->get();
    
    //     $failedSubjectsCount = 0;

    //     // Calculate the number of failed subjects
    //     foreach ($exams as $exam) {
    //         $firstSemesterTotal = $exam->degree_n + $exam->degree_p;
    //         $secondSemesterTotal = $exam->exam_n + $exam->exam_p;
    //         $overallTotal = $firstSemesterTotal + $secondSemesterTotal;
    
    //         if ($overallTotal < 60) { // Assuming 60 is the passing grade
    //             $failedSubjectsCount++;
    //         }
    //     }
    
    //     // If the student has failed less than three subjects and completed twelve subjects, advance them to the second year
    //     if ($failedSubjectsCount <= 3 && $exams->count() == 12) {
    //         // Check if the student is already in the second year
    //         $existingStudentYearTwo = StudentYearTwo::where('student_id', $student->student_id)->exists();
    //         if (!$existingStudentYearTwo) {
    //             $studentTwo = new StudentYearTwo();
    //             $studentTwo->student_id = $student->student_id;
    //             $studentTwo->student_name = $student->name;
    //             $studentTwo->specializations_id = 'قسم الصيانة'; // Update specialization
    //             $studentTwo->year_one_student = 'السنة الثانية';
    //             $studentTwo->save();
    
    //             // Update is_hidden status for student
    //             $student->is_hidden = true;
    //             $student->save();
    
    //             session()->flash('successprg', 'مبروك تم انتقال الطلاب الى السنة الثانية');
    //         }
    //     }
    
    //     session()->flash('success', 'تم التعديل بنجاح');
    //     return redirect()->back();
    // }
    








    public function updateProgrammingYearTwo(Request $request, $id)
    {
        $exameManage = ExameManages::find($id);
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required',
        ]);

    
        // البحث عن الطالب باستخدام الرقم الجامعي
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // التحقق من أن الطالب لم يأخذ نفس المادة مرتين
        $existingExame = ExameManages::where('student_id', $student->student_id)
        ->where('subject_id', $request->subject_id)
        ->where('id', '!=', $id) // Exclude current exam from check
        ->exists();

            if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
            }
    
        // إخفاء علامات الطالب في السنة الأولى إذا كان قد نجح في السنة الثانية
        $examsFirstYear = ExameManages::where('student_id', $student->student_id)
                                       ->where('academic_year', 'السنة الأولى')
                                       ->get();
    
        foreach ($examsFirstYear as $exam) {
            $exam->is_hidden = true;
            $exam->save();
        }
    
        // إضافة علامات الطالب في السنة الثانية
       
        $exameManage->subject_id  = $request->subject_id;
        $exameManage->student_id  = $student->student_id;
        $exameManage->student_number_id  = $student->student_id;
        $exameManage->specializations_id = 'قسم البرمجة';
        $exameManage->Supplementary_course  = $request->Supplementary_course;
        $exameManage->academic_year  = 'السنة الثاني'; // تأكد من الاختلاف هنا
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p  = $request->degree_p;
        $exameManage->exam_n  = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }
    public function updateNetworkYearTwo(Request $request, $id)
    {
        $exameManage = ExameManages::find($id);
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required',
        ]);

    
        // البحث عن الطالب باستخدام الرقم الجامعي
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // التحقق من أن الطالب لم يأخذ نفس المادة مرتين
        $existingExame = ExameManages::where('student_id', $student->student_id)
        ->where('subject_id', $request->subject_id)
        ->where('id', '!=', $id) // Exclude current exam from check
        ->exists();

            if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
            }
    
        // إخفاء علامات الطالب في السنة الأولى إذا كان قد نجح في السنة الثانية
        $examsFirstYear = ExameManages::where('student_id', $student->student_id)
                                       ->where('academic_year', 'السنة الأولى')
                                       ->get();
    
        foreach ($examsFirstYear as $exam) {
            $exam->is_hidden = true;
            $exam->save();
        }
    
        // إضافة علامات الطالب في السنة الثانية
       
        $exameManage->subject_id  = $request->subject_id;
        $exameManage->student_id  = $student->student_id;
        $exameManage->student_number_id  = $student->student_id;
        $exameManage->specializations_id = 'قسم الشبكات';
        $exameManage->Supplementary_course  = $request->Supplementary_course;
        $exameManage->academic_year  = 'السنة الثاني'; // تأكد من الاختلاف هنا
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p  = $request->degree_p;
        $exameManage->exam_n  = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }
    public function updateMainYearTwo(Request $request, $id)
    {
        $exameManage = ExameManages::find($id);
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
        ]);

    
        // البحث عن الطالب باستخدام الرقم الجامعي
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // التحقق من أن الطالب لم يأخذ نفس المادة مرتين
        $existingExame = ExameManages::where('student_id', $student->student_id)
        ->where('subject_id', $request->subject_id)
        ->where('id', '!=', $id) // Exclude current exam from check
        ->exists();

            if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
            }
    
        // إخفاء علامات الطالب في السنة الأولى إذا كان قد نجح في السنة الثانية
        $examsFirstYear = ExameManages::where('student_id', $student->student_id)
                                       ->where('academic_year', 'السنة الأولى')
                                       ->get();
    
        foreach ($examsFirstYear as $exam) {
            $exam->is_hidden = true;
            $exam->save();
        }
    
        // إضافة علامات الطالب في السنة الثانية
       
        $exameManage->subject_id  = $request->subject_id;
        $exameManage->student_id  = $student->student_id;
        $exameManage->student_number_id  = $student->student_id;
        $exameManage->specializations_id = 'قسم الصيانة';
        $exameManage->Supplementary_course  = $request->Supplementary_course;
        $exameManage->academic_year  = 'السنة الثاني'; // تأكد من الاختلاف هنا
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p  = $request->degree_p;
        $exameManage->exam_n  = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }


// ================= Student Year Two ================================
// ================= Student Year Two ================================


    public  function createStudentTwoProg()
    {
        // $student = User::where('role' , 'student')->where('specializations_id' , 'قسم البرمجة')->get();
        $student = StudentYearTwo::where('specializations_id' , 'قسم البرمجة')->get();

        $specialization = Specialization::where('name', 'قسم البرمجة')->first();

        $subject_first_year = collect();
        $subject_second_year = collect();

        if ($specialization) {
        $subject_first_year = $specialization->subjects()
                                        ->where('semester', 'الفصل الاول')
                                        ->where('year', 'السنة الثانية')
                                        ->get();

        $subject_second_year = $specialization->subjects()
                                        ->where('semester', 'الفصل الثاني')
                                        ->where('year', 'السنة الثانية')
                                        ->get();
        }
        // $subject_prog = $specialization_prog ? $specialization_prog->subjects :collect();
        
        return view('DashBoard.exameManage.addMarkExamPrograTwo' , compact('student' , 'subject_first_year'  , 'subject_second_year'));
        // return view('DashBoard.exameManage.addMarkExamPrograTwo' , compact('student' , 'subject_prog'));
    } 


    public function featchSubjectsBySemeterProgTwo(Request $request)
    {
        $year = $request->year;
        $semester = $request->semester;
        $specialization_id = Specialization::where('name', 'قسم البرمجة')->first()->id;
    
        $subjects = Subject::whereHas('specializations', function ($query) use ($specialization_id) {
                            $query->where('specialization_id', $specialization_id);
                        })
                        ->where('year', $year)
                        ->where('semester', $semester)
                        ->get();
    
        return response()->json($subjects);
    }




    public function storeStudentTwoMarkProg(Request $request)
    {
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required', 
        ]);

    
        // البحث عن الطالب باستخدام الرقم الجامعي
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // التحقق من أن الطالب لم يأخذ نفس المادة مرتين
        $existingExame = ExameManages::where('student_id', $student->student_id)
                                      ->where('subject_id', $request->subject_id)
                                      ->exists();
    
        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }
    
        // إخفاء علامات الطالب في السنة الأولى إذا كان قد نجح في السنة الثانية
        $examsFirstYear = ExameManages::where('student_id', $student->student_id)
                                       ->where('academic_year', 'السنة الأولى')
                                       ->get();
    
        foreach ($examsFirstYear as $exam) {
            $exam->is_hidden = true;
            $exam->save();
        }
    
        // إضافة علامات الطالب في السنة الثانية
        $exameManage = new ExameManages();
        $exameManage->subject_id  = $request->subject_id;
        $exameManage->student_id  = $student->student_id;
        $exameManage->student_number_id  = $student->student_id;
        $exameManage->specializations_id = 'قسم البرمجة';
        $exameManage->Supplementary_course  = $request->Supplementary_course;
        $exameManage->academic_year  = 'السنة الثاني'; // تأكد من الاختلاف هنا
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p  = $request->degree_p;
        $exameManage->exam_n  = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester; 
        $exameManage->save();
    
        session()->flash('success', 'تم إضافة النتيجة بنجاح');
        return redirect()->back();
    }
    
    public  function createStudentTwoNet()
    {
        // $student = User::where('role' , 'student')->where('specializations_id' , 'قسم الشبكات')->get();
        $student = StudentYearTwo::where('specializations_id' , 'قسم الشبكات')->get();
        $specialization_prog = Specialization::where('name', 'قسم الشبكات')->first();

        $subject_first_year = collect();
        $subject_second_year = collect();

        if($specialization_prog){
            $subject_first_year = $specialization_prog->subjects()
            ->where('semester', 'الفصل الاول')
            ->where('year', 'السنة الثانية')
            ->get();
            $subject_second_year = $specialization_prog->subjects()
            ->where('semester', 'الفصل الثاني')
            ->where('year', 'السنة الثانية')
            ->get();

        }
        // $subject_net = $specialization_prog ? $specialization_prog->subjects :collect();
        
        return view('DashBoard.exameManage.addMarkExamNetworkTwo' , compact('student' , 'subject_first_year'  , 'subject_second_year' ));
        // return view('DashBoard.exameManage.addMarkExamNetworkTwo' , compact('student' , 'subject_net'));
    } 

    public function fetchSubjectsSemesterNetwork(Request $request)
    {
        $year = $request->year;
        $semester = $request->semester;
        $specialization_id = Specialization::where('name', 'قسم الشبكات')->first()->id;
    
        $subjects = Subject::whereHas('specializations', function ($query) use ($specialization_id) {
                            $query->where('specialization_id', $specialization_id);
                        })
                        ->where('year', $year)
                        ->where('semester', $semester)
                        ->get();
    
        return response()->json($subjects);
    }
    public function storeStudentTwoNet(Request $request)
    {
   
    $this->validate($request, [
                'subject_id' => 'required',
                'student_id' => 'required',
                'degree_n' => 'required',
                'degree_p' => 'required',
                'exam_n' => 'required',
                'exam_p' => 'required',
                'semester' => 'required', 
            ]);
            
        
        // البحث عن الطالب باستخدام الرقم الجامعي
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // التحقق من أن الطالب لم يأخذ نفس المادة مرتين
        $existingExame = ExameManages::where('student_id', $student->student_id)
                                      ->where('subject_id', $request->subject_id)
                                      ->exists();
    
        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }
    
        // إخفاء علامات الطالب في السنة الأولى إذا كان قد نجح في السنة الثانية
        $examsFirstYear = ExameManages::where('student_id', $student->student_id)
                                       ->where('academic_year', 'السنة الأولى')
                                       ->get();
    
        foreach ($examsFirstYear as $exam) {
            $exam->is_hidden = true;
            $exam->save();
        }
    
        // إضافة علامات الطالب في السنة الثانية
        $exameManage = new ExameManages();
        $exameManage->subject_id  = $request->subject_id;
        $exameManage->student_id  = $student->student_id;
        $exameManage->student_number_id  = $student->student_id;
        $exameManage->specializations_id = 'قسم الشبكات';
        $exameManage->Supplementary_course  = $request->Supplementary_course;
        $exameManage->academic_year  = 'السنة الثاني'; // تأكد من الاختلاف هنا
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p  = $request->degree_p;
        $exameManage->exam_n  = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
    
        session()->flash('success', 'تم إضافة النتيجة بنجاح');
        return redirect()->back();

    }
    public  function createStudentTwoMani()
    {
        // $student = User::where('role' , 'student')->where('specializations_id' , 'قسم الصيانة')->get();
        $student = StudentYearTwo::where('specializations_id' , 'قسم الصيانة')->get();
        $specialization_prog = Specialization::where('name', 'قسم الصيانة')->first();



        $subject_first_year = collect();
        $subject_second_year = collect();

        if ($specialization_prog) {
        $subject_first_year = $specialization_prog->subjects()
                                        ->where('semester', 'الفصل الاول')
                                        ->where('year', 'السنة الثانية')
                                        ->get();

        $subject_second_year = $specialization_prog->subjects()
                                        ->where('semester', 'الفصل الثاني')
                                        ->where('year', 'السنة الثانية')
                                        ->get();
        }
        // $subject_main = $specialization_prog ? $specialization_prog->subjects :collect(); 
        return view('DashBoard.exameManage.addMarkExamMaintianceTwo' , compact('student' , 'subject_second_year' ,'subject_second_year'));
       // return view('DashBoard.exameManage.addMarkExamMaintianceTwo' , compact('student' , 'subject_main'));
} 



    public function fetchSubjectsSemesterMain(Request $request){
        $year = $request->year;
        $semester = $request->semester;
        $specialization_id = Specialization::where('name', 'قسم الصيانة')->first()->id;

            $subjects = Subject::whereHas('specializations', function ($query) use ($specialization_id) {
                $query->where('specialization_id', $specialization_id);
            })
            ->where('year', $year)
            ->where('semester', $semester)
            ->get();

            return response()->json($subjects);
    }
    public function storeStudentTwoMain(Request $request)
    {
   
        $this->validate($request, [
            'subject_id' => 'required',
            'student_id' => 'required',
            'degree_n' => 'required',
            'degree_p' => 'required',
            'exam_n' => 'required',
            'exam_p' => 'required',
            'semester' => 'required', 
        ]);
        
    
        // البحث عن الطالب باستخدام الرقم الجامعي
        $student = User::where('role', 'student')
            ->where('student_id', $request->student_id)
            ->first();
    
        if (!$student) {
            session()->flash('error', 'لم يتم العثور على الطالب باستخدام الرقم الجامعي المقدم');
            return redirect()->back();
        }
    
        // التحقق من أن الطالب لم يأخذ نفس المادة مرتين
        $existingExame = ExameManages::where('student_id', $student->student_id)
                                      ->where('subject_id', $request->subject_id)
                                      ->exists();
    
        if ($existingExame) {
            session()->flash('error', 'هذا الطالب قد أخذ هذه المادة من قبل');
            return redirect()->back();
        }
    
        // إخفاء علامات الطالب في السنة الأولى إذا كان قد نجح في السنة الثانية
        $examsFirstYear = ExameManages::where('student_id', $student->student_id)
                                       ->where('academic_year', 'السنة الأولى')
                                       ->get();
    
        foreach ($examsFirstYear as $exam) {
            $exam->is_hidden = true;
            $exam->save();
        }
    
        // إضافة علامات الطالب في السنة الثانية
        $exameManage = new ExameManages();
        $exameManage->subject_id  = $request->subject_id;
        $exameManage->student_id  = $student->student_id;
        $exameManage->student_number_id  = $student->student_id;
        $exameManage->specializations_id = 'قسم الصيانة';
        $exameManage->Supplementary_course  = $request->Supplementary_course;
        $exameManage->academic_year  = 'السنة الثاني'; // تأكد من الاختلاف هنا
        $exameManage->degree_n = $request->degree_n;
        $exameManage->degree_p  = $request->degree_p;
        $exameManage->exam_n  = $request->exam_n;
        $exameManage->exam_p = $request->exam_p;
        $exameManage->semester = $request->semester;
        $exameManage->save();
    
        session()->flash('success', 'تم إضافة النتيجة بنجاح');
        return redirect()->back();

    }
}