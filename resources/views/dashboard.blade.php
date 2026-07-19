@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2>Dashboard</h2>

            <form action="{{ route('appointments.callNext') }}" method="POST">

                @csrf

                <button class="btn btn-success btn-lg">

                    Call Next

                </button>

            </form>

        </div>


        <div class="card mb-4">

            <div class="card-header">

                Current Appointment

            </div>

            <div class="card-body">

                @if ($currentAppointment)
                    <h3>

                        Queue #{{ $currentAppointment->queue_number }}

                    </h3>

                    <p>

                        {{ $currentAppointment->patient->name }}

                    </p>

                    <span class="badge bg-primary">

                        {{ ucfirst($currentAppointment->appointment_type) }}

                    </span>
                @else
                    <h5>No Current Appointment</h5>
                @endif

            </div>

        </div>

        <div class="row">

            <div class="col-md-4">

                <div class="card text-center">

                    <div class="card-body">

                        <h5>Today's Appointments</h5>

                        <h2>{{ $todayTotal }}</h2>

                        <hr>

                        Checkup : {{ $todayCheckup }}

                        <br>

                        Consultation : {{ $todayConsultation }}

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card text-center">

                    <div class="card-body">

                        <h5>Completed</h5>

                        <h2>{{ $completedTotal }}</h2>

                        <hr>

                        Checkup : {{ $completedCheckup }}

                        <br>

                        Consultation : {{ $completedConsultation }}

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card text-center">

                    <div class="card-body">

                        <h5>Waiting</h5>

                        <h2>{{ $waitingTotal }}</h2>

                        <hr>

                        Checkup : {{ $waitingCheckup }}

                        <br>

                        Consultation : {{ $waitingConsultation }}

                    </div>

                </div>

            </div>

        </div>


        <div class="card mt-4">

            <div class="card-header">

                Waiting Queue

            </div>

            <div class="card-body">

                <table class="table table-hover">

                    <thead>

                        <tr>

                            <th>Queue</th>

                            <th>Patient</th>

                            <th>Phone</th>

                            <th>Type</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($waitingAppointments as $appointment)
                            <tr>

                                <td>

                                    {{ $appointment->queue_number }}

                                </td>

                                <td>

                                    {{ $appointment->patient->name }}

                                </td>

                                <td>

                                    {{ $appointment->patient->phone }}

                                </td>

                                <td>

                                    @if ($appointment->appointment_type == 'checkup')
                                        <span class="badge bg-info">

                                            Checkup

                                        </span>
                                    @else
                                        <span class="badge bg-secondary">

                                            Consultation

                                        </span>
                                    @endif

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
@endsection
