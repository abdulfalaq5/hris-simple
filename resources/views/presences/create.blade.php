@extends('layouts.dashboard')
@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ $subtitle }}
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('tasks.index') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Presences
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create Presence</h5>
            </div>
            <div class="card-body">
                <x-sweetalertsession />
                @if (session('role') == 'HR')
                    <form action="{{ route('presences.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select name="employee_id"
                                class="form-select form-select-sm rounded-cs select2 @error('employee_id') is-invalid @enderror"
                                id="employee_id">
                                <option value="" disabled selected>--Select Employee--</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}"
                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->fullname }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="check_in" class="form-label">Check In</label>
                            <input type="text" name="check_in" id="check_in"
                                class="form-control form-control-sm rounded-cs time @error('check_in') is-invalid @enderror"
                                value="{{ old('check_in') }}" placeholder="Check In Time">
                            @error('check_in')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="check_out" class="form-label">Check Out</label>
                            <input type="text" name="check_out" id="check_out"
                                class="form-control form-control-sm rounded-cs time @error('check_out') is-invalid @enderror"
                                value="{{ old('check_out') }}" placeholder="Check Out Time">
                            @error('check_out')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date"
                                class="form-control form-control-sm rounded-cs date @error('date') is-invalid @enderror"
                                value="{{ old('date') }}" placeholder="Select Date">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status"
                                class="form-select form-select-sm rounded-cs @error('status') is-invalid @enderror"
                                id="status">
                                <option value="" disabled selected>--Select Status--</option>
                                <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                                <option value="sick" {{ old('status') == 'sick' ? 'selected' : '' }}>Sick</option>
                                <option value="holiday" {{ old('status') == 'holiday' ? 'selected' : '' }}>Holiday</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <a href="{{ route('presences.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                                    class="bi bi-arrow-left"></i> Back to List</a>
                            <button type="submit" class="btn btn-sm rounded-cs btn-primary"><i class="bi bi-upload"></i>
                                Submit</button>
                        </div>
                    </form>
                @else
                    <form action="{{ route('presences.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <b>Note:</b>
                            Mohon izinkan akses lokasi, supaya presensi diterima
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label form-label-sm">Latitude</label>
                            <input type="text" name="latitude" id="latitude"
                                class="form-control form-control-sm rounded-cs @error('latitude') is-invalid @enderror"
                                placeholder="Latitude" required readonly>
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="longitude" class="form-label form-label-sm">Longitude</label>
                            <input type="text" name="longitude" id="longitude"
                                class="form-control form-control-sm rounded-cs @error('longitude') is-invalid @enderror"
                                placeholder="Longitude" required readonly>
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div id="map" style="height: 500px; width: 100%;"></div>
                        </div>

                        <button type="submit" class="btn btn-sm rounded-cs btn-primary" id="btn-presence"
                            disabled>Presence</button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            const latitude = $('#latitude');
            const longitude = $('#longitude');
            const btnPresence = $('#btn-presence');

            // const officeLatLng = [-6.8880296, 107.6344422];
            const officeLatLng = [-6.8882904479117, 107.63463652541988];
            const maxDistance = 20; // meter

            // Inisialisasi peta
            const map = L.map('map').setView(officeLatLng, 20);

            // Tile Layers
            const normal = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CartoDB',
                subdomains: 'abcd',
                maxZoom: 19
            }).addTo(map);

            const satellite = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenTopoMap',
                maxZoom: 17
            });

            const dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; CartoDB',
                subdomains: 'abcd',
                maxZoom: 19
            });

            // Layer control
            const baseMaps = {
                "Normal": normal,
                "Satelit": satellite,
                "Dark": dark
            };
            L.control.layers(baseMaps).addTo(map);

            // Marker kantor (Hijau)
            const kantorIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            L.marker(officeLatLng, {
                    icon: kantorIcon
                }).addTo(map)
                .bindPopup("Kantor").openPopup();

            // Lingkaran radius kantor
            L.circle(officeLatLng, {
                radius: maxDistance,
                color: 'green',
                fillColor: '#0f0',
                fillOpacity: 0.3
            }).addTo(map);

            // Geolokasi pengguna
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const userLatLng = [pos.coords.latitude, pos.coords.longitude];

                    latitude.val(pos.coords.latitude);
                    longitude.val(pos.coords.longitude);

                    // Marker user (Biru)
                    const userIcon = new L.Icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
                        shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    L.marker(userLatLng, {
                            icon: userIcon
                        }).addTo(map)
                        .bindPopup("Lokasi Anda").openPopup();

                    map.setView(userLatLng, 20);

                    const distance = map.distance(officeLatLng, userLatLng);

                    if (distance <= maxDistance) {
                        locationAlert.success('Anda berada di dalam radius kantor.');
                        btnPresence.removeAttr('disabled');
                    } else {
                        locationAlert.error('Anda berada di luar radius kantor.');
                        btnPresence.attr('disabled', 'disabled');
                    }
                }, function() {
                    locationAlert.failed('Tidak bisa mendapatkan lokasi Anda.');
                });
            } else {
                locationAlert.unsupported('Geolocation tidak didukung oleh browser ini.');
            }
        });
    </script>

    <style>
        .leaflet-container {
            z-index: 0;
        }
    </style>
@endsection
