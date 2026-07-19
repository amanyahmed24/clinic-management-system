<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::with('patient')
            ->orderBy('queue_number')
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::latest()->paginate(10);

        return view('appointments.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'patient_type' => 'required|in:existing,new',
        ]);

        DB::beginTransaction();

        if ($request->patient_type == 'existing') {

            $request->validate([
                'patient_id' => 'required|exists:patients,id',
            ]);

            $patient = Patient::find($request->patient_id);
        } else {

            $request->validate([
                'name' => 'required',
                'age' => 'required|integer|min:0',
                'phone' => 'required|unique:patients,phone',
            ]);

            $patient = Patient::create([
                'name' => $request->name,
                'age' => $request->age,
                'phone' => $request->phone,
            ]);
        }

        $lastQueue = Appointment::max('queue_number');

        Appointment::create([

            'patient_id' => $patient->id,

            'created_by' => auth()->id(),

            'queue_number' => $lastQueue ? $lastQueue + 1 : 1,

            'status' => 'waiting',

            'appointment_type' => $request->type,

        ]);
        DB::commit();

        return redirect()
            ->route('appoints.index')
            ->with('success', 'Appointment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('appointments.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('appointments.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
