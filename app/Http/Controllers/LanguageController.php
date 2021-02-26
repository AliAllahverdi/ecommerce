<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Support\Str;

class LanguageController extends Controller
{


    public function index()
    {
        $languages = Language::all();
        return view('backend.language.index', compact('languages'));
    }

    public function create()
    {
        return view('backend.language.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
        ]);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Language::where('slug',$slug)->count();
        if($count>0){
            request()->session()->flash('error','Category with this name available!!');
            return redirect()->route('languages.index');
           
        }
        $data['slug']=$slug;
        
        $status=Language::create($data);
        if($status){
            request()->session()->flash('success','Post Category Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('languages.index');

      
        // Language::create($request->only('title','slug'));
        
        // toastr()->success('Kateqoriya Uğurla Yaradıldı');

        // return redirect()->back();

        // 
    }


    public function update(Request $request)
    {
        $lang = Language::find($request->id);

        $lang->update([
            'title' => $request->title,
            'slug' => $request->slug
        ]);
        toastr()->success('Dil adı Uğurula Güncəlləndi');
        return redirect()->back();

    }

    public function delete(Request $request){
        $lang=Language::findOrFail($request->id);
        
        $message='';
        
        $lang->delete();
        toastr()->success($message,'Dil Uğurla Silindi');
        return redirect()->back();
    }


    
}
