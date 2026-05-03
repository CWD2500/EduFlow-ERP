<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialization;
use App\Models\StudentYearTwo;
class StudentController extends Controller
{


    public function homeStudent()
    {
        return view('DashBoard.student.student.home');

    }


    public function filterOneProg(Request $request)
    {
        $query = $request->input('query');

        $students = User::where('role', 'student')
            ->where('year_one_student', 'السنة الاولى')
            ->where('specializations_id', 'قسم البرمجة')
            ->where('is_hidden', false)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('student_id', 'LIKE', "%{$query}%");
            })
            ->get();
        return response()->json($students);
    }


    public function filterTwoProg(Request $request){
        $query  = $request->input('query');
        $students  = StudentYearTwo::
        where('year_one_student', 'السنة الثانية')
        ->where('specializations_id' , 'قسم البرمجة')
        ->where(function ($q) use ($query){
            $q->where('student_name'  , 'LIKE' , "%{$query}%")
            ->orWhere('student_id', 'LIKE', "%{$query}%");;
        })->get();

        return response()->json($students);
    }


    public function filterOneNet(Request $request)
    {
        $query = $request->input('query');
        
        $students = User::where('role', 'student')
        ->where('year_one_student', 'السنة الاولى')
        ->where('specializations_id', 'قسم البرمجة')
        ->where('is_hidden', false)
        ->where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('student_id', 'LIKE', "%{$query}%");
        })
        ->get();
        return response()->json($students);    
    }


    public function filterTwoNet(Request $request)
    {
        $query = $request->input('query');
        $query  = $request->input('query');
        $students  = StudentYearTwo::
        where('year_one_student', 'السنة الثانية')
        ->where('specializations_id' , 'قسم الشبكات')
        ->where(function ($q) use ($query){
            $q->where('student_name'  , 'LIKE' , "%{$query}%")
            ->orWhere('student_id', 'LIKE', "%{$query}%");;
        })->get();

        return response()->json($students);
    }



    
    public function filterOneMain(Request $request)
    {
        $query = $request->input('query');
        
        $students = User::where('role', 'student')
        ->where('year_one_student', 'السنة الاولى')
        ->where('specializations_id', 'قسم الصيانة')
        ->where('is_hidden', false)
        ->where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('student_id', 'LIKE', "%{$query}%");
        })
        ->get();
        return response()->json($students);    
    }


    public function filterTwoMain(Request $request)
    {
        $query = $request->input('query');
        $query  = $request->input('query');
        $students  = StudentYearTwo::
        where('year_one_student', 'السنة الثانية')
        ->where('specializations_id' , 'قسم الشبكات')
        ->where(function ($q) use ($query){
            $q->where('student_name'  , 'LIKE' , "%{$query}%")
            ->orWhere('student_id', 'LIKE', "%{$query}%");;
        })->get();

        return response()->json($students);
    }
    public function indexStudentOne()
    {
        
        $student = User::where('role' , 'student')->where('year_one_student' , 'السنة الاولى')
        ->where('specializations_id' , 'قسم البرمجة')
        ->where('is_hidden' , false)->get();

        if (empty($student)) {
            return view('DashBoard.student.student.student_year_one',compact('student'));
        }else
        {

            return view('DashBoard.student.student.student_year_one' , compact('student'));
        }

    }
    public function indexStudentTwo()
    {
        
     // جلب الطلاب في السنة الثانية في قسم البرمجة مع معلومات المستخدمين المرتبطة
            $student= StudentYearTwo::where('year_one_student', 'السنة الثانية')
            ->where('specializations_id', 'قسم البرمجة')
            ->with('users')
            ->get();

        // التحقق من وجود البيانات
        if ($student->isEmpty()) {
            return view('DashBoard.student.student.student_year_two',compact('student'))->with('message', 'لا توجد بيانات للطلاب في السنة الثانية في قسم البرمجة.');
        } else {
            return view('DashBoard.student.student.student_year_two', compact('student'));
        }

    }


    public function indexStudentNetworkOne()
    {
        $student = User::where('role' , 'student')->where('year_one_student' , 'السنة الاولى')
        ->where('specializations_id' , 'قسم الشبكات')
        ->where('is_hidden' , false)->get();

        if (empty($student)) {
            return view('DashBoard.student.student.student_net_year_one',compact('student'));
        }else
        {

            return view('DashBoard.student.student.student_net_year_one' , compact('student'));
        }
    }

    public function indexStudentNetworkTwo()
    {
        
     // جلب الطلاب في السنة الثانية في قسم البرمجة مع معلومات المستخدمين المرتبطة
            $student= StudentYearTwo::where('year_one_student', 'السنة الثانية')
            ->where('specializations_id', 'قسم الشبكات')
            ->with('users')
            ->get();

        // التحقق من وجود البيانات
        if ($student->isEmpty()) {
            return view('DashBoard.student.student.student_net_year_two',compact('student'))->with('message', 'لا توجد بيانات للطلاب في السنة الثانية في قسم البرمجة.');
        } else {
            return view('DashBoard.student.student.student_net_year_two', compact('student'));
        }

    }


    public function indexStudentMainOne()
    {
        $student = User::where('role' , 'student')->where('year_one_student' , 'السنة الاولى')
        ->where('specializations_id' , 'قسم الصيانة')
        ->where('is_hidden' , false)->get();

        if (empty($student)) {
            return view('DashBoard.student.student.student_main_year_one',compact('student'));
        }else
        {

            return view('DashBoard.student.student.student_main_year_one' , compact('student'));
        }
    }

    public function indexStudentMainTwo()
    {
        
     // جلب الطلاب في السنة الثانية في قسم البرمجة مع معلومات المستخدمين المرتبطة
            $student= StudentYearTwo::where('year_one_student', 'السنة الثانية')
            ->where('specializations_id', 'قسم الصيانة')
            ->with('users')
            ->get();

        // التحقق من وجود البيانات
        if ($student->isEmpty()) {
            return view('DashBoard.student.student.student_main_year_two' ,compact('student') )->with('message', 'لا توجد بيانات للطلاب في السنة الثانية في قسم البرمجة.');
        } else {
            return view('DashBoard.student.student.student_main_year_two', compact('student'));
        }

    }

    public function create()
    {
        $specializations_student = Specialization::pluck('name')->toArray();
        return view('DashBoard.student.createStudent', compact('specializations_student'));
    }
    



    // 
    public function generateStudentId()
    {
        $lastStudentId = User::where('role' , 'student')->orderBy('student_id' ,'desc')->first();

        if (!$lastStudentId) {
            // إذا لم يكن هناك طلاب في قاعدة البيانات، يتم البدء من 1
            return 1;
          
        }
        return $lastStudentId->student_id + 1;    
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            // 'student_id' => 'required',
            'ratio' => 'required|string|max:50',
            'father' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'mother' => 'required|string|max:255',
            'place_and_number_of_registration' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'place_Get_the_certificate' => 'required|string|max:255',
            'total' => 'required|numeric',
            'religion' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'language' => 'required|string|max:255',
            'exam_session' => 'required|string|max:50',
            'teacher' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'recruitment_division' => 'required|string|max:255',
            'national_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'mobile_phone_number' => 'required|string|max:20',
            'landline_number' => 'required|string|max:20',
            'detailed_address' => 'required|string|max:255',
            'date_of_registration' => 'required|date',
        ]);

     
        $student_id = $this->generateStudentId();


      try{

    

    
        $student= new User();
        $student->name  =  $request->name;
        $student->specializations_id = $request->specializations_id;
        $student->role  =  'student';
        $student->student_id  = $student_id;
        $student->ratio  =  $request->ratio;
        $student->father  =  $request->father;
        $student->father_job  =  $request->father_job;
        $student->mother  =  $request->mother;
        $student->place_and_number_of_registration  =  $request->place_and_number_of_registration;
        $student->place_of_birth  =  $request->place_of_birth;
        $student->place_Get_the_certificate  =  $request->place_Get_the_certificate;
        $student->total  =  $request->total;
        $student->religion  =  $request->religion;
        $student->city  =  $request->city;
        $student->gender  =  $request->gender;
        $student->language  =  $request->language;
        $student->exam_session  =  $request->exam_session;
        $student->teacher  =  $request->teacher;
        $student->family  =  $request->family;
        $student->recruitment_division  =  $request->recruitment_division;
        $student->national_number  =  $request->national_number;
        $student->date_of_birth  =  $request->date_of_birth;
        $student->mobile_phone_number  =  $request->mobile_phone_number;
        $student->landline_number  =  $request->landline_number;
        $student->detailed_address  =  $request->detailed_address;
        $student->date_of_registration  =  $request->date_of_registration;
        $student->year_one_student  = 'السنة الاولى';
        $student->save();
    
    
        session()->flash('success', 'تم إضافة الطالب بنجاح');
        return redirect()->back();
       
    }
        catch (\Throwable $th) {
            session()->flash('success', 'يوجد خطاء في العملية الادخل  ');
            return redirect()->back();
        }
        
    }
   

    public function show($id)
    {
       
        $student_id = User::find($id);

        return view('DashBoard.student.showStudent' , compact('student_id'));
    }
    public function showStudentTwo($id)
    {
       
        $student_id = StudentYearTwo::find($id);
        $student =  $student_id->users;

        return view('DashBoard.student.showStudent2' , compact('student_id' , 'student'));
    }


    public function edit($id){
        $student = User::find($id);
        $specializations_student = Specialization::pluck('name')->toArray();
        return view('DashBoard.student.editStudent' , compact('student' , 'specializations_student'));

    }
    public function editStudentYearTwo($id){
        // $student = User::find($id);
        $student  =  StudentYearTwo::find($id)->first();
        // $specializations_student = Specialization::pluck('name')->toArray();
        $specializations_student = Specialization::pluck('name')->toArray();
        return view('DashBoard.student.editStudentStudentYearTwo'  , compact('student' , 'specializations_student'));

    }

    public function updateStudentTwo(Request $request  , $id){
        $StudentTwo =  StudentYearTwo::find($id);
        $student_one = $StudentTwo->users;

     
        $this->validate($request, [
            'student_name' => 'required|string|max:255',
            // 'student_id' => 'required',
            'ratio' => 'required|string|max:50',
            'father' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'mother' => 'required|string|max:255',
            'place_and_number_of_registration' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'place_Get_the_certificate' => 'required|string|max:255',
            'total' => 'required|numeric',
            'religion' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'language' => 'required|string|max:255',
            'exam_session' => 'required|string|max:50',
            'teacher' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'recruitment_division' => 'required|string|max:255',
            'national_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'mobile_phone_number' => 'required|string|max:20',
            'landline_number' => 'required|string|max:20',
            'detailed_address' => 'required|string|max:255',
            'date_of_registration' => 'required|date',
        ]);



        $StudentTwo->student_name =  $request->student_name;
       
        // role =  'student',
        // $StudentTwo->users->StudentTwo->users = $StudentTwo->users;
        $student_one->ratio =  $request->ratio;
        $student_one->father =  $request->father;
        $student_one->father_job =  $request->father_job;
        $student_one->mother =  $request->mother;
        $student_one->place_and_number_of_registration =  $request->place_and_number_of_registration;
        $student_one->place_of_birth =  $request->place_of_birth;
        $student_one->place_Get_the_certificate =  $request->place_Get_the_certificate;
        $student_one->total =  $request->total;
        $student_one->religion =  $request->religion;
        $student_one->city =  $request->city;
        $student_one->gender =  $request->gender;
        $student_one->language =  $request->language;
        $student_one->exam_session =  $request->exam_session;
        $student_one->teacher =  $request->teacher;
        $student_one->family =  $request->family;
        $student_one->recruitment_division =  $request->recruitment_division;
        $student_one->national_number =  $request->national_number;
        $student_one->date_of_birth =  $request->date_of_birth;
        $student_one->mobile_phone_number =  $request->mobile_phone_number;
        $student_one->landline_number =  $request->landline_number;
        $student_one->detailed_address =  $request->detailed_address;
        $student_one->date_of_registration =  $request->date_of_registration;
        $student_one->year_one_student = 'السنة الثانية';
    
        $student_one->save();
        $StudentTwo->save();
        // dd($request->all());
       
        session()->flash('success', 'تم التعديل  بنجاح');
        return redirect()->back();


    }


    public function update(Request $request  , $id)
    {
        $student_id = User::find($id);

        $this->validate($request, [
            'name' => 'required|string|max:255',
            // 'student_id' => 'required',
            'ratio' => 'required|string|max:50',
            'father' => 'required|string|max:255',
            'father_job' => 'required|string|max:255',
            'mother' => 'required|string|max:255',
            'place_and_number_of_registration' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'place_Get_the_certificate' => 'required|string|max:255',
            'total' => 'required|numeric',
            'religion' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'language' => 'required|string|max:255',
            'exam_session' => 'required|string|max:50',
            'teacher' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'recruitment_division' => 'required|string|max:255',
            'national_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'mobile_phone_number' => 'required|string|max:20',
            'landline_number' => 'required|string|max:20',
            'detailed_address' => 'required|string|max:255',
            'date_of_registration' => 'required|date',
        ]);

     
       
    
        
            $student_id->name =  $request->name;
            $student_id->specializations_id = $request->specializations_id;
            // role =  'student',
            // $student_id->student_id = $student_id;
            $student_id->ratio =  $request->ratio;
            $student_id->father =  $request->father;
            $student_id->father_job =  $request->father_job;
            $student_id->mother =  $request->mother;
            $student_id->place_and_number_of_registration =  $request->place_and_number_of_registration;
            $student_id->place_of_birth =  $request->place_of_birth;
            $student_id->place_Get_the_certificate =  $request->place_Get_the_certificate;
            $student_id->total =  $request->total;
            $student_id->religion =  $request->religion;
            $student_id->city =  $request->city;
            $student_id->gender =  $request->gender;
            $student_id->language =  $request->language;
            $student_id->exam_session =  $request->exam_session;
            $student_id->teacher =  $request->teacher;
            $student_id->family =  $request->family;
            $student_id->recruitment_division =  $request->recruitment_division;
            $student_id->national_number =  $request->national_number;
            $student_id->date_of_birth =  $request->date_of_birth;
            $student_id->mobile_phone_number =  $request->mobile_phone_number;
            $student_id->landline_number =  $request->landline_number;
            $student_id->detailed_address =  $request->detailed_address;
            $student_id->date_of_registration =  $request->date_of_registration;
            $student_id->year_one_student = 'السنة الاولى';
        
            $student_id->save();
    
        session()->flash('success', 'تم التعديل  بنجاح');
        return redirect()->back();
    }

    public function deleteTrash($id)
    {

        try
        {
            $student_id = User::find($id);
            $notifications =  $student_id->notifications();
            $objection =  $student_id->objection();
            $subjects =  $student_id->subjects();
            $exames =  $student_id->exames();
            $student_two =  $student_id->StudentYearTwo();
            $notifications->delete();
            $objection->delete();
            $subjects->delete();
            $subjects->delete();
            $exames->delete();
            $student_two->delete();
            $student_id->delete();

            session()->flash('success', 'تم الحذف  بنجاح');
            return redirect()->back();
        }
            catch (\Throwable $th) {
                return redirect()->back();
        }
}
   
public function deleteStudentTwo(Request $request ,   $id)
    {
        try{
        $student_two = StudentYearTwo::find($id);
        $student_two->delete();
        $objection =  $student_two->objection();
        $exames =  $student_two->exames();
        $subjects =  $student_two->subjects();
        $exames->delete();
        $objection->delete();
        $subjects->delete();

        // dd($request->all());
        session()->flash('success', 'تم الحذف  بنجاح');
        return redirect()->back();
        }
        catch (\Throwable $th) {
            return redirect()->back();
    }
    }

    
    
}
