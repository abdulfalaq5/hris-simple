@extends('layouts.dashboard')
@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>My Dashboard</h3>
        <p class="text-muted">Welcome back, <strong>{{ $employee->fullname ?? 'Sales' }}</strong> &mdash; {{ $employee->department->name ?? '' }} &bull; {{ $employee->role->title ?? '' }}</p>
    </div>

    <div class="page-content">

        {{-- Stats Cards --}}
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon green mb-2">
                                    <i class="icon dripicons dripicons-alarm"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Presences</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalPresences }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon red mb-2">
                                    <i class="icon dripicons dripicons-to-do"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Payrolls</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalPayrolls }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon blue mb-2">
                                    <i class="icon dripicons dripicons-calendar"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Sisa Cuti</h6>
                                <h6 class="font-extrabold mb-0">{{ $sisaCuti }} <small class="text-muted fw-normal">/ {{ $jatahCuti }} hari</small></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="icon dripicons dripicons-tag"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Pending Leave</h6>
                                <h6 class="font-extrabold mb-0">{{ $pendingLeave }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Leave Quota Progress --}}
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Leave Quota {{ now()->year }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Terpakai: <strong>{{ $cutiTerpakai }} hari</strong></span>
                            <span class="text-muted">Jatah: <strong>{{ $jatahCuti }} hari</strong></span>
                        </div>
                        @php $pct = $jatahCuti > 0 ? round(($cutiTerpakai / $jatahCuti) * 100) : 0; @endphp
                        <div class="progress" style="height: 14px; border-radius: 8px;">
                            <div class="progress-bar {{ $pct >= 90 ? 'bg-danger' : ($pct >= 60 ? 'bg-warning' : 'bg-success') }}"
                                role="progressbar" style="width: {{ $pct }}%">
                                {{ $pct }}%
                            </div>
                        </div>
                        <p class="mt-2 mb-0 text-muted small">
                            Sisa cuti kamu tahun ini: <strong>{{ $sisaCuti }} hari</strong>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Quick Actions</h4>
                    </div>
                    <div class="card-body d-flex flex-wrap gap-2">
                        <a href="{{ route('sales.presences') }}" class="btn btn-outline-primary rounded-cs">
                            <i class="bi bi-table me-1"></i> Lihat Presences
                        </a>
                        <a href="{{ route('sales.payrolls') }}" class="btn btn-outline-success rounded-cs">
                            <i class="bi bi-currency-dollar me-1"></i> Lihat Payrolls
                        </a>
                        <a href="{{ route('sales.leave-requests') }}" class="btn btn-outline-warning rounded-cs">
                            <i class="bi bi-calendar-check me-1"></i> Leave Requests
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
