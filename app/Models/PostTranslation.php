<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    protected $guarder = ['id'];
    protected $fillable=['title', 'slug', 'post_id', 'language_id'];

}
