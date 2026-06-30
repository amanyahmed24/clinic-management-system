@extends('layouts.app')
@section('content')

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $patient->name }}">

        <input type="number" name="age" value="{{ $patient->age }}">

        <input type="text" name="phone" value="{{ $patient->phone }}">

        <button type="submit">
            Update
        </button>
    </form>

@endsection
