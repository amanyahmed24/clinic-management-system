<h2>Patients</h2>

<a href="{{ route('patients.create') }}">
    Add Patient
</a>

<table border="1">
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Phone</th>
        <th>Actions</th>
    </tr>

    @foreach ($patients as $patient)
        <tr>
            <td>{{ $patient->name }}</td>
            <td>{{ $patient->age }}</td>
            <td>{{ $patient->phone }}</td>

            <td>
                <a href="{{ route('patients.show', $patient) }}">
                    View
                </a>

                <a href="{{ route('patients.edit', $patient) }}">
                    Edit
                </a>

                <form action="{{ route('patients.destroy', $patient) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

{{ $patients->links() }}
