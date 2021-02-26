<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategoryTranslation extends Model
{
    protected $guarder = ['id'];
    protected $fillable=['title', 'slug', 'post_category_id', 'language_id'];
    

   
}
