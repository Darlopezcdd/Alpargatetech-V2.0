@php

    $getImg = function ($filename) {
        $path = base_path("img/{$filename}");
        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        return '';
    };

    $heroBg = $getImg('Salon-Principal.jpeg');
    $imgLogo = $getImg('logo-apargate3.jpeg');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Alpargate 3</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#010101',
                            gold: '#D9BFA2',
                            red: '#A53534',
                            white: '#FEFEFE',
                            gray: '#3D3B3B'
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Figtree', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoom-in-slow {
            from {
                opacity: 0;
                transform: scale(1.05);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slide-in-right {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-zoom-in {
            animation: zoom-in-slow 1.5s ease-out forwards;
        }

        .animate-slide-in {
            animation: slide-in-right 0.5s ease-out forwards;
        }

        .animate-progress {
            animation: shrink 6s linear forwards;
        }


        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #D9BFA2;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #A53534;
        }
    </style>
</head>

<body class="h-screen flex items-center justify-center p-4 bg-brand-dark font-sans overflow-hidden relative">

    <a href="/"
        class="absolute top-6 left-6 z-50 flex items-center gap-2 px-6 py-3 bg-black/30 hover:bg-brand-red backdrop-blur-md rounded-full text-white transition-all duration-300 group shadow-lg border border-white/10 hover:scale-105 hover:shadow-brand-red/30">
        <svg class="w-4 h-4 text-brand-gold group-hover:text-white transition-colors" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
            </path>
        </svg>
        <span
            class="font-serif text-xs tracking-widest uppercase font-bold text-brand-gold group-hover:text-white transition-colors">Volver</span>
    </a>

    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-4 w-full max-w-sm pointer-events-none">
    </div>

    <div class="absolute top-0 w-full h-full bg-center bg-cover z-0 animate-zoom-in"
        style="background-image: url('{{ $heroBg }}');">
        <div class="w-full h-full absolute bg-black/60 backdrop-blur-[4px]"></div>
    </div>


    <div
        class="max-w-md w-full bg-brand-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden z-10 animate-fade-in-up border border-white/20 relative">

        <div class="h-2 w-full bg-gradient-to-r from-brand-red via-brand-gold to-brand-red"></div>

        <div class="px-8 py-10 md:px-10">

            <div class="text-center mb-8">
                @if(!empty($imgLogo))
                    <img src="{{ $imgLogo }}" alt="Logo"
                        class="h-20 w-auto mx-auto mb-4 object-contain drop-shadow-xl hover:scale-105 transition-transform duration-500">
                @endif
                <h2 class="text-3xl font-bold text-brand-dark font-serif tracking-tight">Alpargate 3</h2>
                <p class="text-brand-gold font-bold text-xs tracking-[0.2em] uppercase mt-2">Sabor Auténtico</p>
            </div>

            @if(session('status'))
                <div class="mb-6 bg-green-50 border-l-4 border-brand-gold text-green-800 p-4 rounded text-sm shadow-sm"
                    role="alert">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                @csrf

                <div class="group">
                    <label for="email"
                        class="block text-xs font-bold text-brand-gray uppercase tracking-wider mb-2">Correo
                        Electrónico</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-brand-gold transition-colors" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email') }}"
                            class="appearance-none block w-full pl-10 pr-4 py-3 border {{ $errors->has('email') ? 'border-brand-red bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-gold/50 focus:border-brand-gold focus:bg-white text-brand-dark transition-all duration-300 sm:text-sm shadow-inner"
                            placeholder="ejemplo@correo.com">
                    </div>
                </div>

                <div class="group">
                    <label for="password"
                        class="block text-xs font-bold text-brand-gray uppercase tracking-wider mb-2">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-brand-gold transition-colors" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full pl-10 pr-10 py-3 border {{ $errors->has('password') ? 'border-brand-red bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-gold/50 focus:border-brand-gold focus:bg-white text-brand-dark transition-all duration-300 sm:text-sm shadow-inner"
                            placeholder="••••••••">

                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-brand-red focus:outline-none transition-colors duration-200">
                            <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-off-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M5.37 5.37L18.63 18.63M9.88 9.88a3 3 0 104.24 4.24" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="font-medium text-brand-red hover:text-brand-dark transition-colors duration-300 text-xs">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" id="submitBtn"
                        class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-full shadow-lg text-sm font-bold text-white bg-gradient-to-r from-brand-red to-[#C81E1E] hover:from-[#C81E1E] hover:to-brand-red focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red hover:-translate-y-0.5 hover:shadow-xl transition-all duration-300 uppercase tracking-widest">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-50 py-4 border-t border-gray-100 text-center">
            <span class="text-xs text-brand-gray/60 font-light">© {{ date('Y') }} Alpargate 3. Todos los derechos
                reservados.</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hasErrors = @json($errors->any());

            const ATTEMPTS_KEY = 'alpargate_login_attempts';
            const LOCKOUT_KEY = 'alpargate_lockout_time';

            let attempts = parseInt(localStorage.getItem(ATTEMPTS_KEY) || '0');
            const submitBtn = document.getElementById('submitBtn');

            checkLockout();

            if (hasErrors) {
                attempts++;
                localStorage.setItem(ATTEMPTS_KEY, attempts);

                if (attempts >= 4) {
                    setLockout();
                    showToast('error', 'Acceso Bloqueado', 'Has superado el límite de intentos.<br>Sistema bloqueado por 5 segundos.', true);
                } else {
                    const intentosRestantes = 4 - attempts;
                    showToast('error', 'Credenciales Incorrectas', `Correo o contraseña inválidos.<br>Te quedan <b>${intentosRestantes}</b> intentos.`);
                }
            }

            function checkLockout() {
                const lockoutTime = localStorage.getItem(LOCKOUT_KEY);
                if (lockoutTime) {
                    const now = new Date().getTime();
                    if (now < parseInt(lockoutTime)) {
                        disableForm();
                    } else {
                        localStorage.removeItem(LOCKOUT_KEY);
                        localStorage.setItem(ATTEMPTS_KEY, '0');
                        attempts = 0;
                        enableForm();
                    }
                }
            }

            function setLockout() {
                const lockoutDuration = 5000;
                const expirationTime = new Date().getTime() + lockoutDuration;
                localStorage.setItem(LOCKOUT_KEY, expirationTime);
                disableForm();
            }

            function disableForm() {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed', 'from-gray-400', 'to-gray-500');
                submitBtn.classList.remove('from-brand-red', 'to-[#C81E1E]', 'hover:translate-y-0.5');
                submitBtn.innerHTML = 'Bloqueado Temporalmente';
            }

            function enableForm() {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'from-gray-400', 'to-gray-500');
                submitBtn.classList.add('from-brand-red', 'to-[#C81E1E]');
                submitBtn.innerHTML = 'Iniciar Sesión';
            }

            function showToast(type, title, message, persistent = false) {
                const container = document.getElementById('toast-container');
                const toast = document.createElement('div');
                toast.className = `bg-white border-l-4 border-brand-red shadow-2xl rounded-r-lg p-4 flex items-start gap-3 pointer-events-auto transform translate-x-full animate-slide-in relative overflow-hidden w-full`;

                toast.innerHTML = `
                    <div class="text-brand-red flex-shrink-0 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-serif font-bold text-brand-dark text-sm">${title}</h3>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">${message}</p>
                    </div>
                    ${!persistent ? `
                    <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-brand-red transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="absolute bottom-0 left-0 h-1 bg-brand-red/10 w-full"><div class="h-full bg-brand-red animate-progress"></div></div>
                    ` : ''}
                `;
                container.appendChild(toast);
                if (!persistent) {
                    setTimeout(() => {
                        toast.style.transform = 'translateX(120%)';
                        toast.style.transition = 'transform 0.5s ease-in';
                        setTimeout(() => toast.remove(), 500);
                    }, 6000);
                }
            }


            setInterval(checkLockout, 1000);
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>

</html>