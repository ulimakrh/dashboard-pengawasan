<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Itwil III Kemenlu</title>
    
    @vite('resources/css/app.css')
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Custom scrollbar untuk tampilan yang lebih clean */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
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
</body>
</html>