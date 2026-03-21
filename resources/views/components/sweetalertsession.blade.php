<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="{{ asset('mazer/dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

<!-- SweetAlert2 JS -->
<script src="{{ asset('mazer/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000,
            position: 'top-end',
            toast: true,
            customClass: {
                popup: 'rounded-cs',
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 2000,
            position: 'top-end',
            toast: true,
            customClass: {
                popup: 'rounded-cs',
            }
        });
    </script>
@endif

<style>
    .rounded-cs {
        border-radius: 10px !important;
    }
</style>
