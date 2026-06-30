@extends('layouts.app')

@section('content')
    <h2>Patients</h2>

    <table class="table">

        <tr>

            <th>Queue</th>

            <th>Patient</th>

            <th>Status</th>

            <th>Date</th>

        </tr>

        @foreach ($appointments as $appointment)
            <tr>

                <td>

                    {{ $appointment->queue_number }}

                </td>

                <td>

                    {{ $appointment->patient->name }}

                </td>

                <td>

                    {{ ucfirst($appointment->status) }}

                </td>
                <td>{{ $appointment->created_at }}</td>

            </tr>
        @endforeach

    </table>
@endsection
