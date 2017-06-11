<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    //
    protected $table = 'catalogs';
    protected $fillable = array(
        'name',
        'main_img', 
        'sub_img', 
        'link', 
        'description'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $appends = array(
        'img_main_src',
        'img_sub_src'
    );

    protected $perPage = 50;

    public static $rules = array(
        'RULE_CREATE' => array(
            'name' => 'required',
            'link' => 'required|url',
            'description' => 'required'
        ),

        'RULE_UPDATE' => array(
            'name' => 'required',
            'link' => 'required|url',
            'description' => 'required'
        )
    );

    public function setLabelsAttribute($value)
    {
        $this->attributes['labels'] = json_encode($value);
    }

    public function getLabelsAttribute()
    {
        return json_decode($this->attributes['labels'], false);
    }

    /**
     * get avatar src attribute
     * @return string
     */
    public function getImgMainSrcAttribute()
    {
        if (strpos($this->main_img, 'http') !== false) {
            return $this->main_img;
        } else if ($this->main_img) {
            return url("/api/images/catalogs/$this->id/main?ver=" . rand(0, 1000000));
        }

        return null;
    }

    /**
     * get avatar src attribute
     * @return string
     */
    public function getImgSubSrcAttribute()
    {
        if (strpos($this->sub_img, 'http') !== false) {
            return $this->sub_img;
        } else if ($this->sub_img) {
            return url("/api/images/catalogs/$this->id/sub?ver=" . rand(0, 1000000));
        }

        return null;
    }

}
