<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;


class TeacherController extends Controller
{
  
    // public function home()
    // {
        
    //     return view('DashBoard.teahcer.home');

    // }

    public function filterTeacher(Request $request)
    {
        $query = $request->input('query');
    
        $teachers = User::where('role', 'teacher')
            // Eager load subjects
            ->where('name', 'LIKE', "%{$query}%")
            ->with('subjects') // Ensure this matches your relationship method
            ->get();
    
        return response()->json($teachers);
    }
    


    public function index()
    {
        // جلب المدرسين مع العلاقات المربوطة بالمواد الدراسية والاختصاصات
        $teachers = User::where('role', 'teacher')
                    ->with('subjects')
                    ->get();
                    

    // return view('DashBoard.teacher.homeTeacher', compact('teachers'));
        return view('DashBoard.teahcer.homeTeachers', compact('teachers'));
    }
    public function create()
    {
        $specializations_student = Specialization::all();
        // $subject = Subject::all();

            // جلب المواد الدراسية المرتبطة بقسم البرمجة
        $specialization = Specialization::where('name', 'قسم البرمجة')->first();
        $specialization_network = Specialization::where('name', 'قسم الشبكات')->first();
        $specialization_main = Specialization::where('name', 'قسم الصيانة')->first();

        $subject_programming = $specialization ? $specialization->subjects : collect();
        $subject_networking = $specialization_network ? $specialization_network->subjects : collect();
        $subject_main = $specialization_main ? $specialization_main->subjects : collect();

        // if($specialization){
        //     $subjects = $specialization->subject;
        //     foreach($subjects as $subject)
        //     {
        //         echo $subject->name . '<br>';
        //     }
        // }

        return view('DashBoard.teahcer.createTeacher'  ,  compact('specializations_student' , 'subject_programming' , 'subject_networking' ,'subject_main' ));
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            
            'name'=>'required',
            'semester'=>'required',
            'subject_yeare'=>'required',
            'subject_sep'=>'required',
            'subjects'=>'required|array',
            'subjects.*'=>'exists:subjects,id',


        ]);


       $teacher =  User::create([
            'name' => $request->name,
            'specializations_id'=>$request->specializations_id,
            'semester'=>$request->semester,
            'subject_yeare'=>$request->subject_yeare,
            'subject_sep'=>$request->subject_sep,
            'role' => 'teacher',
        ]);

        $teacher->subjects()->attach($request->input('subjects'));
   



        session()->flash('success', 'تم إضافة  بنجاح');
        return redirect()->back();

    }

    public function edit($id){
        $teacher = User::find($id);
        $specializations_student = Specialization::all();
        $subject_teacher = Subject::all();
    
        // جلب الأقسام
        $specialization_programming = Specialization::where('name', 'قسم البرمجة')->first();
        $specialization_networking = Specialization::where('name', 'قسم الشبكات')->first();
        $specialization_main = Specialization::where('name', 'قسم الصيانة')->first();
    
        // جلب المواد الدراسية لكل قسم
        $subject_programming = $specialization_programming ? $specialization_programming->subjects->pluck('id')->toArray() : [];
        $subject_networking = $specialization_networking ? $specialization_networking->subjects->pluck('id')->toArray() : [];
        $subject_main = $specialization_main ? $specialization_main->subjects->pluck('id')->toArray() : [];
    
        // المواد التي يدرسها المدرس
        $teacher_subjects = $teacher->subjects->pluck('id')->toArray();
    
        return view('DashBoard.teahcer.editTeacher', compact('teacher', 'subject_programming', 'subject_networking', 'subject_main', 'specializations_student', 'subject_teacher', 'teacher_subjects'));
    }
    


    public function update(Request $request, $id)
{
    // جلب المدرس من قاعدة البيانات
    $teacher = User::find($id);

    // التحقق من صحة البيانات المدخلة
    $request->validate([
        'name' => 'required|string|max:255',
        'specializations_id' => 'required|exists:specializations,name',
        'subjects_programming' => 'array',
        'subjects_networking' => 'array',
        'subjects_main' => 'array',
    ]);

    // تحديث معلومات المدرس
    $teacher->name = $request->name;
    $teacher->specializations_id = $request->specializations_id;
    $teacher->semester = $request->semester;
    $teacher->subject_sep = $request->subject_sep;
    $teacher->subject_yeare = $request->subject_yeare;

    // جمع كل المواد الدراسية المختارة
    $subjects = array_merge(
        $request->input('subjects_programming', []),
        $request->input('subjects_networking', []),
        $request->input('subjects_main', [])
    );

    // تحديث المواد الدراسية التي يدرسها المدرس
    $teacher->subjects()->sync($subjects);

    // حفظ التغييرات
    $teacher->save();

    // إعادة التوجيه مع رسالة نجاح
    return redirect()->route('dashBoard.teacher.home')->with('success', 'تم تحديث معلومات المدرس بنجاح');
}

    function destroy($id){

        try {
            //code...
     
            $teacher = User::find($id);
            $teacher->delete();

            
            session()->flash('success', 'تم الحذف  بنجاح');
            return redirect()->back();
        } 
        catch (\Throwable $th) {
            return redirect()->back();
        }

    }


}
