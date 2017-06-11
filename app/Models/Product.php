<?php

namespace App\Models;
use App\Models\BaseModel;

class Product extends BaseModel
{
    protected $table = 'products';

    protected $fillable = array(
            'collection_id',
            'categories_id',
            'name',
            'description',
            'image',
            'detail'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $appends = array(
        'img_src'
    );

    protected $perPage = 20;

    protected $casts = array(
    );

    public static $rules = array(
        'RULE_CREATE' => array(
            'collection_id' => 'required',
            'categories_id' => 'required',
            'name' => 'required',
            'detail' => 'required'
        ),

        'RULE_UPDATE' => array(
            'collection_id' => 'required',
            'categories_id' => 'required',
            'name' => 'required',
            'detail' => 'required'
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
            return url("/api/images/products/$this->id?ver=" . rand(0, 1000000));
        }

        return null;
    }

    /**
     * relation to categories
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo('App\Models\Categories', 'categories_id', 'id');
    }

    /**
     * relate to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collection()
    {
        return $this->belongsTo('App\Models\Collection', 'collection_id', 'id');
    }

}
