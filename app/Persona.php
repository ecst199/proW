<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Persona extends Model 
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'mail', 'contra', 'token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'contra', 'token'
    ];
}
