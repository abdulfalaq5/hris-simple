<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="{{ asset('mazer/dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}" />

@props([
    'formId' => '',
    'title' => '',
    'text' => '',
    'icon' => '',
    'action' => '',
    'confirmText' => '',
    'cancelText' => '',
])

@php
    $defaults = [
        'delete' => [
            'title' => 'Delete Data?',
            'text' => 'Data will be permanently deleted.',
            'icon' => 'warning',
            'confirmText' => 'Yes, Delete!',
        ],
        'update' => [
            'title' => 'Update Data?',
            'text' => 'Data will be updated.',
            'icon' => 'question',
            'confirmText' => 'Yes, Update',
        ],
    ];

    $config = $defaults[$action];

    $final = [
        'title' => trim($title) !== '' ? $title : $config['title'],
        'text' => trim($text) !== '' ? $text : $config['text'],
        'icon' => trim($icon) !== '' ? $icon : $config['icon'],
        'confirmText' => trim($confirmText) !== '' ? $confirmText : $config['confirmText'],
        'cancelText' => trim($cancelText) !== '' ? $cancelText : 'Cancel',
    ];
@endphp

<!-- SweetAlert2 JS -->
<script src="{{ asset('mazer/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        $(document).on('click', '[data-swal-form-id="{{ $formId }}"]', function(e) {
            e.preventDefault();

            const form = $('#' + $(this).data('swal-form-id'));

            Swal.fire({
                title: {!! json_encode($final['title']) !!},
                text: {!! json_encode($final['text']) !!},
                icon: {!! json_encode($final['icon']) !!},
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: {!! json_encode($final['confirmText']) !!},
                cancelButtonText: {!! json_encode($final['cancelText']) !!},
                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    htmlContainer: 'custom-swal-text',
                    confirmButton: 'custom-swal-confirm',
                    cancelButton: 'custom-swal-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

<style>
    .custom-swal-popup {
        border-radius: 10px !important;
    }

    .custom-swal-title {
        font-size: 16px !important;
    }

    .custom-swal-text {
        font-size: 14px !important;
    }

    .custom-swal-confirm,
    .custom-swal-cancel {
        border-radius: 10px !important;
        font-size: 14px !important;
        padding: 6px 12px !important;
    }
</style>
