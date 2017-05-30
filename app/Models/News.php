<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\BaseModel;

class News extends BaseModel
{
    protected $table = 'news';

    protected $fillable = array(
        'title',
        'content',
        'image',
        'location'
    );

    protected $hidden = array();

    protected $casts = array(
    
    );

    protected $appends = array();

    public $perPage = 20;

    public static $rules = array(
        'RULE_CREATE' => array(
            'title' => 'required|string|min:10',
            'content' => 'required',
        ),
        'RULE_UPDATE' => array(
            'title' => 'required|string|min:10',
            'content' => 'required',
        ),
    );
}