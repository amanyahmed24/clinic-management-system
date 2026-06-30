@extends('layouts.app')
@section('content')
    <h2>Patient Details</h2>

    <p>Name: {{ $patient->name }}</p>

    <p>Age: {{ $patient->age }}</p>

    <p>Phone: {{ $patient->phone }}</p>

    <a href="{{ route('patients.index') }}">
        Back
    </a>
@endsection
