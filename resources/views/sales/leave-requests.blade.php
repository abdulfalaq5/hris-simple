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
                    <h3>My Leave Requests</h3>
                    <p class="text-subtitle text-muted">Kelola permohonan cuti kamu</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('sales.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leave Requests</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            {{-- Sisa Cuti Info --}}
            <div class="row mb-3">
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            @php $pct = $jatahCuti > 0 ? round(($cutiTerpakai / $jatahCuti) * 100) : 0; @endphp
                            <h6 class="text-muted mb-1">Jatah Cuti {{ now()->year }}</h6>
                            <h2 class="fw-bold mb-1 {{ $sisaCuti <= 2 ? 'text-danger' : ($sisaCuti <= 5 ? 'text-warning' : 'text-success') }}">
                                {{ $sisaCuti }}
                                <small class="fs-6 text-muted fw-normal">/ {{ $jatahCuti }} hari</small>
                            </h2>
                            <div class="progress mt-2" style="height: 8px; border-radius: 8px;">
                                <div class="progress-bar {{ $pct >= 90 ? 'bg-danger' : ($pct >= 60 ? 'bg-warning' : 'bg-success') }}"
                                    role="progressbar" style="width: {{ $pct }}%"></div>
                            </div>
                            <small class="text-muted mt-1 d-block">Terpakai: {{ $cutiTerpakai }} hari</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    {{-- Form Buat Leave Request --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ajukan Cuti Baru</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.leave-requests.store') }}" method="POST">
                                @csrf
                                @if (session('success'))
                                    <div class="alert alert-success rounded-cs py-2">{{ session('success') }}</div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger rounded-cs py-2">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Jenis Cuti</label>
                                        <select name="leave_type" class="form-select rounded-cs @error('leave_type') is-invalid @enderror" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>Sick</option>
                                            <option value="vacation" {{ old('leave_type') == 'vacation' ? 'selected' : '' }}>Vacation</option>
                                            <option value="maternity" {{ old('leave_type') == 'maternity' ? 'selected' : '' }}>Maternity</option>
                                            <option value="paternity" {{ old('leave_type') == 'paternity' ? 'selected' : '' }}>Paternity</option>
                                        </select>
                                        @error('leave_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                                        <input type="text" name="start_date" value="{{ old('start_date') }}"
                                            class="form-control date rounded-cs @error('start_date') is-invalid @enderror"
                                            placeholder="YYYY-MM-DD" required>
                                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Tanggal Selesai</label>
                                        <input type="text" name="end_date" value="{{ old('end_date') }}"
                                            class="form-control date rounded-cs @error('end_date') is-invalid @enderror"
                                            placeholder="YYYY-MM-DD" required>
                                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary rounded-cs">
                                        <i class="bi bi-send me-1"></i> Ajukan Cuti
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Riwayat Leave --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Riwayat Permohonan Cuti</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Jenis Cuti</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leaveRequests as $lr)
                                @php
                                    $start    = \Carbon\Carbon::parse($lr->start_date);
                                    $end      = \Carbon\Carbon::parse($lr->end_date);
                                    $durasi   = $start->diffInDays($end) + 1;
                                @endphp
                                <tr>
                                    <td>
                                        <span class="badge bg-info rounded-cs">{{ ucfirst($lr->leave_type) }}</span>
                                    </td>
                                    <td>{{ $start->format('d F Y') }}</td>
                                    <td>{{ $end->format('d F Y') }}</td>
                                    <td>{{ $durasi }} hari</td>
                                    <td>
                                        @if ($lr->status == 'approved')
                                            <span class="badge bg-success rounded-cs">Approved</span>
                                        @elseif ($lr->status == 'rejected')
                                            <span class="badge bg-danger rounded-cs">Rejected</span>
                                        @else
                                            <span class="badge bg-warning rounded-cs">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada permohonan cuti.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection
