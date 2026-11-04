const io = new IntersectionObserver((entries) => {
  entries.forEach((e) => {
    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
  });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach((el) => io.observe(el));

(function () {
    var primary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#7c3aed';

    // ---------- SELECT2 ----------
    // Semua <select> kecuali yang kecil (form-select-sm, mis. status lead) atau bertanda data-no-select2
    if (window.jQuery && jQuery.fn.select2) {
        jQuery('select:not(.form-select-sm):not([data-no-select2])').each(function () {
            jQuery(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                minimumResultsForSearch: 0, // kotak pencarian selalu tampil
                language: {
                    noResults: function () { return 'Tidak ditemukan'; },
                    searching: function () { return 'Mencari...'; }
                }
            });
        });
    }

    // ---------- KONFIRMASI ----------
    // Ubah onsubmit="return confirm('...')" lama menjadi data-confirm
    document.querySelectorAll('form[onsubmit*="confirm("]').forEach(function (f) {
        var m = f.getAttribute('onsubmit').match(/confirm\((['"])(.*?)\1\)/);
        if (m) f.dataset.confirm = m[2];
        f.removeAttribute('onsubmit');
    });

    // Form DELETE atau yang punya data-confirm akan ditahan dulu
    document.addEventListener('submit', function (e) {
        var f = e.target;
        var isDelete = f.querySelector('input[name="_method"][value="DELETE"]');
        var msg = f.dataset.confirm;
        if (!msg && !isDelete) return;

        e.preventDefault();
        Swal.fire({
            icon: isDelete ? 'warning' : 'question',
            title: f.dataset.title || (isDelete ? 'Hapus data ini?' : 'Lanjutkan?'),
            text: msg || 'Tindakan ini tidak bisa dibatalkan.',
            showCancelButton: true,
            confirmButtonText: f.dataset.ok || (isDelete ? 'Ya, hapus' : 'Ya, lanjutkan'),
            cancelButtonText: 'Batal',
            confirmButtonColor: isDelete ? '#dc2626' : primary,
            cancelButtonColor: '#71717a',
            reverseButtons: true,
            focusCancel: !!isDelete
        }).then(function (r) {
            if (r.isConfirmed) f.submit(); // submit() tidak memicu event lagi
        });
    });

    // ---------- TOAST ----------
    if (window.__flash) {
        Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: window.__flash.icon === 'error' ? 6000 : 3000,
            timerProgressBar: true
        }).fire(window.__flash);
    }
})();