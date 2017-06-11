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

    protected $appends = array(
            'img_src'
        );

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

    /**
     * get avatar src attribute
     * @return string
     */
    public function getImgSrcAttribute()
    {
        if (strpos($this->image, 'http') !== false) {
            return $this->image;
        } else if ($this->image) {
            return url("/api/images/news/$this->id?ver=" . rand(0, 1000000));
        }

        return null;
    }
}