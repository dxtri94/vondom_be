<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

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

    protected $appends = array(
        'img_src',
        'img_thumbnail',
        'type_image'
    );

    public static $rules = array(
        'RULE_CREATE' => array(
            'name' => 'required' 
        ),

        'RULE_UPDATE' => array(
            'name' => 'required'
        )
    );

    /**
     * get avatar src attribute
     * @return string
     */
    public function getImgSrcAttribute()
    {
        if (strpos($this->img_path, 'http') !== false) {
            return $this->img_path;
        } else if ($this->img_path) {
            return url("/api/images/categories/$this->id?ver=" . rand(0, 1000000));
        }

        return null;
    }

    /**
     * fn get thumbnail attribute
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
     */
    public function getImgThumbnailAttribute()
    {
        if (strpos($this->img_path, 'http') !== false) {
            return $this->img_path;
        } else if ($this->img_path) {
            return url("/api/images/categories/$this->id/thumbnail?ver=" . rand(0, 1000000));
        }
    }

    /**
     * get type image attribute
     * @return bool|string
     */
    public function getTypeImageAttribute()
    {
        return $this->img_path ? $this->checkSizeImage($this->img_path) : null;
    }

    /**
     *
     * has many user
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'categories_id', 'id');
    }
}
