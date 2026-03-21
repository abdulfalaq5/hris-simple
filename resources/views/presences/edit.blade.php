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
                                Edit
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
                <h5 class="card-title">Edit Presence</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('presences.update', $presence->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select name="employee_id"
                            class="form-select form-select-sm rounded-cs select2 @error('employee_id') is-invalid @enderror"
                            id="employee_id">
                            <option value="" disabled selected>--Select Employee--</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('employee_id', $presence->employee_id) == $employee->id ? 'selected' : '' }}>
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
                            value="{{ old('check_in', $presence->check_in) }}" placeholder="Check In Time">
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="check_out" class="form-label">Check Out</label>
                        <input type="text" name="check_out" id="check_out"
                            class="form-control form-control-sm rounded-cs time @error('check_out') is-invalid @enderror"
                            value="{{ old('check_out', $presence->check_out) }}" placeholder="Check Out Time">
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" name="date" id="date"
                            class="form-control form-control-sm rounded-cs date @error('date') is-invalid @enderror"
                            value="{{ old('date', $presence->date) }}" placeholder="Select Date">
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
                            <option value="present" {{ old('status', $presence->status) == 'present' ? 'selected' : '' }}>
                                Present</option>
                            <option value="absent" {{ old('status', $presence->status) == 'absent' ? 'selected' : '' }}>
                                Absent</option>
                            <option value="leave" {{ old('status', $presence->status) == 'leave' ? 'selected' : '' }}>
                                Leave</option>
                            <option value="sick" {{ old('status', $presence->status) == 'sick' ? 'selected' : '' }}>Sick
                            </option>
                            <option value="holiday" {{ old('status', $presence->status) == 'holiday' ? 'selected' : '' }}>
                                Holiday</option>
                        </select>
                    </div>

                    <div>
                        <a href="{{ route('presences.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                                class="bi bi-arrow-left"></i> Back to List</a>
                        <button type="submit" class="btn btn-sm rounded-cs btn-primary"><i class="bi bi-upload"></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
