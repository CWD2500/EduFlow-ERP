<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Specialization;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function filterSubject(Request $request){
        $query = $request->input('query');
        $subjects = Subject::where('name', 'LIKE', "%{$query}%")
                            ->with('specializations') // Eager load specializations
                            ->get();
    
        return response()->json($subjects);
    }
    public function index()
    {
         // جلب جميع المواد الدراسية مع الاختصاصات المرتبطة بها
        // $subject  = Subject::all();
        $subjects = Subject::with('specializations')->get();

        return  view('DashBoard.subject.homeSubject'  , compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialization = Specialization::all();
        return view('DashBoard.subject.createSubject' , compact('specialization'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صحة المدخلات
        $this->validate($request, [
            'name' => 'required|max:255',
            'specializations' => 'required|array',
            'specializations.*' => 'exists:specializations,id',
            'semester' => 'required',
            'subject_sep' => 'required|array',  // مصفوفة نظراً لأن المستخدم يمكنه اختيار عدة خيارات
            'subject_sep.*' => 'string',
            'year' => 'required',
        ]);
    
        // تحويل مصفوفة subject_sep إلى نص حيث يتم فصل كل عنصر بسطر جديد
        $subject_sep_string = implode("\n", $request->input('subject_sep'));
        
        $subject = Subject::create([
            'name' => $request->input('name'),
            'semester' => $request->input('semester'),
            'subject_sep' => $subject_sep_string, // حفظ النص حيث العناصر مفصولة بسطر جديد
            'year' => $request->input('year'),
        ]);
    
        // ربط المواد بالاختصاص
        $subject->specializations()->attach($request->input('specializations'));
    
        // إرجاع رسالة نجاح
        session()->flash('success', 'تم إضافة المادة الدراسية بنجاح');
        return redirect()->back();
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        $specializations = Specialization::all();
        $selectedSpecializations = $subject->specializations->pluck('id')->toArray();
        return view('DashBoard.subject.editSubject'  ,compact('subject','specializations','selectedSpecializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'semester' => 'required',
            'subject_sep' => 'required|array',
            'subject_sep.*' => 'string',
            'specializations' => 'required|array',
            'specializations.*' => 'exists:specializations,id',
            'year.*' => 'year',
          
        ]);


// Break Line 
        $subject_sep =  implode("\n" , $request->input('subject_sep'));
        
 

        // تحديث بيانات الموضوع
        $subject->update([
            'name' => $request->input('name'),
            'semester' => $request->input('semester'),
            'subject_sep' => $subject_sep,
            'year' => $request->input('year'),
        ]);

        // تحديث الربط بين الموضوع والاختصاصات
        $subject->specializations()->sync($request->input('specializations'));

        session()->flash('success', 'تم التعديل بنجاح');
          return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
           
            $subject= Subject::find($id);
            $exam  =   $subject->exames();
            // حذف الارتباطات مع الاختصاصات
            // $subject->specializations()->detach();
          
            // حذف المادة الدراسية
            // $exam->delete();
            $subject->delete();
            session()->flash('success', 'تم حذف المادة الدراسية بنجاح');
            return redirect()->back();
        } 

        catch (\Throwable $th) {
            return redirect()->back();
         }



    }
}
