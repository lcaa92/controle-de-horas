<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkSchedule extends Model
{

    use SoftDeletes;

    const TYPE_HOURS = 1;
    const TYPE_PRICE = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_schedule';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'description', 'hours_per_day', 'price_per_day', 'user_id', 'customer_id'
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
        'type' => 'required|in:' . WorkSchedule::TYPE_HOURS .',' . WorkSchedule::TYPE_PRICE . '',     
        'user_id' => 'required|exists:users,id',
        'customer_id' => 'required|exists:customers,id',
        'hours_per_day' => 'nullable|date_format:H:i|required_if:type,1',
        'price_per_day' => 'nullable|regex:/^\d+(\.\d{1,2})?$/|required_if:type,2',
        'description' => 'nullable|string'
    ];
}
