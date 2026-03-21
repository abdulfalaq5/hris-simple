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
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                Payrolls
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Index
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="card-title mb-0">Payroll List</h5>

                        <div class="d-flex align-items-center gap-2 ms-auto me-2">
                            <select class="form-select form-select-sm w-auto rounded-cs" id="bulan"
                                onchange="doReload()">
                                <option value="">-- Select Month --</option>
                                @foreach ($list_bulan as $key => $val)
                                    <option value="{{ $key }}" {{ request('b') == $key ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>

                            <select class="form-select form-select-sm w-auto rounded-cs" id="tahun"
                                onchange="doReload()">
                                <option value="">-- Select Year --</option>
                                @foreach ($list_tahun as $tahun)
                                    <option value="{{ $tahun }}" {{ request('t') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endforeach
                            </select>

                            <input type="text" id="rangeTanggal" placeholder="Pilih rentang tanggal"
                                class="form-select form-select-sm rounded-cs">

                        </div>

                        <button class="btn btn-sm btn-danger rounded-cs me-2" id="clearSearch" onclick="clearSearch()">Clear
                            Search</button>
                        @if (session('role') == 'HR')
                            <a href="{{ route('payrolls.create') }}"
                                class="btn btn-sm btn-primary rounded-cs align-self-start">
                                <i class="bi bi-plus"></i> Add New
                            </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">

                    <x-sweetalertsession />

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Fullname</th>
                                <th>Salary</th>
                                <th>Bonuses</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                                <th>Pay Date</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody id="payroll-table-body">
                            @foreach ($payrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->fullname ?? '-' }}</td>
                                    <td>{{ number_format($payroll->salary, 0, ',', '.') }}</td>
                                    <td>{{ number_format($payroll->bonuses, 0, ',', '.') }}</td>
                                    <td>{{ number_format($payroll->deductions, 0, ',', '.') }}</td>
                                    <td>{{ number_format($payroll->net_salary, 0, ',', '.') }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($payroll->pay_date)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        <div class="btn-group mb-1">
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm rounded-cs dropdown-toggle me-1"
                                                    type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton"
                                                    style="min-width: 40px;">
                                                    {{-- <a href="{{ route('payrolls.show', $payroll->id) }}"
                                                        class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                        style="background-color:#0dcaf0;">
                                                        <i class="bi bi-eye me-1"></i> View
                                                    </a> --}}

                                                    <a href="{{ route('payrolls.show', $payroll->id) }}"
                                                        class="dropdown-item btn btn-sm mb-1 text-white rounded-cs"
                                                        style="background-color:#0dcaf0;">
                                                        <i class="bi bi-wallet me-1"></i> Salary Slip
                                                    </a>
                                                    @if (session('role') == 'HR')
                                                        <a href="{{ route('payrolls.edit', $payroll->id) }}"
                                                            class="dropdown-item btn btn-sm text-white mb-1 rounded-cs"
                                                            style="background-color:#0d6efd;">
                                                            <i class="bi bi-pencil me-1"></i> Edit
                                                        </a>

                                                        <form id="form-delete-{{ $payroll->id }}" method="POST"
                                                            class="d-inline"
                                                            action="{{ route('payrolls.destroy', $payroll->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="dropdown-item btn btn-sm text-white rounded-cs"
                                                                data-swal-form-id="form-delete-{{ $payroll->id }}"
                                                                style="background-color:#dc3545;">
                                                                <i class="bi bi-trash me-1"></i> Delete
                                                            </button>
                                                        </form>

                                                        <x-sweetalertaction form-id="form-delete-{{ $payroll->id }}"
                                                            action="delete" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                    </table>
                </div>
            </div>
        </section>
    @endsection

    @push('scripts')
        <script>
            flatpickr("#rangeTanggal", {
                mode: "range",
                dateFormat: "Y-m-d",
                locale: {
                    rangeSeparator: " to "
                },
                defaultDate: [
                    "{{ request('start') }}",
                    "{{ request('end') }}"
                ],
                onClose: function(selectedDates, dateStr, instance) {
                    doReload();
                }
            });

            function doReload() {
                const url = "{{ url('payrolls') }}";
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
