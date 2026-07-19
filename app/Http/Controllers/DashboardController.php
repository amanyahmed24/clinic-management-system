<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        // Current Appointment
        $currentAppointment = Appointment::with('patient')
            ->where('status', 'in_progress')
            ->first();

        // Waiting Queue
        $waitingAppointments = Appointment::with('patient')
            ->where('status', 'waiting')
            ->orderBy('queue_number')
            ->get();

        // Today's Appointments
        $todayAppointments = Appointment::whereDate('created_at', today());

        $todayTotal = (clone $todayAppointments)->count();

        $todayCheckup = (clone $todayAppointments)
            ->where('appointment_type', 'checkup')
            ->count();

        $todayConsultation = (clone $todayAppointments)
            ->where('appointment_type', 'consultation')
            ->count();

        // Completed Today
        $completedToday = Appointment::whereDate('created_at', today())
            ->where('status', 'done');

        $completedTotal = (clone $completedToday)->count();

        $completedCheckup = (clone $completedToday)
            ->where('appointment_type', 'checkup')
            ->count();

        $completedConsultation = (clone $completedToday)
            ->where('appointment_type', 'consultation')
            ->count();

        // Waiting
        $waiting = Appointment::where('status', 'waiting');

        $waitingTotal = (clone $waiting)->count();

        $waitingCheckup = (clone $waiting)
            ->where('appointment_type', 'checkup')
            ->count();

        $waitingConsultation = (clone $waiting)
            ->where('appointment_type', 'consultation')
            ->count();

        return view('dashboard', compact(
            'currentAppointment',
            'waitingAppointments',

            'todayTotal',
            'todayCheckup',
            'todayConsultation',

            'completedTotal',
            'completedCheckup',
            'completedConsultation',

            'waitingTotal',
            'waitingCheckup',
            'waitingConsultation'
        ));
    }

    public function callNext(WhatsAppService $whatsapp)
    {
        DB::beginTransaction();

        $currentAppointment = Appointment::where('status', 'in_progress')
            ->first();

        if ($currentAppointment) {

            $currentAppointment->update([
                'status' => 'done'
            ]);
        }
        $nextAppointment = Appointment::where('status', 'waiting')
            ->orderBy('queue_number')
            ->first();

        if ($nextAppointment) {

            $nextAppointment->update([
                'status' => 'in_progress'
            ]);
        }

        $nextThree = Appointment::with('patient')
            ->where('status', 'waiting')
            ->orderBy('queue_number')
            ->take(3)
            ->get();

        foreach ($nextThree as $index => $appointment) {

            $whatsapp->sendQueueNotification(
                $appointment,
                $index + 1
            );
        }

        DB::commit();
        return redirect()
            ->route('dashboard')
            ->with('success', 'Next patient called successfully.');
    }


    
}