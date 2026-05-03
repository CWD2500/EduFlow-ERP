<?php

namespace App\Http\Controllers;

use App\Models\ExameManages;
use App\Models\Objection;
use App\Models\notification;
use Illuminate\Http\Request;

class ObjectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $objections = Objection::all();
        $objections = Objection::with(['student', 'exam', 'subject'])->where('is_hidden' , false)->get();

        return view('DashBoard.exameManage.objection.home' , compact('objections'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'student_id' => 'required',
            'exam_id' => 'required',
            'subject_id' => 'required',
            'message' => 'required',
        ]);
    
        // التحقق من وجود المادة
        $examExists = ExameManages::where('id', $request->exam_id)->exists();
        if (!$examExists) {
            return response()->json(['error' => true, 'message' => 'المادة المرتبطة بهذا الاعتراض لم تعد موجودة.']);
        }
    
        $objection = Objection::where("student_id", $request->student_id)
            ->where('subject_id', $request->subject_id)->exists();
    
        if ($objection) {
            return response()->json(['previousObjection' => true, 'message' => 'لقد قمت بالاعتراض بالفعل']);
        }
    
        Objection::create([
            'student_id' => $request->student_id,
            'exam_id' => $request->exam_id,
            'subject_id' => $request->subject_id,
            'message' => $request->message,
        ]);
    
        Notification::create([
            'user_id' => $request->student_id,
            'message' => 'يوجد اعتراض جديد من الطالب رقم ' . $request->student_id,
        ]);
    
        return response()->json(['success' => true, 'message' => 'تم إرسال الاعتراض بنجاح']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $objection = Objection::with(['student', 'exam', 'subject'])->find($id);
        return view('DashBoard.exameManage.objection.objectionMark', compact('objection'));

    }


    public function notificationsShow()
{
    $notifications = Notification::all();
    return view('layouts.admin.navbar', compact('notifications'));
}
    
    public function notificaitonObjection($id)
    {
        $notifi = notification::find($id);
        $object = Objection::find($id);

        if ($object) {
            $object->is_hidden = true;
            $object->save();
        }

        if ($notifi) {
            $notifi->delete();
        }

        // $object->delete();
        session()->flash('sucess' , 'تم ح1ف الاعتراض بنجاح');
        return redirect()->back();

        
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Objection $objection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Objection $objection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
                $objection = Objection::find($id);
                $notifi = notification::find($id);
                if ($notifi) {
                    $notifi->delete();
                }
        
        
            $objection->delete();
            return redirect()->back();
            
         }
        catch(\Throwable $th)
        {
            return redirect()->back();
        }
    }
}
