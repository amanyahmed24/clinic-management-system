@extends('layouts.app')
@section('content')
    <h2>Patients</h2>

    <a href="{{ route('patients.create') }}">
        Add Patient
    </a>
    <div class="tab-content rounded-bottom">
        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Age</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>{{ $patient->phone }}</td>

                            <td>
                                <a href="{{ route('patients.show', $patient) }}">
                                    View
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('patients.edit', $patient) }}">
                                    Edit
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


    {{ $patients->links() }}
@endsection
