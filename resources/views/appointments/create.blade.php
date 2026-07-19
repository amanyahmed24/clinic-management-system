@extends('layouts.app')
@section('content')
    <div class=" container ml-3">
        <form action="{{ route('appoints.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>
                    <input type="radio" name="patient_type" value="existing" checked>
                    Existing Patient
                </label>

                <label class="ms-3">
                    <input type="radio" name="patient_type" value="new">
                    New Patient
                </label>
            </div>

            <div id="existingPatient">

                <div class="mb-3">
                    <label>Search Patient</label>

                    <input type="text" id="patient_search" class="form-control" placeholder="Search by patient name...">

                    <input type="hidden" name="patient_id" id="patient_id">

                    <div id="search_results" class="list-group mt-2"></div>
                </div>

            </div>

            <div id="newPatient" style="display:none;">

                <div class="mb-2">

                    <label>Name</label>

                    <input type="text" name="name" id="name" class="form-control">

                </div>

                <div class="mb-2">

                    <label>Age</label>

                    <input type="number" name="age" id="age" class="form-control">

                </div>

                <div class="mb-2">

                    <label>Phone</label>

                    <input type="text" name="phone" id="phone" class="form-control">
                </div>

            </div>


            <div class="mb-3">
                <label class="mx-2">Appointment Type : </label>
                <label>
                    <input type="radio" name="type" value="checkup" checked>
                    Checkup
                </label>

                <label class="ms-3">
                    <input type="radio" name="type" value="consultation">
                    Consultation
                </label>
            </div>
    </div>



    <button class="mt-3 btn btn-primary">
        Save Appointment
    </button>

    </form>
    </div>
    <script>
        const existingRadio = document.querySelector('input[value="existing"]');
        const newRadio = document.querySelector('input[value="new"]');

        const existingDiv = document.getElementById('existingPatient');
        const newDiv = document.getElementById('newPatient');

        const inputs = document.querySelectorAll('#newPatient input');

        function toggleForm() {

            if (existingRadio.checked) {

                existingDiv.style.display = 'block';
                newDiv.style.display = 'none';

                inputs.forEach(input => input.disabled = true);

            } else {

                existingDiv.style.display = 'none';
                newDiv.style.display = 'block';

                inputs.forEach(input => input.disabled = false);

            }

        }

        toggleForm();

        existingRadio.addEventListener('change', toggleForm);
        newRadio.addEventListener('change', toggleForm);
    </script>


    <script>
        const input = document.getElementById('patient_search');
        const results = document.getElementById('search_results');
        const patientId = document.getElementById('patient_id');

        input.addEventListener('keyup', function() {

            let keyword = this.value;

            if (keyword.length < 2) {
                results.innerHTML = "";
                return;
            }

            fetch(`/patients/search?search=${keyword}`)
                .then(res => res.json())
                .then(data => {

                    results.innerHTML = "";

                    data.forEach(patient => {

                        results.innerHTML += `
                    <button
                        type="button"
                        class="list-group-item list-group-item-action"
                        onclick="selectPatient(${patient.id}, '${patient.name}')">

                        ${patient.name} - ${patient.phone}

                    </button>
                `;

                    });

                });

        });

        function selectPatient(id, name) {
            patientId.value = id;
            input.value = name;
            results.innerHTML = "";
        }
    </script>
@endsection
