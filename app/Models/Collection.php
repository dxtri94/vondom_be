<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{

    protected $table = 'collections';

    protected $fillable = array(
        'categories_id',
        'name',
        'image',
        'description'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $appends = array(
        'img_src'
    );

    public static $rules = array(
        'RULE_CREATE' => array(
            'categories_id' => 'required',
            'name' => 'required' 
        ),

        'RULE_UPDATE' => array(
            'categories_id' => 'required',
            'name' => 'required' 
        )
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
            return url("/api/images/collections/$this->id?ver=" . rand(0, 1000000));
        }

        return null;
    }

    /**
     *
     * relation to users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo('App\Models\Categories', 'categories_id', 'id');
    }
}
