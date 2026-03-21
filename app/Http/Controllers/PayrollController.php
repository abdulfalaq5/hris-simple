<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayrollRequest;
use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = [
            'bulan' => ($request->has('b') ?  $request->input('b') : ''),
            'tahun' => ($request->has('t') ?  $request->input('t') : ''),
            'start' => ($request->has('start') ?  $request->input('start') : ''),
            'end' => ($request->has('end') ?  $request->input('end') : '')
        ];

        if ($search['bulan'] || $search['tahun'] || $search['start'] || $search['end']) {
            $payrolls = Payroll::filteringPayrolls($search['bulan'], $search['tahun'], $search['start'], $search['end']);
        } else {
            $payrolls = Payroll::getIndexPayrolls();
        }

        $list_bulan = \App\Library\MyHelpers::list_bulan();
        $list_tahun = \App\Library\MyHelpers::list_tahun();
        return view('payrolls.index', [
            'payrolls' => $payrolls,
            'list_bulan' => $list_bulan,
            'list_tahun' => $list_tahun,
        ])->with([
            'title' => 'Payroll List',
            'subtitle' => 'List of all payrolls in the system',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = \App\Models\Employee::all();
        return view('payrolls.create', [
            'employees' => $employees,
        ])->with([
            'title' => 'Create Payroll',
            'subtitle' => 'Create a new payroll record',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PayrollRequest $request)
    {
        $validated = $request->validated();

        $netSalary = $validated['salary'] + $validated['bonuses'] - $validated['deductions'];

        if ($netSalary < $request->input('deductions') || $netSalary < $request->input('salary')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['deductions' => 'Deductions cannot be greater than salary.'])
                ->with(['error' => 'Net salary cannot be less than deductions or salary.']);
        }

        $validated['net_salary'] = $netSalary;


        Payroll::create($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $allPayrolls = Payroll::getIndexPayrolls();
        $payroll = collect($allPayrolls)->firstWhere('id', $id);

        return view('payrolls.show', [
            'payroll' => $payroll,
        ])->with([
            'title' => 'Payroll Detail',
            'subtitle' => 'Details of the selected payroll record',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        $employees = \App\Models\Employee::get();

        return view('payrolls.edit', [
            'payroll' => $payroll,
            'employees' => $employees,
        ])->with([
            'title' => 'Edit Payroll',
            'subtitle' => 'Edit the selected payroll record',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PayrollRequest $request, string $id)
    {
        $validated = $request->validated();

        $salary = $validated['salary'];
        $bonuses = $validated['bonuses'];
        $deductions = $validated['deductions'];

        if ($deductions > ($salary + $bonuses)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['deductions' => 'Deductions cannot exceed the sum of salary and bonuses.']);
        }

        $netSalary = $salary + $bonuses - $deductions;
        $validated['net_salary'] = $netSalary;

        $payroll = Payroll::findOrFail($id);
        $payroll->update($validated);

        return redirect()->route('payrolls.index')->with('success', 'Payroll updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payroll = Payroll::findOrFail($id);
        $payroll->delete();

        return redirect()->route('payrolls.index')->with('success', 'Payroll deleted successfully.');
    }
}
