<?php

namespace App\Http\Controllers\CommonAccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\SchedulesWorked;
use App\WorkSchedule;
use App\AbsencePermission;
use DB;

class CustomersController extends Controller
{
    public function listCustomers(Request $request){
        $customers = Customers::where('user_id', '=', Auth::user()->id)->get();
        return view('common_access.customers.list', [ 'customers' => $customers ]);
    }

    public function formCustomers(Request $request, $customer_id = null){
        try{
            $customer = null;

            if ($customer_id){
                $customer = Customers::findOrFail($customer_id);
            }else{
                $customer = new Customers();
            }

            return view('common_access.customers.form', [ 'customer' => $customer ]);

        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar o cliente. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para clientes ' . $e->getMessage();
        }
        
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }

    public function saveCustomers(Request $request){
        $alert = null;
        $msg = null;
        try{
            $user = Auth::user();
            
            $request->request->add([
                'user_id' => $user->id
                ]);
    
            if($request->id){
                $customer = Customers::findOrFail($request->id);
                $msg = 'Cliente atualizado com sucesso';
            }else{
                $customer = new Customers();
                $msg = 'Cliente cadastrado realizado com sucesso';
            }
                
            $this->validate($request, $customer->rules);

            $customer->customer_type = $request->customer_type;
            $customer->customer_document = $request->customer_document;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->user_id = $request->user_id;
            $customer->contract_type = $request->contract_type;
            $customer->save();
            
            $alert = 'success';
            return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
        }catch(ValidationException $e){
            return redirect()->back()->withErrors($e->errors())->withInput();
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar o cliente. ' . $e->getMessage();;
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar o cliente. ' . $e->getMessage();;
        }
        return redirect()->back()->with('msg', $msg)->with('alert', $alert);
    }

    public function profileCustomer(Request $request, $customer_id = null){
        try{
            $customer = Customers::findOrFail($customer_id);
            return view('common_access.customers.profile', [ 'customer' => $customer ]);
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar o cliente. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para clientes ' . $e->getMessage();
        }
        
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }

    public function formScheduleWorked(Request $request, $customer_id = null, $schedule_id = null){
        $alert = null;
        $msg = null;
        $customer = null;
        $schedule = null;
        try{
            $customer = Customers::findOrFail($customer_id);

            if ($schedule_id){
                $schedule = SchedulesWorked::findOrFail($schedule_id);
            }else{
                $schedule = new SchedulesWorked();
            }

            return view('common_access.customers.form_schedule_work', [ 'customer' => $customer, 'schedule' => $schedule ]);
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar entidade para cadastrar horário. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para clientes ' . $e->getMessage();
        }
        
        if ($customer){
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }

    public function saveScheduleWorked(Request $request, $customer_id = null){
        $alert = null;
        $msg = null;
        $customer = null;
        $schedule = null;
        try{
            $customer = Customers::findOrFail($customer_id);
            $user = Auth::user();
            if ($request->id){
                $schedule = SchedulesWorked::findOrFail($request->id);
                $msg = 'Horário atualizado com sucesso';
            }else{
                $schedule = new SchedulesWorked();
                $msg = 'Cadastrado atualizado com sucesso';
            }

            $request->request->add([
                'user_id' => $user->id
                ]);

            $this->validate($request, $schedule->rules);

            $schedule->start_time = $request->start_time;
            $schedule->end_time = $request->end_time;
            $schedule->user_id = $request->user_id;
            $schedule->customer_id = $request->customer_id;
            $schedule->work_schedule_id = $request->work_schedule_id;
            $schedule->save();

            $alert = 'success';
            
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }catch(ValidationException $e){
            // dd($request->input());
            return redirect()->back()->withInput()->withErrors($e->errors());
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar entidade para cadastrar horário. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para formulário de horarios. ' . $e->getMessage();
        }
        
        if ($customer){
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }

    public function formWorkSchedule(Request $request, $customer_id = null, $schedule_id = null){
        $alert = null;
        $msg = null;
        $customer = null;
        $schedule = null;
        try{
            $customer = Customers::findOrFail($customer_id);

            if ($schedule_id){
                $schedule = WorkSchedule::findOrFail($schedule_id);
            }else{
                $schedule = new WorkSchedule();
            }

            return view('common_access.customers.form_work_schedule', [ 'customer' => $customer, 'schedule' => $schedule ]);
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar entidade para cadastrar escala. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para clientes ' . $e->getMessage();
        }
        
        if ($customer){
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }
    
    public function saveWorkSchedule(Request $request, $customer_id = null){
        $alert = null;
        $msg = null;
        $customer = null;
        $schedule = null;
        try{
            $customer = Customers::findOrFail($customer_id);
            $user = Auth::user();
            if ($request->id){
                $schedule = WorkSchedule::findOrFail($request->id);
                $msg = 'Estacala atualizada com sucesso';
            }else{
                $schedule = new WorkSchedule();
                $msg = 'Escala cadastrada com sucesso';
            }

            $request->request->add([
                'user_id' => $user->id
                ]);

            $this->validate($request, $schedule->rules);

            $schedule->type = $request->type;
            $schedule->hours_per_day = $request->hours_per_day;
            $schedule->price_per_day = $request->price_per_day;
            $schedule->description = $request->description;
            $schedule->user_id = $request->user_id;
            $schedule->customer_id = $request->customer_id;
            $schedule->save();

            $alert = 'success';
            
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }catch(ValidationException $e){
            return redirect()->back()->withInput()->withErrors($e->errors());
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar entidade para cadastrar horário. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para formulário de horarios. ' . $e->getMessage();
        }
        
        if ($customer){
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }

    public function listWorkSchedules($customer_id = null){
        try{
            $data = WorkSchedule::select('id', DB::raw('CASE WHEN type = 1 THEN "HORAS DIARIAS" WHEN type = 2 THEN "PREÇO POR HORA" END as "type"'), 'description', DB::raw('IFNULL(hours_per_day, price_per_day) as value'))
            ->where('customer_id', '=', $customer_id)
            ->get();

            $columns = [
                [
                    'id' => 0,
                    'label' => 'ID',
                    'value' => 'id'
                ],
                [
                    'id' => 1,
                    'label' => 'Tipo',
                    'value' => 'type'
                ],
                [
                    'id' => 2,
                    'label' => 'Descrição',
                    'value' => 'description'
                ],
                [
                    'id' => 3,
                    'label' => 'Valor',
                    'value' => 'value'
                ],
                [
                    'id' => 4,
                    'label' => 'Ações',
                    'value' => 'actions',
                    'sortable' => false
                ]
            ];

            $rows = [];
            foreach ($data as $work_schedule) {
                array_push($rows, [
                    [
                        'field' => 'id',
                        'value' => $work_schedule->id,
                        'filter' => null
                    ],
                    [
                        'field' => 'type',
                        'value' => $work_schedule->type,
                        'filter' => null
                    ],
                    [
                        'field' => 'description',
                        'value' => $work_schedule->description,
                        'filter' => null
                    ],
                    [
                        'field' => 'value',
                        'value' => $work_schedule->value,
                        'filter' => null
                    ],
                    [
                        'field' => 'actions',
                        'value' => $work_schedule->id,
                        'filter' => 'link_edit'
                    ],
                ]);
            }

            return response()
                ->json([
                    'rows' => $rows,
                    'columns' => $columns
                    ],
                    201
                );
        }catch(Exception $e){
            return response()
                ->json(
                    ['message' => $e->getMessage() ],
                    400
                );
        }
    }

    public function listSchedulesWork($customer_id = null){
        try{
            $data = SchedulesWorked::select('schedules_worked.id', 'schedules_worked.start_time', 'schedules_worked.end_time', 'work_schedule.description as description_workschedule')
            ->leftJoin('work_schedule', 'schedules_worked.work_schedule_id', '=', 'work_schedule.id')
            ->where('schedules_worked.customer_id', '=', $customer_id)
            ->orderBy('schedules_worked.start_time', 'desc')
            ->get();

            $columns = [
                [
                    'id' => 0,
                    'label' => 'Hora Início',
                    'value' => 'start_time'
                ],
                [
                    'id' => 1,
                    'label' => 'Hora Fim',
                    'value' => 'end_time'
                ],
                [
                    'id' => 2,
                    'label' => 'Escala',
                    'value' => 'description_workschedule'
                ],
                [
                    'id' => 4,
                    'label' => 'Ações',
                    'value' => 'actions',
                    'sortable' => false
                ]
            ];

            $rows = [];
            foreach ($data as $schedules_worked) {
                array_push($rows, [
                    [
                        'field' => 'start_time',
                        'value' => $schedules_worked->start_time,
                        'filter' => null
                    ],
                    [
                        'field' => 'end_time',
                        'value' => $schedules_worked->end_time,
                        'filter' => null
                    ],
                    [
                        'field' => 'description_workschedule',
                        'value' => $schedules_worked->description_workschedule,
                        'filter' => null
                    ],
                    [
                        'field' => 'actions',
                        'value' => $schedules_worked->id,
                        'filter' => 'link_edit_worked_schedule'
                    ],
                ]);
            }

            return response()
                ->json([
                    'rows' => $rows,
                    'columns' => $columns
                    ],
                    201
                );
        }catch(Exception $e){
            return response()
                ->json(
                    ['message' => $e->getMessage() ],
                    400
                );
        }
    }

    public function listAbsence_permission($customer_id = null){
        try{
            $data = AbsencePermission::select('absence_permission.id', 'absence_permission.date', 'absence_permission.hours_absence', 'absence_permission.description')
            ->where('absence_permission.customer_id', '=', $customer_id)
            ->orderBy('absence_permission.date', 'desc')
            ->get();

            $columns = [
                [
                    'id' => 0,
                    'label' => 'Data',
                    'value' => 'date'
                ],
                [
                    'id' => 1,
                    'label' => 'Horas',
                    'value' => 'hours_absence'
                ],
                [
                    'id' => 2,
                    'label' => 'Descrição',
                    'value' => 'description'
                ],
                [
                    'id' => 4,
                    'label' => 'Ações',
                    'value' => 'actions',
                    'sortable' => false
                ]
            ];

            $rows = [];
            foreach ($data as $absence) {
                array_push($rows, [
                    [
                        'field' => 'date',
                        'value' => $absence->date,
                        'filter' => null
                    ],
                    [
                        'field' => 'hours_absence',
                        'value' => $absence->hours_absence,
                        'filter' => null
                    ],
                    [
                        'field' => 'description',
                        'value' => $absence->description,
                        'filter' => null
                    ],
                    [
                        'field' => 'actions',
                        'value' => $absence->id,
                        'filter' => 'link_edit_absence'
                    ],
                ]);
            }

            return response()
                ->json([
                    'rows' => $rows,
                    'columns' => $columns
                    ],
                    201
                );
        }catch(Exception $e){
            return response()
                ->json(
                    ['message' => $e->getMessage() ],
                    400
                );
        }
    }

    public function formAbsencePermission(Request $request, $customer_id = null, $absence_id = null){
        $alert = null;
        $msg = null;
        $customer = null;
        $absence = null;
        try{
            $customer = Customers::findOrFail($customer_id);

            if ($absence_id){
                $absence = AbsencePermission::findOrFail($absence_id);
            }else{
                $absence = new AbsencePermission();
            }

            return view('common_access.customers.form_absence_hours', [ 'customer' => $customer, 'absence' => $absence ]);
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar entidade para cadastrar abono. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para clientes ' . $e->getMessage();
        }
        
        if ($customer){
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }

    public function saveAbsencePermission(Request $request, $customer_id = null){
        $alert = null;
        $msg = null;
        $customer = null;
        $schedule = null;
        try{
            $customer = Customers::findOrFail($customer_id);
            $user = Auth::user();
            if ($request->id){
                $absence = AbsencePermission::findOrFail($request->id);
                $msg = 'Abono atualizado com sucesso';
            }else{
                $absence = new AbsencePermission();
                $msg = 'Abono cadastrado com sucesso';
            }

            $request->request->add([
                'user_id' => $user->id
                ]);

            $this->validate($request, $absence->rules);

            $absence->date = $request->date;
            $absence->hours_absence = $request->hours_absence;
            $absence->description = $request->description;
            $absence->user_id = $request->user_id;
            $absence->customer_id = $request->customer_id;
            $absence->save();

            $alert = 'success';
            
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }catch(ValidationException $e){
            return redirect()->back()->withInput()->withErrors($e->errors());
        }catch(ModelNotFoundException $e){
            $alert = 'danger';
            $msg = 'Não foi possível localizar entidade para cadastrar abono. ' . $e->getMessage();
        }catch(Exception $e){
            $alert = 'danger';
            $msg = 'Falha ao processar requisição para formulário de abono. ' . $e->getMessage();
        }
        
        if ($customer){
            return redirect()->route('profile.customers', ['customer_id' => $customer->id])->with('msg', $msg)->with('alert', $alert);
        }
        return redirect()->route('list.customers')->with('msg', $msg)->with('alert', $alert);
    }
}
