<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostCategory;
use App\Models\Language;
use App\Models\PostCategoryTranslation;
use Illuminate\Support\Str;
class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postCategory=PostCategory::orderBy('id','DESC')->paginate(10);
        return view('backend.postcategory.index')->with('postCategories',$postCategory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.postcategory.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $defaultSlug = config('app.locale');
        $rules = [
            'title_'.$defaultSlug => 'required',
            'status'=>'required|in:active,inactive'
        ];
        
        // dd($rules);
        $request->validate($rules);


        $data=$request->all();
        
        $status=PostCategory::create($data);

        foreach(Language::all() as $lang){
            
            $fieldName = 'title_'.$lang->slug;
            $field = $request->{$fieldName};
            $slug=Str::slug($field);
           
            if(!empty($field)) {
                PostCategoryTranslation::create([
                    'post_category_id' => $status->id,
                    'language_id' => $lang->id,
                    'title' => $field,
                    'slug' => $slug,
                ]);
            }
        }

        if($status){
            request()->session()->flash('success','Post Category Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post-category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postCategory=PostCategory::findOrFail($id);
        return view('backend.postcategory.edit')->with('postCategory',$postCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // dd($request->all());
        $defaultSlug = config('app.locale');
        $rules = [
            'title_'.$defaultSlug => 'required',
            'status'=>'required|in:active,inactive'
        ];
        
        $request->validate($rules);
        $postCategory=PostCategory::findOrFail($id);
        // dd($postCategory);
        $status=$postCategory->save();
       $test = PostCategoryTranslation::where('post_category_id', $request->post_category_id);
        // dd($test);

        $find = PostCategoryTranslation::where('language_id', $request->language_id)->first();
        // dd($find);

        foreach(Language::all() as $lang){
            
            // dd($lang);
            $fieldName = 'title_'.$lang->slug;
            $field = $request->{$fieldName};
            $slug=Str::slug($field);
            // dd($slug);
            // dd($fieldName, $field, $slug);
            
            $find = PostCategoryTranslation::where('language_id', $lang->id);
            dd($find);
            

            $find = PostCategoryTranslation::where('language_id', $lang->id)->first()->update([
                    'title' => $field,
                    'slug' => $slug
                ]);
                
                dd($find);
            
            // 
        }
        
        
        // dd($status);

        if($status){
            request()->session()->flash('success','Post Category Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $postCategory=PostCategory::findOrFail($id);
       
        $status=$postCategory->delete();
        
        if($status){
            request()->session()->flash('success','Post Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting post category');
        }
        return redirect()->route('post-category.index');
    }
}
