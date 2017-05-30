<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Image extends BaseModel
{
    //
    protected $table = 'images';
    protected $fillable = array(
        'result_id',
        'path',
        'hash'
    );
    protected $hidden = array(
        'path',
        'created_at',
        'updated_at'
    );

    protected $appends = array(
        'src'
    );

    public function getSrcAttribute()
    {
        return url("/api/images/results/$this->hash?ver" . rand(0, 10000));
    }
    /**
     *
     * relation to result
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function result()
    {
        return $this->belongsTo('App\Models\Result', 'result_id', 'id');
    }
}
