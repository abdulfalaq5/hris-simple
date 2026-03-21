<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="{{ asset('mazer/dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

<!-- SweetAlert2 JS -->
<script src="{{ asset('mazer/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    window.locationAlert = {
        success(message = 'Anda berada di dalam radius kantor.') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: message,
                toast: false,
                position: 'center',
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-cs',
                    confirmButton: 'rounded-cs'
                }
            });
        },

        error(message = 'Anda berada di luar radius kantor.') {
            Swal.fire({
                icon: 'warning',
                title: 'Diluar Radius',
                text: message,
                toast: false,
                position: 'center',
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-cs',
                    confirmButton: 'rounded-cs'
                }
            });
        },

        failed(message = 'Tidak bisa mendapatkan lokasi Anda.') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: message,
                toast: false,
                position: 'center',
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-cs',
                    confirmButton: 'rounded-cs'
                }
            });
        },

        unsupported(message = 'Geolocation tidak didukung oleh browser ini.') {
            Swal.fire({
                icon: 'error',
                title: 'Unsupported',
                text: message,
                toast: false,
                position: 'center',
                showConfirmButton: true,
                customClass: {
                    popup: 'rounded-cs',
                    confirmButton: 'rounded-cs'
                }
            });
        }
    };
</script>


<style>
    .rounded-cs {
        border-radius: 10px !important;
    }
</style>
