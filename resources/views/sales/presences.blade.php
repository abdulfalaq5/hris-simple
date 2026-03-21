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
                    <h3>My Presences</h3>
                    <p class="text-subtitle text-muted">Riwayat kehadiran kamu</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('sales.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Presences</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="card-title mb-0">Presence List</h5>

                        <div class="d-flex align-items-center gap-2 ms-auto me-2">
                            <select class="form-select form-select-sm w-auto rounded-cs" id="bulan" onchange="doReload()">
                                <option value="">-- Select Month --</option>
                                @foreach ($list_bulan as $key => $val)
                                    <option value="{{ $key }}" {{ request('b') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>

                            <select class="form-select form-select-sm w-auto rounded-cs" id="tahun" onchange="doReload()">
                                <option value="">-- Select Year --</option>
                                @foreach ($list_tahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('t') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                                @endforeach
                            </select>

                            <input type="text" id="rangeTanggal" placeholder="Pilih rentang tanggal"
                                class="form-select form-select-sm rounded-cs">
                        </div>

                        <button class="btn btn-sm btn-danger rounded-cs" onclick="clearSearch()">Clear</button>
                    </div>
                </div>

                <div class="card-body">
                    <x-sweetalertsession />

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($presences as $presence)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($presence->date)->format('d F Y') }}</td>
                                    <td><small>{{ \Carbon\Carbon::parse($presence->check_in)->format('H:i') }}</small></td>
                                    <td>
                                        <small>
                                            {{ $presence->check_out ? \Carbon\Carbon::parse($presence->check_out)->format('H:i') : '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if ($presence->status == 'present')
                                            <span class="badge bg-success rounded-cs">Present</span>
                                        @elseif ($presence->status == 'absent')
                                            <span class="badge bg-danger rounded-cs">Absent</span>
                                        @elseif ($presence->status == 'leave')
                                            <span class="badge bg-info rounded-cs">Leave</span>
                                        @elseif ($presence->status == 'sick')
                                            <span class="badge bg-warning rounded-cs">Sick</span>
                                        @else
                                            <span class="badge bg-secondary rounded-cs">{{ ucfirst($presence->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada data kehadiran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        flatpickr("#rangeTanggal", {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: { rangeSeparator: " to " },
            defaultDate: ["{{ request('start') }}", "{{ request('end') }}"],
            onClose: function() { doReload(); }
        });

        function doReload() {
            const url = "{{ route('sales.presences') }}";
            let query = "";
            const b = $('#bulan').val();
            const t = $('#tahun').val();
            const range = $('#rangeTanggal').val();
            if (b) query += (query ? '&' : '?') + 'b=' + b;
            if (t) query += (query ? '&' : '?') + 't=' + t;
            if (range.includes(' to ')) {
                const [start, end] = range.split(' to ').map(s => s.trim());
                if (start) query += (query ? '&' : '?') + 'start=' + start;
                if (end) query += (query ? '&' : '?') + 'end=' + end;
            }
            window.location.href = url + query;
        }

        function clearSearch() {
            $('#bulan').val('');
            $('#tahun').val('');
            $('#rangeTanggal').val('');
            doReload();
        }
    </script>
@endpush
