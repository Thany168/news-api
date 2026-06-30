<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['filename', 'original_name', 'url', 'mime_type', 'size'];
}
