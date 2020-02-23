<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageToPost extends Model
{
    protected $table = 'image_to_posts';

    protected $fillable = ['path', 'post_id'];
}
