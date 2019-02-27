<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes;

    const CUSTOMER_TYPE_PERSON = 1;
    const CUSTOMER_TYPE_COMPANY = 2;

    const CONTRACT_TYPE_CTPS = 1;
    const CONTRACT_TYPE_CNPJ = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_type', 'customer_document', 'name', 'email', 'phone', 'user_id', 'contract_type'
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
        'customer_type' => 'required|in:' . Customers::CUSTOMER_TYPE_PERSON .',' . Customers::CUSTOMER_TYPE_COMPANY . '',
        'customer_document' => 'nullable|max:191', 
        'name' => 'required|max:191', 
        'email' => 'nullable|max:191', 
        'phone' => 'nullable|max:191', 
        'user_id' => 'required|exists:users,id',
        'contract_type' => 'in:' . Customers::CONTRACT_TYPE_CTPS .',' . Customers::CONTRACT_TYPE_CNPJ . '',
    ];

     /**
     * Get the SchedulesWorked for the Customer.
     */
    public function schedules()
    {
        return $this->hasMany('App\SchedulesWorked', 'customer_id');
    }

    /**
     * Get the WorkSchedules for the Customer.
     */
    public function workschedules()
    {
        return $this->hasMany('App\WorkSchedule', 'customer_id');
    }

}
