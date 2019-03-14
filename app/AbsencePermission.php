<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsencePermission extends Model
{
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'absence_permission';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'hours_absence', 'description', 'user_id', 'customer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    /**
     * The array with rules validation
     *
     * @var array
     */
    public $rules = [   
        'user_id' => 'required|exists:users,id',
        'customer_id' => 'required|exists:customers,id',
        'date' => 'nullable|date_format:Y-m-d|required',
        'hours_absence' => 'nullable|date_format:H:i|required',
        'description' => 'nullable|string'
    ];
}
