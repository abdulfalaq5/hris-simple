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
                                Show
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
                {{-- <h5 class="card-title">Detail Payroll</h5> --}}
            </div>
            <x-sweetalertsession />
            <div class="card-body">
                <div id="print-area">
                    <h4 class="text-center mb-4">Payroll Slip, {{ $payroll->fullname ?? '-' }}</h4>

                    <div class="table-responsive">
                        <table class="table table-bordered w-100">
                            <tbody>
                                <tr>
                                    <th width="30%">Employee</th>
                                    <td>{{ $payroll->fullname ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Salary</th>
                                    <td>{{ number_format($payroll->salary) }}</td>
                                </tr>
                                <tr>
                                    <th>Bonuses</th>
                                    <td>{{ number_format($payroll->bonuses) }}</td>
                                </tr>
                                <tr>
                                    <th>Deductions</th>
                                    <td>{{ number_format($payroll->deductions) }}</td>
                                </tr>
                                <tr>
                                    <th>Net Salary</th>
                                    <td>{{ number_format($payroll->net_salary) }}</td>
                                </tr>
                                <tr>
                                    <th>Pay Date</th>
                                    <td>{{ \Carbon\Carbon::parse($payroll->pay_date)->translatedFormat('d F Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-5">
                        <p class="mb-5 me-3">Authorized Signature</p>
                        <p>_________________________</p>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('payrolls.index') }}" class="btn btn-sm rounded-cs btn-secondary me-2">
                            <i class="bi bi-arrow-left"></i>
                            <span>Back to List</span>
                        </a>
                        <button type="button" id="btn-print" class="btn btn-sm rounded-cs btn-primary">
                            <i class="bi bi-cash"></i>
                            <span>Print Payroll</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('#btn-print').click(function() {
            const printContents = $('#print-area').html();
            const printWindow = window.open('', '', 'height=600,width=800');

            printWindow.document.write(`
        <html>
            <head>
                <title>Print Payroll</title>
                <link rel="stylesheet" href="{{ asset('css/app.css') }}">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #000;
                        padding: 8px;
                        text-align: left;
                    }
                    h4 {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .text-end {
                        text-align: right;
                    }
                    .mt-5 {
                        margin-top: 5rem;
                    }
                    .mb-5 {
                        margin-bottom: 3rem;
                    }
                    .me-3 {
                        margin-right: 1rem;
                    }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        });
    </script>
@endpush
