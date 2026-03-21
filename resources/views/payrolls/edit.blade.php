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
                                Payrolls
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
                <h5 class="card-title">Create Payroll</h5>
            </div>
            <x-sweetalertsession />
            <div class="card-body">
                <form action="{{ route('payrolls.update', $payroll->id) }}" method="POST">
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
                                    {{ old('employee_id', $payroll->employee_id) == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->fullname }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="number" name="salary" id="salary"
                            class="form-control form-control-sm rounded-cs @error('salary') is-invalid @enderror"
                            value="{{ old('salary', $payroll->salary) }}" placeholder="Salary">
                        @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deductions" class="form-label">Deductions</label>
                        <input type="number" name="deductions" id="deductions"
                            class="form-control form-control-sm rounded-cs @error('deductions') is-invalid @enderror"
                            value="{{ old('deductions', $payroll->deductions) }}" placeholder="Deductions">
                        @error('deductions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bonuses" class="form-label">Bonuses</label>
                        <input type="number" name="bonuses" id="bonuses"
                            class="form-control form-control-sm rounded-cs @error('bonuses') is-invalid @enderror"
                            value="{{ old('bonuses', $payroll->bonuses) }}" placeholder="Bonuses">
                        @error('bonuses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="net_salary" class="form-label">Net Salary</label>
                        <input type="number" name="net_salary" id="net_salary"
                            class="form-control form-control-sm rounded-cs @error('net_salary') is-invalid @enderror"
                            value="{{ old('net_salary', $payroll->net_salary) }}" placeholder="Net Salary" disabled>
                        @error('net_salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pay_date" class="form-label">Pay Date</label>
                        <input type="text" name="pay_date" id="pay_date"
                            class="form-control form-control-sm rounded-cs date @error('pay_date') is-invalid @enderror"
                            value="{{ old('pay_date', $payroll->pay_date) }}" placeholder="Pay Date">
                        @error('pay_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <a href="{{ route('payrolls.index') }}" class="btn btn-sm rounded-cs btn-secondary"><i
                                class="bi bi-arrow-left"></i> Back to List</a>
                        <button type="submit" class="btn btn-sm rounded-cs btn-primary"><i class="bi bi-upload"></i>
                            Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
