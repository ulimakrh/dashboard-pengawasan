<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Itwil III Kemenlu</title>
    
    @vite('resources/css/app.css')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Custom scrollbar untuk tampilan yang lebih clean */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Select2 Dark Theme Customization */
        .select2-container--default .select2-selection--single {
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 0.75rem;
            height: 42px;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white;
            font-size: 11px;
            padding-left: 16px;
            padding-right: 32px;
            line-height: normal;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 12px;
        }
        .select2-dropdown {
            background-color: #0f172a;
            border: 1px solid #334155;
            border-radius: 0.75rem;
            overflow: hidden;
        }
        .select2-search--dropdown .select2-search__field {
            background-color: #1e293b;
            border: 1px solid #334155;
            color: white;
            border-radius: 0.5rem;
            padding: 6px 12px;
            font-size: 11px;
            outline: none;
        }
        .select2-results__option {
            color: white;
            font-size: 11px;
            padding: 8px 16px;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable,
        .select2-container--default .select2-results__option--selected {
            background-color: #1e293b;
            color: white;
        }
    </style>
</head>
<body class="bg-[#0f172a] text-white font-['Inter'] antialiased min-h-screen">

    <div class="max-w-7xl mx-auto px-6 py-10 md:px-10 md:py-12">
        
        @yield('content')

    </div>

    <footer class="max-w-7xl mx-auto px-10 py-10 border-t border-slate-900/50 text-center">
        <p class="text-slate-600 text-xs tracking-widest uppercase">
            &copy; 2026 Inspektorat Wilayah III Kemenlu &bull; Dashboard Satker
        </p>
    </footer>

    @if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#1e293b',
            color: '#ffffff',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    </script>
    @endif

    @stack('scripts')
    
    <script>
        $(document).ready(function() {
            function initSelect2() {
                $('.select2-searchable').select2({
                    width: '100%',
                    dropdownParent: $('body')
                });
            }
            initSelect2();

            // Re-initialize when modal opens to ensure width is calculated correctly
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === "class") {
                        let classList = mutation.target.className;
                        if(!classList.includes('hidden')) {
                            initSelect2();
                        }
                    }
                });
            });

            document.querySelectorAll('[id^="modal"]').forEach(modal => {
                observer.observe(modal, { attributes: true });
            });
        });
    </script>
</body>
</html>