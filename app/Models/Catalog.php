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

    protected $perPage = 50;

    public function setLabelsAttribute($value)
    {
        $this->attributes['labels'] = json_encode($value);
    }

    public function getLabelsAttribute()
    {
        return json_decode($this->attributes['labels'], false);
    }

}
