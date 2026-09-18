<?php
// TezMind.uz - Qora Tuynuk Simulyatsiyasi
// Ushbu fayl serverda index.php sifatida ishlashiga mo'ljallangan
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qora Tuynuk - TezMind.uz</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Premium Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600&family=Space+Grotesk:wght@300;400;600;700;750&display=swap" rel="stylesheet">
    
    <!-- Three.js & Loaders -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    
    <!-- MediaPipe -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body, html {
            margin: 0; padding: 0; width: 100%;
            background-color: #000000; color: #e5e5e5;
            scroll-behavior: smooth; overflow-x: hidden;
        }

        /* Fixed Navigation offset for smooth scrolling */
        section, .scroll-section {
            scroll-margin-top: 100px;
        }

        /* --- O'TA PROFESSIONAL BOUNCING & BLUR ANIMATION --- */
        .reveal-bounce {
            opacity: 0;
            transform: translateY(120px) scale(0.7);
            filter: blur(20px);
            transition: all 0s; 
        }

        .reveal-bounce.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
            transition: opacity 0.8s ease-out, 
                        transform 1.2s cubic-bezier(0.34, 1.56, 0.64, 1), 
                        filter 1s ease-out, 
                        box-shadow 1.2s ease-out;
        }

        .delay-100 { transition-delay: 0.1s !important; }
        .delay-200 { transition-delay: 0.2s !important; }
        .delay-300 { transition-delay: 0.3s !important; }

        /* --- REALISTIK SHISHA (ULTRA GLASSMORPHISM) --- */
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.01) 100%);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            border-radius: 32px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.5s ease, box-shadow 0.5s ease;
        }

        .glass-nav {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(255, 255, 255, 0.3);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8), 0 0 40px rgba(139, 92, 246, 0.2);
        }

        .glass-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(255, 255, 255, 0.06), transparent 40%);
            z-index: 0; opacity: 0; transition: opacity 0.5s; pointer-events: none;
        }
        .bento-content { position: relative; z-index: 1; }

        .text-gradient {
            background: linear-gradient(180deg, #FFFFFF 0%, rgba(255, 255, 255, 0.3) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .brand-gradient {
            background: linear-gradient(to right, #3b82f6, #a855f7, #ec4899);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        .bg-glow {
            position: absolute; border-radius: 50%; filter: blur(100px); z-index: -1; pointer-events: none;
        }

        /* Cinematic Button */
        .btn-cinematic {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff; backdrop-filter: blur(20px);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative; overflow: hidden;
        }
        .btn-cinematic::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: translateX(-100%); transition: transform 0.6s ease;
        }
        .btn-cinematic:hover {
            background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.5);
            transform: scale(1.05) translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.8), 0 0 30px rgba(59,130,246,0.5);
        }
        .btn-cinematic:hover::after { transform: translateX(100%); }

        /* --- SITE TRANSITIONS --- */
        #site-wrapper {
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: center top;
        }
        #site-wrapper.hidden-state {
            opacity: 0; transform: scale(0.9) translateY(-50px); filter: blur(20px); pointer-events: none;
        }

        /* --- SIMULATION STYLES --- */
        #sim-frame {
            position: relative; width: 100%; height: 600px;
            border-radius: 32px; overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            background: #000; z-index: 10;
        }

        #webgl-container {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1; opacity: 0; pointer-events: none; transition: opacity 1s ease;
        }
        #webgl-container.active-sim { opacity: 1; pointer-events: auto; }

        #output_canvas {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 2; pointer-events: none; transform: scaleX(-1);
            opacity: 0; transition: opacity 1s ease;
        }
        #output_canvas.active-sim { opacity: 1; }

        #video { display: none; }

        #ui-layer {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 10000; pointer-events: none; display: flex;
            flex-direction: column; justify-content: space-between;
            padding: 2.5rem; box-sizing: border-box;
            opacity: 0; transition: opacity 1s ease;
        }
        #ui-layer.active-sim { opacity: 1; pointer-events: auto; }

        .sim-glass-panel {
            background: rgba(5, 5, 5, 0.5); backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 1.5rem;
        }

        .status-dot {
            width: 10px; height: 10px; border-radius: 50%; background-color: #ff3b30;
            box-shadow: 0 0 15px #ff3b30; transition: all 0.2s ease;
        }
        .status-dot.active { background-color: #34c759; box-shadow: 0 0 20px #34c759; }
        .status-dot.tracking { background-color: #0a84ff; box-shadow: 0 0 20px #0a84ff; }
        .status-dot.pinching { background-color: #bf5af2; box-shadow: 0 0 20px #bf5af2; }
        .status-dot.zooming { background-color: #ff9f0a; box-shadow: 0 0 20px #ff9f0a; }

        #loading-screen {
            position: fixed; inset: 0; background: #000000; z-index: 10001;
            display: none; flex-direction: column; align-items: center;
            justify-content: center; transition: opacity 0.8s ease;
        }

        .loader-ring {
            width: 70px; height: 70px; border: 3px solid transparent;
            border-top-color: #3b82f6; border-right-color: #a855f7;
            border-radius: 50%; animation: spin 1s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
            margin-bottom: 2rem;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Custom Alert */
        #custom-alert {
            position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-100px);
            background: rgba(220, 38, 38, 0.9); backdrop-filter: blur(10px);
            color: white; padding: 1rem 2rem; border-radius: 12px; z-index: 99999;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: 'Space Grotesk', sans-serif;
            display: flex; align-items: center; gap: 10px;
        }
        #custom-alert.show {
            transform: translateX(-50%) translateY(0);
        }
    </style>
</head>
<body>

    <!-- Xato haqida ogohlantirish (Custom Alert) -->
    <div id="custom-alert">
        <i data-lucide="alert-triangle"></i>
        <span id="alert-message">Kameraga ruxsat berilmadi!</span>
    </div>

    <!-- Kosmik Orqa Fon Nurlari -->
    <div class="bg-glow w-[800px] h-[800px] top-[-20%] left-[-10%] bg-purple-900/20"></div>
    <div class="bg-glow w-[600px] h-[600px] top-[40%] right-[-10%] bg-blue-900/10"></div>
    <div class="bg-glow w-[900px] h-[900px] bottom-0 left-[10%] bg-indigo-900/10"></div>

    <!-- ================= ASOSIY SAYT ================= -->
    <div id="site-wrapper" class="relative z-20 pb-10">
        
        <!-- YUKORI MENYU (NAVBAR) -->
        <nav class="fixed top-0 left-0 w-full px-6 py-4 flex justify-between items-center z-50 glass-nav reveal-bounce">
            <div class="flex items-center gap-3 cursor-pointer" onclick="window.scrollTo(0,0)">
                <i data-lucide="hurricane" class="w-8 h-8 text-white"></i>
                <div class="font-display font-bold text-2xl tracking-widest text-white">QORA <span class="text-gray-500">TUYNUK</span></div>
            </div>
            
            <!-- Linklar -->
            <div class="hidden md:flex gap-8 items-center">
                <a href="#header" class="text-xs font-display font-bold tracking-[0.2em] text-gray-400 hover:text-white uppercase transition-colors">Asosiy</a>
                <a href="#definition" class="text-xs font-display font-bold tracking-[0.2em] text-gray-400 hover:text-white uppercase transition-colors">Ta'rif</a>
                <a href="#anatomy" class="text-xs font-display font-bold tracking-[0.2em] text-gray-400 hover:text-white uppercase transition-colors">Anatomiya</a>
                <a href="#simulation" class="text-xs font-display font-bold tracking-[0.2em] text-blue-400 hover:text-blue-300 uppercase transition-colors border border-blue-500/30 px-4 py-2 rounded-full bg-blue-500/10">Boshqaruv</a>
            </div>

            <div class="font-display font-bold text-lg tracking-[0.2em] uppercase brand-gradient">
                TezMind.uz
            </div>
        </nav>

        <!-- Hero Section -->
        <header id="header" class="min-h-screen flex flex-col justify-center items-center text-center px-6 relative scroll-section">
            <div class="reveal-bounce delay-100 mt-20">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card !p-3 !rounded-full mb-8">
                    <i data-lucide="sparkles" class="w-4 h-4 text-purple-400"></i>
                    <span class="font-display text-xs tracking-[0.3em] text-gray-300 uppercase">Koinot Sirlari</span>
                </div>
                <h1 class="font-display text-6xl md:text-[9rem] font-bold tracking-tighter leading-none mb-8 text-gradient">
                    SINGULYARLIK
                </h1>
            </div>
            
            <p class="max-w-3xl text-lg md:text-2xl text-gray-400 font-light leading-relaxed reveal-bounce delay-200">
                Fazo va vaqtning eng sirli hamda qo'rqinchli hududi. Bu yerda gravitatsion maydon shu qadar qudratliki, koinotdagi eng tez zarracha bo'lmish yorug'lik ham uning changalidan qochib qutula olmaydi.
            </p>
            
            <div class="absolute bottom-10 flex flex-col items-center gap-4 reveal-bounce delay-300">
                <i data-lucide="mouse" class="w-6 h-6 text-gray-500 animate-bounce"></i>
                <div class="w-[1px] h-12 bg-gradient-to-b from-gray-500 to-transparent"></div>
            </div>
        </header>

        <!-- Asosiy Ma'lumotlar -->
        <main class="max-w-[1400px] mx-auto px-6 space-y-12">
            
            <!-- Grid 1: Ta'rif -->
            <div id="definition" class="grid grid-cols-1 lg:grid-cols-3 gap-8 scroll-section">
                <div class="glass-card bento-card lg:col-span-2 reveal-bounce" onmousemove="handleMouseMove(event)">
                    <div class="bento-content flex flex-col justify-between h-full">
                        <i data-lucide="atom" class="w-12 h-12 text-blue-400 mb-8"></i>
                        <div>
                            <h2 class="font-display text-4xl md:text-5xl font-bold mb-6 tracking-tight text-white">Shakllanish Jarayoni</h2>
                            <p class="text-gray-400 text-lg leading-relaxed mb-4">
                                Qora tuynuklar — koinotdagi o'ta ulkan yulduzlarning evolyutsion yakuni hisoblanadi. Yulduz o'z yadrosidagi termoyadroviy yoqilg'ini to'liq sarflab bo'lgach, uni ushlab turuvchi ichki bosim yo'qoladi.
                            </p>
                            <p class="text-gray-400 text-lg leading-relaxed">
                                Shundan so'ng, yulduz o'zining dahshatli gravitatsiyasi ta'sirida mislsiz tezlikda ichkariga qarab qulay boshlaydi. Agar qolgan massa yetarlicha katta bo'lsa, u cheksiz zichlikka ega bo'lgan mutlaq tuynukka aylanadi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="glass-card bento-card reveal-bounce delay-100" onmousemove="handleMouseMove(event)">
                    <div class="bento-content">
                        <i data-lucide="telescope" class="w-12 h-12 text-purple-400 mb-6"></i>
                        <h3 class="font-display text-3xl font-bold mb-4 text-white">M87* Mo'jizasi</h3>
                        <p class="text-gray-400 leading-relaxed mb-8">
                            Insoniyat tarixida ilk bor 2019-yilda M87 galaktikasi markazidagi o'ta massiv qora tuynuk tasvirga olindi. Uning massasi Quyoshimizdan 6.5 milliard marta katta!
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grid 2: Anatomiya -->
            <div id="anatomy" class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-10 scroll-section">
                <div class="col-span-1 md:col-span-3 reveal-bounce">
                    <h2 class="font-display text-5xl font-bold tracking-tight text-white mb-4 text-center">Anatomiya</h2>
                </div>

                <div class="glass-card bento-card reveal-bounce" onmousemove="handleMouseMove(event)">
                    <div class="bento-content">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mb-6 border border-white/10">
                            <i data-lucide="circle-dashed" class="w-8 h-8 text-orange-400"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold mb-3 text-white">Hodisalar Ufqi</h3>
                        <p class="text-gray-400 leading-relaxed">
                            Mutlaq chegara. Bu chiziqdan ichkariga o'tgan har qanday modda uchun qaytish yo'li yopiladi. U yerdan yorug'lik ham qaytib chiqolmaydi.
                        </p>
                    </div>
                </div>

                <div class="glass-card bento-card reveal-bounce delay-100" onmousemove="handleMouseMove(event)">
                    <div class="bento-content">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mb-6 border border-white/10">
                            <i data-lucide="disc-3" class="w-8 h-8 text-blue-400"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold mb-3 text-white">Akkretsiya Diski</h3>
                        <p class="text-gray-400 leading-relaxed">
                            Tuynuk yutayotgan plazmadan iborat aylanuvchi gardish. Gravitatsiya ishqalanishi tufayli disk o'ta yuqori haroratgacha qiziydi va charaqlab yonadi.
                        </p>
                    </div>
                </div>

                <div class="glass-card bento-card reveal-bounce delay-200" onmousemove="handleMouseMove(event)">
                    <div class="bento-content">
                        <div class="w-16 h-16 rounded-2xl bg-white/5 flex items-center justify-center mb-6 border border-white/10">
                            <i data-lucide="target" class="w-8 h-8 text-red-400"></i>
                        </div>
                        <h3 class="font-display text-2xl font-bold mb-3 text-white">Singulyarlik</h3>
                        <p class="text-gray-400 leading-relaxed">
                            Markazdagi cheksiz zichlikka ega nuqta. Bu yerda millionlab yulduzlarning massasi nol hajmga siqiladi va barcha fizika qonunlari ishdan chiqadi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grid 3: Qiziqarli Faktlar -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-10">
                <div class="glass-card bento-card reveal-bounce" onmousemove="handleMouseMove(event)">
                    <div class="bento-content">
                        <i data-lucide="clock" class="w-12 h-12 text-white mb-6"></i>
                        <h3 class="font-display text-3xl font-bold mb-4 text-white">Vaqt Sekinlashishi</h3>
                        <p class="text-gray-400 text-lg leading-relaxed">
                            Eynshteyn kashfiyotiga ko'ra, gravitatsiya qanchalik kuchli bo'lsa, vaqt shunchalik sekin o'tadi. Qora tuynuk yaqiniga borgan inson uchun bir necha soat, Yerdagilar uchun yuzlab yillarga aylanib ketadi. Siz ufgga yaqinlashganingiz sari uzoqdagi kuzatuvchi sizni "qotib qolgan" deb o'ylaydi.
                        </p>
                    </div>
                </div>

                <div class="glass-card bento-card reveal-bounce delay-100" onmousemove="handleMouseMove(event)">
                    <div class="bento-content">
                        <i data-lucide="split-square-vertical" class="w-12 h-12 text-white mb-6"></i>
                        <h3 class="font-display text-3xl font-bold mb-4 text-white">Spagettilashish</h3>
                        <p class="text-gray-400 text-lg leading-relaxed">
                            Astrofizikada bu "Spaghettification" deb ataladi. Obyekt tuynukka yaqinlashganda, uning pastki va yuqori qismlariga ta'sir qiladigan tortishish kuchi orasidagi farq shu qadar kattalashadiki, obyekt xuddi makaron (spagetti) kabi uzunasiga cho'zilib, parchalanib ketadi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Interaktiv Simulyatsiya Frame (Tugma va 3D) -->
            <div id="simulation" class="glass-card bento-card p-4 md:p-10 mt-20 reveal-bounce scroll-section" onmousemove="handleMouseMove(event)">
                <div class="bento-content flex flex-col items-center">
                    
                    <div class="w-full mb-12 text-center mt-4">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-blue-500/30 bg-blue-500/10 mb-6">
                            <i data-lucide="cpu" class="w-4 h-4 text-blue-400"></i>
                            <span class="font-display text-xs tracking-widest text-blue-300 uppercase">TezMind AI Engine</span>
                        </div>
                        <h2 class="font-display text-4xl md:text-6xl font-bold tracking-tight text-white mb-6">Interaktiv Vizualizator</h2>
                        <p class="text-gray-400 max-w-3xl mx-auto leading-relaxed text-xl">
                            TezMind.uz neyron tarmoqlari asosida qurilgan tizim. Kamera orqali sizning qo'l barmoqlaringiz harakatini o'qiydi va Koinot anomaliyasini qo'lda boshqarish imkonini beradi.
                        </p>
                    </div>

                    <div class="mt-[-2.5rem] z-20 mb-6">
                        <!-- TUGMA HAVOLAGA O'ZGARDI -->
                        <button id="start-sim-btn" class="btn-cinematic px-12 py-6 rounded-full font-display font-bold text-xl flex items-center gap-4 tracking-widest uppercase">
                            <i data-lucide="external-link" class="w-6 h-6"></i>
                            Tizimni Ishga Tushirish
                        </button>
                    </div>

                </div>
            </div>

        </main>
        
        <!-- Premium Footer -->
        <footer class="mt-32 pt-10 pb-10 border-t border-surfaceBorder text-center reveal-bounce">
            <div class="flex flex-col items-center justify-center gap-4">
                <i data-lucide="boxes" class="w-8 h-8 text-gray-500"></i>
                <h2 class="font-display font-black text-3xl tracking-[0.2em] uppercase brand-gradient">TEZMIND.UZ</h2>
                <p class="text-gray-600 text-sm tracking-widest mt-2 uppercase font-display">Ilm-fan va Sun'iy Intellekt chegarasi</p>
                <p class="text-gray-700 text-xs mt-6">© 2026 Akbar Abduraimov. Barcha huquqlar himoyalangan.</p>
            </div>
        </footer>
    </div>


    <!-- =========================================================================
         SIMULYATSIYA UI LAYER (YASHIRINGAN HOLATDA QOLDI)
         ========================================================================= -->

    <div id="loading-screen">
        <div class="loader-ring"></div>
        <h1 class="font-display text-4xl font-bold tracking-[0.3em] mb-4 text-white uppercase drop-shadow-[0_0_20px_rgba(255,255,255,0.8)]">TEZMIND ENGINE</h1>
        <p class="text-blue-400 font-mono text-sm tracking-widest uppercase" id="loading-text">Neyron tarmoqlar o'ta yuqori tezlikka moslanmoqda...</p>
    </div>

    <video id="video" autoplay playsinline></video>
    
    <!-- Dvigatel bu yerda ishlaydi, sayt ko'ringanda u saytning eng orqasida (z-index: 1) turadi -->
    <div id="webgl-container"></div>
    <canvas id="output_canvas"></canvas>

    <div id="ui-layer">
        <div class="flex justify-between items-start">
            <div class="sim-glass-panel flex flex-col gap-4 min-w-[260px]">
                <div class="flex items-center gap-3 text-white font-display">
                    <i data-lucide="layers" class="w-6 h-6 text-white"></i>
                    <h2 class="text-base font-bold tracking-[0.2em]">TEZMIND <span class="text-gray-500">AI</span></h2>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-300 bg-black/40 p-3 rounded-xl border border-white/10">
                    <span id="ai-status" class="status-dot"></span>
                    <span id="ai-status-text" class="font-bold tracking-wider text-xs uppercase font-mono">Initsializatsiya...</span>
                </div>
            </div>
            
            <div class="sim-glass-panel w-80">
                <div class="flex items-center justify-between mb-5 border-b border-white/10 pb-3">
                    <h3 class="font-display font-bold tracking-widest text-xs text-gray-400 uppercase">Tezkor Boshqaruv</h3>
                    <button id="exit-sim-btn" class="text-gray-400 hover:text-white transition-colors bg-white/5 p-2 rounded-full">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </div>
                <ul class="text-sm text-gray-300 space-y-5 font-medium">
                    <li class="flex items-center gap-4">
                        <span class="text-3xl drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">🤏🏻</span> 
                        <span class="text-sm tracking-wide">Chimdib surish (Orbita)</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="text-3xl drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">✊🏻</span> 
                        <span class="text-sm tracking-wide">Musht (Makro Kirish)</span>
                    </li>
                    <li class="flex items-center gap-4">
                        <span class="text-3xl drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">🖐🏼</span> 
                        <span class="text-sm tracking-wide">Ochiq kaft (Uzoqlashish)</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sim-glass-panel self-center flex items-center gap-4 px-12 py-5 mb-8 rounded-full border border-white/10 bg-black/50">
            <i data-lucide="radar" id="action-icon" class="w-6 h-6 text-gray-400 transition-colors duration-100"></i>
            <p id="gesture-feedback" class="text-sm font-bold text-white tracking-[0.3em] font-display uppercase">Sensorlar tayyor</p>
        </div>
    </div>


    <script>
        lucide.createIcons();

        // --- Custom Alert Function ---
        function showAlert(msg) {
            const alertBox = document.getElementById('custom-alert');
            document.getElementById('alert-message').innerText = msg;
            alertBox.classList.add('show');
            setTimeout(() => {
                alertBox.classList.remove('show');
            }, 5000);
        }

        // --- MOUSE GLOW EFFECT ---
        function handleMouseMove(e) {
            const rect = e.currentTarget.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            e.currentTarget.style.setProperty('--mouse-x', `${x}px`);
            e.currentTarget.style.setProperty('--mouse-y', `${y}px`);
        }

        // --- O'TA PROFESSIONAL BOUNCING REVEAL ANIMATION ---
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal-bounce, .reveal-up').forEach(el => observer.observe(el));


        // --- TRANSITION LOGIC ---
        const startBtn = document.getElementById('start-sim-btn');
        const webglContainer = document.getElementById('webgl-container');
        const outputCanvas = document.getElementById('output_canvas');

        let isFullscreen = false;

        // Boshlang'ich holatda WebGL eng orqada turadi (z-index: 1)
        function setBackgroundMode() {
            webglContainer.style.position = 'fixed'; 
            webglContainer.style.top = '0';
            webglContainer.style.left = '0';
            webglContainer.style.width = '100vw';
            webglContainer.style.height = '100vh';
            webglContainer.style.borderRadius = '0';
            webglContainer.style.zIndex = '1'; // Orqa fon
            webglContainer.style.opacity = '0.4'; // Biroz xiraroq va qoraroq
        }

        window.addEventListener('resize', () => {
            resizeWebGLCanvas();
        });

        // ================= HAVOLAGA O'TISH (YANGILANGAN QISM) =================
        startBtn.addEventListener('click', () => {
            window.location.href = "https://696f540674d5d.xvest3.ru/ds/uzb/SAYT/index.html";
            // Agar yangi oynada ochilishini istasangiz, pastdagi qatordan foydalanishingiz mumkin:
            // window.open("https://696f540674d5d.xvest3.ru/ds/uzb/SAYT/index.html", "_blank");
        });


        // ----------------------------------------------------
        // THREE.JS & MEDIAPIPE CORE (ORQA FON UCHUN SAQLAB QOLINDI)
        // ----------------------------------------------------
        
        const canvasCtx = outputCanvas.getContext('2d', { alpha: true });

        const scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x010103, 0.0015);
        
        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 10000);
        camera.position.z = 50;

        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: "high-performance" });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        webglContainer.appendChild(renderer.domElement);

        const ambientLight = new THREE.AmbientLight(0x222244, 2);
        scene.add(ambientLight);
        const mainLight = new THREE.PointLight(0x0a84ff, 5, 200);
        mainLight.position.set(20, 20, 20);
        scene.add(mainLight);
        const accentLight = new THREE.PointLight(0xbf5af2, 5, 200);
        accentLight.position.set(-20, -20, -20);
        scene.add(accentLight);

        const universeGroup = new THREE.Group();
        scene.add(universeGroup);

        const createGalaxyFallback = () => {
            const group = new THREE.Group();
            const geo = new THREE.IcosahedronGeometry(12, 5);
            const mat = new THREE.MeshStandardMaterial({
                color: 0x000000, wireframe: true, emissive: 0x0a84ff, emissiveIntensity: 0.5, transparent: true, opacity: 0.2
            });
            group.add(new THREE.Mesh(geo, mat));

            const particlesGeo = new THREE.BufferGeometry();
            const particlesCount = 15000;
            const posArray = new Float32Array(particlesCount * 3);
            const colorsArray = new Float32Array(particlesCount * 3);
            const color1 = new THREE.Color(0x0a84ff);
            const color2 = new THREE.Color(0xbf5af2);

            for(let i = 0; i < particlesCount * 3; i+=3) {
                const r = 30 * Math.cbrt(Math.random());
                const theta = Math.random() * 2 * Math.PI;
                const phi = Math.acos(2 * Math.random() - 1);
                posArray[i] = r * Math.sin(phi) * Math.cos(theta);
                posArray[i+1] = r * Math.sin(phi) * Math.sin(theta);
                posArray[i+2] = r * Math.cos(phi);
                const mixedColor = color1.clone().lerp(color2, Math.random());
                colorsArray[i] = mixedColor.r;
                colorsArray[i+1] = mixedColor.g;
                colorsArray[i+2] = mixedColor.b;
            }

            particlesGeo.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            particlesGeo.setAttribute('color', new THREE.BufferAttribute(colorsArray, 3));
            const particlesMat = new THREE.PointsMaterial({
                size: 0.08, vertexColors: true, transparent: true, opacity: 0.9, blending: THREE.AdditiveBlending, depthWrite: false
            });
            group.add(new THREE.Points(particlesGeo, particlesMat));
            return group;
        };
        
        let spaceModel = createGalaxyFallback();
        universeGroup.add(spaceModel);

        const gltfLoader = new THREE.GLTFLoader();
        // Siz yuborgan starliner/qora tuynuk modelini o'qiymiz
        gltfLoader.load('fhloston_paradise_luxury_starliner.glb', 
            (gltf) => {
                universeGroup.remove(spaceModel);
                spaceModel = gltf.scene;
                const box = new THREE.Box3().setFromObject(spaceModel);
                const center = box.getCenter(new THREE.Vector3());
                const size = box.getSize(new THREE.Vector3());
                const maxDim = Math.max(size.x, size.y, size.z);
                const scale = 30 / maxDim; 
                spaceModel.scale.set(scale, scale, scale);
                spaceModel.position.sub(center.multiplyScalar(scale));
                universeGroup.add(spaceModel);
            },
            undefined, () => {}
        );

        function resizeWebGLCanvas() {
            renderer.setSize(window.innerWidth, window.innerHeight);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            outputCanvas.width = window.innerWidth;
            outputCanvas.height = window.innerHeight;
        }
        
        setTimeout(() => {
            setBackgroundMode();
            resizeWebGLCanvas();
        }, 100);

        let targetRotationX = 0;
        let targetRotationY = 0;
        let currentZoom = 50;
        let targetZoom = 50;
        
        const LERP_FACTOR = 0.35; 

        function animate() {
            requestAnimationFrame(animate);

            universeGroup.rotation.y += (targetRotationY - universeGroup.rotation.y) * LERP_FACTOR;
            universeGroup.rotation.x += (targetRotationX - universeGroup.rotation.x) * LERP_FACTOR;

            if(spaceModel && spaceModel.children.length > 1 && !isFullscreen) {
                targetRotationY -= 0.001;
                targetRotationX -= 0.0005;
            }

            currentZoom += (targetZoom - currentZoom) * LERP_FACTOR;
            camera.position.z = currentZoom;

            renderer.render(scene, camera);
        }
        
        animate();
    </script>
</body>
</html>
