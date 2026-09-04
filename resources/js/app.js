import '../css/app.css';
import $ from 'jquery';
import 'datatables.net';
import 'select2';
import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

window.$ = window.jQuery = $;
window.Swal = window.swal = Swal;
window.Alpine = Alpine;
Alpine.start();

$(document).ready(function () {
    // DataTables
    $('.datatable').each(function () {
        $(this).DataTable({
            pageLength: 15,
            responsive: true,
            order: [],
            language: {
                ...(window.__qms_locale === 'bn'
                    ? { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/bn.json' }
                    : {}),
                paginate: {
                    next: '<i class="fa-solid fa-angle-right"></i>',
                    previous: '<i class="fa-solid fa-angle-left"></i>',
                },
            },
        });
    });

    // Select2
    $('.select2').each(function () {
        $(this).select2({
            placeholder: $(this).data('placeholder') || '—',
        });
    });

    // Flash message toasts (set on body via data-flash-*)
    const flash = {
        success: $('body').data('flash-success'),
        error: $('body').data('flash-error'),
        warning: $('body').data('flash-warning'),
    };
    [
        ['success', 'success', '#15803d'],
        ['error', 'error', '#be123c'],
        ['warning', 'warning', '#b45309'],
    ].forEach(([key, icon, color]) => {
        if (flash[key]) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon,
                title: flash[key],
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                iconColor: color,
            });
        }
    });

    // Delete confirmation
    $(document).on('submit', '.form-delete', function (e) {
        e.preventDefault();
        const form = this;
        Swal.fire({
            title: window.__qms_translate?.confirmDelete ?? 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#be123c',
            cancelButtonColor: '#6b7280',
            confirmButtonText: window.__qms_translate?.yes ?? 'Yes',
            cancelButtonText: window.__qms_translate?.cancel ?? 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});