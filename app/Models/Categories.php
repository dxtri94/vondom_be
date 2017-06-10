<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Categories extends BaseModel
{
    protected $table = 'Categories';
    protected $fillable = array(
        'name'
    );
    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    public static $rules = array(
        'RULE_CREATE' => array(
            'name' => 'required' 
        ),

        'RULE_UPDATE' => array(
            'name' => 'required'
        )
    );
}
