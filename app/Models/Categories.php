<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Categories extends Model
{
    protected $table = 'Categories';
    protected $fillable = array(
        'name'
    );
    protected $hidden = array(
        'created_at',
        'updated_at'
    );
}
