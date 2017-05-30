<?php

namespace App\Models;
use App\Models\BaseModel;

class UserContact extends BaseModel
{
    protected $table = 'products';

    protected $fillable = array(
            'name',
            'phone',
            'address',
            'mail',
            'title',
            'content'
    );

    protected $hidden = array(
        'created_at',
        'updated_at'
    );

    protected $perPage = 20;

    protected $casts = array(
    );

    public static $rules = array(
        'RULE_CREATE' => array(
            'game_id' => 'required',
            'opponent_id' => 'required',
            'amount' => 'required|min:1|max:500|numeric|regex:/^[0-9]+(\.[0-9]{1,2})?$/',
            'confirm_amount' => 'required|same:amount',
            'description' => 'required',
        ),

        'RULE_UPDATE' => array(
            'amount' => 'required|min:1|max:500|numeric|regex:/^[0-9]+(\.[0-9]{1,2})?$/'
        )
    );

}
