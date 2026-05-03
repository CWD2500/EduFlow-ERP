<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    

    public function index()
    {
        $specialization  = Specialization::all();
        return view('DashBoard.specialization.home' ,compact('specialization'));
    }
    public function create()
    {
        return view('DashBoard.specialization.create');
    }
    public function store(Request $request)
    {
        $this->validate($request , [
            'name'=>'required'
        ]);

        $specialization = new Specialization();
        $specialization->name = $request->name;
        $specialization->save();

        session()->flash('success', 'تم إضافة  بنجاح');
        return redirect()->back();
        
    }
    public function edit($id)
    {
        $specialization  = Specialization::find($id);
        return view('DashBoard.specialization.edit' , compact('specialization'));



    }
    public function update(Request $request , $id)
    {
     
        $specialization  = Specialization::find($id);
        $this->validate($request , [
            'name'=>'required'
        ]);

        $specialization->update([
            'name'=>$request->input('name'),
        ]);

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }
    public function destroy($id)
    {

        try{
                $specialization  = Specialization::find($id);
                $specialization->delete();
                session()->flash('success', 'تم  الحذف بنجاح');
                return redirect()->back();
        }
            catch(\Throwable $th)
        {   
            return redirect()->back();
        }
    }

}
