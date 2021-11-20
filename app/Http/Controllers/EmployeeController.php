<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    public function __construct() 
    {
        $this->authorizeResource(Employee::class);
    }
    
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'can' => [
                'create' => auth()->user()->can('create', Employee::class),
            ],
            'department_id' => Request::get('department_id'),
            'employees' => Employee::orderBy('id', 'DESC')
                ->with('department')
                ->whereDepartment(Request::get('department_id'))
                ->get()
                ->transform(function ($employee) {
                    return [
                        'id' => $employee->id,
                        'name' => $employee->name,
                        'email' => $employee->email,
                        'department' => $employee->department->name ?? null,
                        'can' => [
                            'delete' => auth()->user()->can('delete', $employee),
                            'edit' => auth()->user()->can('update', $employee),
                        ],
                    ];
                }),
            'departments' => function () {
                return Department::orderBy('name')->get()
                    ->transform(function ($d) {
                        return [
                            'id' => $d->id,
                            'label' =>  $d->name
                        ];
                    });
            }
        ]);
    }

    public function create()
    {
        //
        return Inertia::render('Employees/Create', [
            'departments' => Employee::orderBy('name')->get()
                ->transform(function ($d) {
                    return [
                        'id' => $d->id,
                        'label' => $d->name,
                    ];
                }),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->all());

        return Redirect::route('employees.index')->with('success', 'Employee created.');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', [
            'employee' => [
                'id' => $employee->id,
                'department_id' => $employee->department->id,
                'name' => $employee->name,
                'email' => $employee->email,
            ],
            'departments' => Employee::orderBy('name')->get()
                ->transform(function ($d) {
                    return [
                        'id' => $d->id,
                        'label' => $d->name,
                    ];
                }),
        ]);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());
        return Redirect::route('employees.index')->with('success', 'Employee Updated.');
    }
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return Redirect::back()->with('success', 'Employee deleted.');
    }
}
