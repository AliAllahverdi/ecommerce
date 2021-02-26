<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class PostCategory extends Model
{
    
    protected $guarded = ['id'];
    

    public function translations(){
        return $this->hasMany('App\Models\PostCategoryTranslation');
    }

    public function defaultLang(){
        $defaultSlug = config('app.locale'); // en
        $defaultLang = Language::where('slug',$defaultSlug)->first();
        $defaultLangId = $defaultLang->id;

        $lang = $this->translations()->where('language_id',$defaultLangId)->first();
        if($lang===null) $lang = $this->translations()->get()[0];

        return $lang;


        // return $this->translations()->get()[0];
    }

    public function post(){
        return $this->hasMany('App\Models\Post','post_cat_id','id')->where('status','active');
    }

    

    public static function getBlogByCategory($slug){
        return PostCategory::with('post')->where('slug',$slug)->first();
    }
}
