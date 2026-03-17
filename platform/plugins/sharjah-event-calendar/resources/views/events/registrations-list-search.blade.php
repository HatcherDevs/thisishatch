@extends('core/base::layouts.master')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Registrations for {{ $event->name }}</h4>
            <div class="d-flex gap-2 align-items-center">
                <input type="search" id="registration-search" class="form-control w-100" placeholder="Search...">
                {{-- Future: Excel/PDF export --}}
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="registrations-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Registration #</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        {{-- <th>Status</th> --}}
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="registrations-body">
                    @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $registration->registration_number }}</td>
                            <td>{{ $registration->name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->phone }}</td>
                            {{-- <td>{{ ucfirst($registration->status) }}</td> --}}
                            <td>{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No registrations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <script>
        document.getElementById('registration-search').addEventListener('input', function () {
            let query = this.value;
            fetch(`{{ route('events.registrations.search', $event->id) }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    let tbody = document.getElementById('registrations-body');
                    tbody.innerHTML = '';
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No registrations found.</td></tr>';
                    } else {
                        data.forEach(function (registration, idx) {
                            tbody.innerHTML += `<tr>
                                <td>${idx + 1}</td>
                                <td>${registration.registration_number}</td>
                                <td>${registration.name}</td>
                                <td>${registration.email}</td>
                                <td>${registration.phone}</td>
                                <td>${registration.status.charAt(0).toUpperCase() + registration.status.slice(1)}</td>
                                <td>${registration.created_at}</td>
                            </tr>`;
                        });
                    }
                });
        });
    </script>
@endsection