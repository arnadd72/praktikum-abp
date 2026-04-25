<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sembako Berkah Raya - Premium Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .gradient-text {
            background-image: linear-gradient(135deg, #059669 0%, #10B981 50%, #34D399 100%);
            -webkit-background-clip: text;
            color: transparent;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #064E3B 0%, #059669 100%);
        }

        .floating-blob {
            position: absolute;
            filter: blur(80px);
            opacity: 0.15;
            z-index: -1;
            animation: float 10s ease-in-out infinite alternate;
        }

        @keyframes float {
            0% { transform: translateY(0px) scale(1); }
            100% { transform: translateY(-50px) scale(1.1); }
        }

        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(5, 150, 105, 0.25);
            border-color: rgba(16, 185, 129, 0.4);
        }

        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }
        .btn-hover-effect::after {
            content: "";
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease-in-out;
        }
        .btn-hover-effect:hover::after {
            left: 100%;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-[#F8FAFC] relative overflow-x-hidden">
    
    <!-- Background Decorators -->
    <div class="floating-blob w-96 h-96 bg-green-500 rounded-full top-[-10%] left-[-10%]"></div>
    <div class="floating-blob w-[500px] h-[500px] bg-emerald-400 rounded-full top-[20%] right-[-15%]" style="animation-delay: -5s;"></div>
    
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                <div class="flex justify-between h-20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-green-400 flex items-center justify-center shadow-lg shadow-green-200">
                            <span class="text-white text-xl">🛒</span>
                        </div>
                        <span class="text-2xl font-bold font-heading text-gray-900 tracking-tight">Sembako<span class="text-emerald-600">Berkah</span></span>
                    </div>
                    <div class="flex items-center space-x-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-emerald-600 transition-colors">Masuk Dasbor</a>
                            @else
                                <a href="{{ route('login') }}" class="font-medium text-gray-500 hover:text-gray-900 transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn-hover-effect px-5 py-2.5 font-semibold text-white bg-gradient-primary rounded-full transition shadow-lg shadow-green-900/20 hover:shadow-green-900/40">Register Sekarang</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-grow pt-32 lg:pt-40 pb-16 relative z-10 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold mb-6 animate-pulse">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sistem Manajemen Berbasis Web
                    </div>
                    
                    <h1 class="font-heading text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight leading-[1.1] text-gray-900 mb-6">
                        Kelola Stok <br/>
                        <span class="gradient-text">Gudang Sembako</span> <br/>
                        Tanpa Ribet.
                    </h1>
                    
                    <p class="text-lg sm:text-xl text-gray-500 leading-relaxed max-w-2xl mx-auto lg:mx-0 mb-10">
                        Pantau inventaris beras, gula, minyak goreng, dan stok harian secara _real-time_. Antarmuka elegan, responsif, dan ultra cepat yang mendigitalkan seluruh pencatatan bisnis Anda.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-hover-effect w-full sm:w-auto px-8 py-4 bg-gradient-primary text-white font-semibold rounded-2xl shadow-xl shadow-emerald-500/30 hover:scale-105 transition-transform">
                                Akses Dasbor Utama
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-hover-effect w-full sm:w-auto px-8 py-4 bg-gray-900 text-white font-semibold rounded-2xl shadow-xl shadow-gray-900/20 hover:bg-gray-800 transition-colors">
                                Mulai Gratis Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-gray-900 font-semibold rounded-2xl border border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition-all">
                                Admin Log in 
                            </a>
                        @endauth
                    </div>
                    
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-6 text-sm font-medium text-gray-400">
                        <div class="flex items-center gap-2"><svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Tanpa Instalasi</div>
                        <div class="flex items-center gap-2"><svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Aman & Enkripsi</div>
                        <div class="flex items-center gap-2"><svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> UI Premium</div>
                    </div>
                </div>

                <div class="flex-1 w-full max-w-2xl relative mt-10 lg:mt-0">
                    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-200 to-green-100 rounded-[2.5rem] transform rotate-3 scale-105 opacity-50"></div>
                    <div class="relative bg-white/60 backdrop-blur-md border border-white p-2 rounded-[2.5rem] shadow-2xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1604719312566-8912e9227c6a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Groceries Premium" class="w-full h-[500px] object-cover rounded-[2rem]">
                        
                        <!-- Floating Glass Card -->
                        <div class="absolute bottom-10 left-10 right-10 bg-white/80 backdrop-blur-xl border border-white/40 p-5 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)]">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wide">Status Inventaris</p>
                                    <p class="font-heading font-bold text-gray-900 mt-1">Stok Aman Tersedia</p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Features Banner -->
        <section class="bg-white border-t border-gray-100 py-20 relative z-10">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="font-heading text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Esensial Untuk Bisnis Sembako Raya</h2>
                    <p class="text-gray-500 text-lg">Tinggalkan buku catatan fisik. Kami merancang struktur data terpadu untuk efisiensi waktu operasional gudang Anda.</p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white border border-gray-100 rounded-3xl p-8 hover:bg-emerald-50/50">
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-green-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-emerald-200">
                            📊
                        </div>
                        <h3 class="font-heading text-xl font-bold text-gray-900 mb-3">Pendataan Cepat CRUD</h3>
                        <p class="text-gray-500 leading-relaxed">Tambah, edit, hingga hapus data produk sembako langsung dengan _feedback_ interaktif berbasis Tailwind CSS.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="feature-card bg-white border border-gray-100 rounded-3xl p-8 hover:bg-emerald-50/50">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-blue-200">
                            🔐
                        </div>
                        <h3 class="font-heading text-xl font-bold text-gray-900 mb-3">Sistem Otorisasi Solid</h3>
                        <p class="text-gray-500 leading-relaxed">Dibentengi oleh sistem Auth otentik dari *Laravel Breeze*, menjamin keamanan informasi bisnis tak akan bocor ke publik.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card bg-white border border-gray-100 rounded-3xl p-8 hover:bg-emerald-50/50">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 shadow-lg shadow-orange-200">
                            ⚡
                        </div>
                        <h3 class="font-heading text-xl font-bold text-gray-900 mb-3">Antarmuka Premium Modern</h3>
                        <p class="text-gray-500 leading-relaxed">Nikmati tata letak (_layout_) yang estetik, ringan, dinamis, serta 100% Mobile Friendly untuk manajer yang mobilitas tinggi.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</body>
</html>
