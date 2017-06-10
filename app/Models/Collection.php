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
        'src'
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
     * get src
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
     */
    public function getSrcAttribute()
    {
        if (!empty($this->path)) {
            if (strpos($this->path, 'http') !== false) {
                return $this->path;
            } else if (File::exists(base_path($this->path))) {
                return url("/api/images/game/$this->id?ver=" . rand(0, 1000000));
            }
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
