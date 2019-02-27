<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchedulesWorked extends Model
{
    use SoftDeletes;

      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules_worked';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'customer_id', 'start_time', 'end_time', 'work_schedule_id'
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
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
        'work_schedule_id' => 'nullable|exists:work_schedule,id',
    ];

    /**
     * Get the WorkSchedules for the Schedule.
     */
    public function schedule()
    {
        return $this->belongsTo('App\WorkSchedule', 'work_schedule_id');
    }


}
