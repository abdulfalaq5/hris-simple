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
                    <h3>My Payrolls</h3>
                    <p class="text-subtitle text-muted">Riwayat penggajian kamu</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('sales.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payrolls</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <h5 class="card-title mb-0">Payroll List</h5>

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
                        </div>

                        <button class="btn btn-sm btn-danger rounded-cs" onclick="clearSearch()">Clear</button>
                    </div>
                </div>

                <div class="card-body">
                    <x-sweetalertsession />

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Pay Date</th>
                                <th>Salary</th>
                                <th>Bonuses</th>
                                <th>Deductions</th>
                                <th>Net Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payrolls as $payroll)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($payroll->pay_date)->format('d F Y') }}</td>
                                    <td>Rp {{ number_format($payroll->salary, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($payroll->bonuses > 0)
                                            <span class="text-success">+Rp {{ number_format($payroll->bonuses, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payroll->deductions > 0)
                                            <span class="text-danger">-Rp {{ number_format($payroll->deductions, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><strong>Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data payroll.</td>
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
        function doReload() {
            const url = "{{ route('sales.payrolls') }}";
            let query = "";
            const b = $('#bulan').val();
            const t = $('#tahun').val();
            if (b) query += (query ? '&' : '?') + 'b=' + b;
            if (t) query += (query ? '&' : '?') + 't=' + t;
            window.location.href = url + query;
        }

        function clearSearch() {
            $('#bulan').val('');
            $('#tahun').val('');
            doReload();
        }
    </script>
@endpush
