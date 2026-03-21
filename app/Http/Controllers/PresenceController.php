<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresenceRequest;
use App\Models\Employee;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PresenceController extends Controller
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
            $presences = Presence::filteringPresences($search['bulan'], $search['tahun'], $search['start'], $search['end']);
        } else {
            $presences = Presence::getIndexPresences();
        }

        return view('presences.index', [
            'presences' => $presences,
            'list_bulan' => \App\Library\MyHelpers::list_bulan(),
            'list_tahun' => \App\Library\MyHelpers::list_tahun(),
        ])->with([
            'title' => 'Presence List',
            'subtitle' => 'List of all presences in the system',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('presences.create', [
            'employees' => $employees,
        ])->with([
            'title' => 'Create Presence',
            'subtitle' => 'Create a new presence record',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (session('role')  == 'HR') {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|exists:employees,id',
                'check_in' => 'required|date',
                'check_out' => 'nullable|date|after_or_equal:check_in',
                'status' => 'required|in:present,absent,leave,sick,holiday'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Presence::create([
                'employee_id' => $request->employee_id,
                'check_in' => Carbon::parse($request->check_in)->format('H:i'),
                'check_out' => Carbon::parse($request->check_out)->format('H:i'),
                'date' => date('Y-m-d'),
                'status' => $request->status
            ]);
        } else {
            Presence::create([
                'employee_id' => session('employee_id'),
                'check_in' => Carbon::now()->format('H:i'),
                'check_out' => null,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'date' => date('Y-m-d'),
                'status' => 'present'
            ]);
        }

        return redirect()->route('presences.index')->with('success', 'Recorded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presence $presence)
    {
        $employees = Employee::get();

        return view('presences.edit', [
            'presence' => $presence,
            'employees' => $employees,
        ])->with(['title' => 'Edit Presence', 'subtitle' => 'Edit the selected presence']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PresenceRequest $request, string $id)
    {
        $presence = Presence::findOrFail($id);
        $data = $request->validated();
        $presence->update($data);

        return redirect()->route('presences.index')->with('success', 'Presence updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $presence = Presence::findOrFail($id);
        $presence->delete();

        return redirect()->route('presences.index')->with('success', 'Presence deleted successfully.');
    }
}
