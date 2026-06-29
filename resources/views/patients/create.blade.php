@if ($errors->any())

    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

@endif

<form action="{{ route('patients.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Patient Name">

    <input type="number" name="age" placeholder="Age">

    <input type="text" name="phone" placeholder="Phone">

    <button type="submit">
        Save
    </button>

</form>
