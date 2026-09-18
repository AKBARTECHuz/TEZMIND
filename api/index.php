<?php
// CV yuklab olish funksiyasi
if (isset($_GET['download']) && $_GET['download'] === 'cv') {$cv_content = "TEZMIND.uz - Portfolio\n\nIsm: Abduraimov Akbar\nYo'nalish: Prompt Engineering & Frontend Developer\nIsh joyi: Najot Ta'lim\nO'quvchilar: 20+\nDarsliklar: 30+\nTillari: O'zbek, Ingliz, Koreys\nBog'lanish: +998 91 879 79 17";
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="Abduraimov_Akbar_CV.txt"');
    header('Content-Length: ' . strlen($cv_content));
    echo $cv_content;
    exit;
}

// Telegram Bot Sozlamalari
$botToken = '8576620880:AAF19LJNCu-b1CHoUXlD6DrpaQLoK_kor7Y';
$adminId = '8506011274';$message_status = null;
$status_text = '';

// Formani qabul qilish va Telegramga yuborish
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $name = trim(htmlspecialchars($_POST['name'] ?? ''));
    $phone = trim(htmlspecialchars($_POST['phone'] ?? ''));
    $message = trim(htmlspecialchars($_POST['message'] ?? ''));

    if (mb_strlen($message) < 100) {
        $message_status = 'error';$status_text = "Xabar matni kamida 100 ta belgidan iborat bo'lishi kerak. Siz " . mb_strlen($message) . " ta belgi kiritdingiz.";
    } else {
        $telegramText = "🚀 <b>Yangi mijoz xabari (TEZMIND.uz):</b>\n\n";
        $telegramText .= "👤 <b>Ism:</b> {$name}\n";
        $telegramText .= "📞 <b>Raqam:</b> {$phone}\n";
        $telegramText .= "📝 <b>Xabar:</b>\n{$message}";

        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $data = [
            'chat_id' => $adminId,
            'text' => $telegramText,
            'parse_mode' => 'HTML'
        ];

        // cURL orqali so'rov yuborish (ishonchliroq)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result) {
            $message_status = 'success';$status_text = 'Xabaringiz muvaffaqiyatli yuborildi. Tez orada aloqaga chiqamiz!';
        } else {
            $message_status = 'error';$status_text = 'Serverda xatolik yuz berdi. Iltimos, keyinroq urinib ko\'ring.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEZMIND.uz | Abduraimov Akbar</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- GSAP for Professional Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <!-- SweetAlert2 for Professional Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background-color: #050505;
            color: #ffffff;
            font-family: 'Inter', system-ui, sans-serif;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        
        /* Glassmorphism Elements */
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            transition: all 0.4s ease;
        }

        .glass-panel:hover {
            border-color: rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-5px);
        }

        /* Form Inputs Custom Style */
        .glass-input {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }

        /* Ambient Glows */
        .glow-bg {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, rgba(0,0,0,0) 70%);
            top: -100px;
            left: -300px;
            z-index: -1;
            border-radius: 50%;
        }
        .glow-bg-2 {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(147,51,234,0.12) 0%, rgba(0,0,0,0) 70%);
            top: 40%;
            right: -200px;
            z-index: -1;
            border-radius: 50%;
        }
        .glow-bg-3 {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, rgba(0,0,0,0) 70%);
            bottom: -200px;
            left: 10%;
            z-index: -1;
            border-radius: 50%;
        }

        /* GSAP Initial States */
        .gsap-blur-reveal, .gsap-stagger-item, .gsap-form-reveal {
            opacity: 0;
            visibility: hidden;
        }
    </style>
</head>
<body class="antialiased relative">
    <div class="glow-bg"></div>
    <div class="glow-bg-2"></div>
    <div class="glow-bg-3"></div>

    <?php if ($message_status): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<?= $message_status === 'success' ? 'Ajoyib!' : 'Xatolik!' ?>',
                text: '<?= $status_text ?>',
                icon: '<?= $message_status ?>',
                background: '#111',
                color: '#fff',
                confirmButtonColor: '<?= $message_status === 'success' ? '#3b82f6' : '#ef4444' ?>'
            });
        });
    </script>
    <?php endif; ?>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-panel border-b-0 border-x-0 border-t-0 bg-transparent/50 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
                TEZMIND.uz
            </h1>
            <div class="flex gap-4">
                <a href="#contact" class="hidden md:flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-600/20 hover:bg-blue-600/40 border border-blue-500/30 transition-all text-sm font-medium text-blue-400">
                    Aloqa
                </a>
                <a href="?download=cv" class="flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/10 transition-all text-sm font-medium">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Ma'lumotlarni yuklash</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="max-w-7xl mx-auto px-6 pt-40 pb-20 flex flex-col items-center justify-center min-h-[90vh] text-center">
        <div class="mb-8 relative inline-block gsap-blur-reveal">
            <div class="w-36 h-36 rounded-full overflow-hidden border-2 border-blue-500/30 p-1 relative z-10">
                <img src="https://ui-avatars.com/api/?name=Akbar+Abduraimov&background=1e3a8a&color=fff&size=150" alt="Akbar Abduraimov" class="w-full h-full rounded-full object-cover">
            </div>
            <div class="absolute inset-0 bg-blue-500 rounded-full blur-[40px] opacity-20 -z-10"></div>
        </div>

        <h2 class="text-5xl md:text-7xl font-extrabold mb-4 tracking-tight gsap-blur-reveal">
            Abduraimov <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">Akbar</span>
        </h2>
        
        <p class="text-xl md:text-2xl text-gray-400 mb-10 max-w-3xl font-light gsap-blur-reveal leading-relaxed">
            Sun'iy intellekt modellarini boshqarishga ixtisoslashgan <strong class="text-white font-medium">Prompt Engineer</strong> va zamonaviy interfeyslar yaratuvchi <strong class="text-white font-medium">Frontend Developer</strong>.
        </p>

        <a href="#about" class="mt-8 animate-bounce gsap-blur-reveal">
            <i data-lucide="chevron-down" class="w-8 h-8 text-gray-500 hover:text-white transition-colors"></i>
        </a>
    </main>

    <!-- Skills & Metrics Section -->
    <section id="about" class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-16 gsap-stagger-item">
            <h3 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-100 to-gray-500 inline-block">Mening Mutaxassisligim</h3>
            <div class="w-20 h-1 bg-blue-500/50 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Yutuqlar va Tillari Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
            
            <!-- Kasb -->
            <div class="glass-panel p-8 rounded-3xl gsap-stagger-item">
                <i data-lucide="terminal" class="w-10 h-10 text-blue-400 mb-6"></i>
                <h4 class="text-2xl font-semibold mb-2">Mutaxassislik</h4>
                <ul class="text-gray-400 space-y-3 mt-4">
                    <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-500"></i> Prompt Engineering</li>
                    <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-500"></i> Frontend Development</li>
                    <li class="flex items-center gap-3"><i data-lucide="check-circle-2" class="w-5 h-5 text-blue-500"></i> UI/UX Design</li>
                </ul>
            </div>

            <!-- Tillar -->
            <div class="glass-panel p-8 rounded-3xl gsap-stagger-item">
                <i data-lucide="languages" class="w-10 h-10 text-purple-400 mb-6"></i>
                <h4 class="text-2xl font-semibold mb-2">Tillar</h4>
                <div class="space-y-4 mt-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1 text-gray-400"><span>O'zbek tili</span> <span>Native</span></div>
                        <div class="w-full bg-gray-800 rounded-full h-2"><div class="bg-purple-500 h-2 rounded-full" style="width: 100%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1 text-gray-400"><span>Ingliz tili</span> <span>Advanced</span></div>
                        <div class="w-full bg-gray-800 rounded-full h-2"><div class="bg-purple-500 h-2 rounded-full" style="width: 85%"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1 text-gray-400"><span>Koreys tili</span> <span>Intermediate</span></div>
                        <div class="w-full bg-gray-800 rounded-full h-2"><div class="bg-purple-500 h-2 rounded-full" style="width: 65%"></div></div>
                    </div>
                </div>
            </div>

            <!-- Tajriba & Yutuqlar -->
            <div class="glass-panel p-8 rounded-3xl gsap-stagger-item lg:col-span-1 md:col-span-2">
                <i data-lucide="award" class="w-10 h-10 text-emerald-400 mb-6"></i>
                <h4 class="text-2xl font-semibold mb-2">Tajriba va Yutuqlar</h4>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                        <p class="text-3xl font-bold text-emerald-400 mb-1">20+</p>
                        <p class="text-sm text-gray-400">Muvaffaqiyatli O'quvchilar</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-2xl border border-white/5">
                        <p class="text-3xl font-bold text-emerald-400 mb-1">30+</p>
                        <p class="text-sm text-gray-400">Yaratilgan Darsliklar</p>
                    </div>
                    <div class="bg-white/5 p-4 rounded-2xl border border-white/5 col-span-2">
                        <p class="text-sm text-gray-400 mb-1">Joriy ish joyi</p>
                        <p class="text-xl font-semibold flex items-center gap-2"><i data-lucide="briefcase" class="w-5 h-5 text-gray-400"></i> Najot Ta'lim</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="max-w-4xl mx-auto px-6 py-20">
        <div class="text-center mb-12 gsap-form-reveal">
            <h3 class="text-3xl font-bold mb-4">Birgalikda ishlaymizmi?</h3>
            <p class="text-gray-400">Loyihangiz haqida ma'lumot qoldiring. Men tez orada siz bilan bog'lanaman.</p>
        </div>

        <div class="glass-panel p-8 md:p-12 rounded-3xl gsap-form-reveal">
            <form action="" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ism -->
                    <div class="space-y-2">
                        <label for="name" class="text-sm text-gray-400 font-medium ml-1">Ism-sharifingiz</label>
                        <input type="text" id="name" name="name" required placeholder="Masalan: Alisher Navoiy" 
                               class="glass-input w-full px-5 py-4 rounded-xl text-white placeholder-gray-600 focus:ring-0">
                    </div>
                    
                    <!-- Raqam -->
                    <div class="space-y-2">
                        <label for="phone" class="text-sm text-gray-400 font-medium ml-1">Telefon raqamingiz</label>
                        <input type="tel" id="phone" name="phone" required placeholder="+998 90 123 45 67" 
                               class="glass-input w-full px-5 py-4 rounded-xl text-white placeholder-gray-600 focus:ring-0">
                    </div>
                </div>

                <!-- Xabar -->
                <div class="space-y-2">
                    <div class="flex justify-between items-end ml-1 mb-1">
                        <label for="message" class="text-sm text-gray-400 font-medium">Loyiha haqida batafsil ma'lumot (min. 100 belgi)</label>
                        <span id="charCount" class="text-xs text-rose-400 font-semibold bg-rose-500/10 px-2 py-1 rounded">0 / 100</span>
                    </div>
                    <textarea id="message" name="message" required rows="5" minlength="100" 
                              placeholder="Loyiha maqsadi, qanday texnologiyalar kerakligi va kutilayotgan natijalar haqida batafsil yozib qoldiring..." 
                              class="glass-input w-full px-5 py-4 rounded-xl text-white placeholder-gray-600 focus:ring-0 resize-y"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="send_message" id="submitBtn" disabled
                        class="w-full py-4 rounded-xl font-bold text-lg transition-all flex justify-center items-center gap-2 bg-gray-800 text-gray-500 cursor-not-allowed">
                    <i data-lucide="send" class="w-5 h-5"></i> Xabarni yuborish
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 mt-10 py-10 text-center text-gray-500 bg-black/50 backdrop-blur-md">
        <p class="text-lg font-medium text-white mb-2">TEZMIND.uz</p>
        <p class="text-sm">&copy; <?php echo date('Y'); ?> Abduraimov Akbar. Barcha huquqlar himoyalangan.</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Lucide Icons
        lucide.createIcons();

        // Xabar uchun belgilarni sanash logikasi (UX/UI)
        const messageInput = document.getElementById('message');
        const charCountDisplay = document.getElementById('charCount');
        const submitBtn = document.getElementById('submitBtn');

        messageInput.addEventListener('input', function() {
            const len = this.value.length;
            
            if (len < 100) {
                charCountDisplay.textContent = `${len} / 100`;
                charCountDisplay.className = "text-xs text-rose-400 font-semibold bg-rose-500/10 px-2 py-1 rounded";
                submitBtn.disabled = true;
                submitBtn.className = "w-full py-4 rounded-xl font-bold text-lg transition-all flex justify-center items-center gap-2 bg-gray-800 text-gray-500 cursor-not-allowed";
            } else {
                charCountDisplay.textContent = `${len} belgi kiritildi`;
                charCountDisplay.className = "text-xs text-emerald-400 font-semibold bg-emerald-500/10 px-2 py-1 rounded";
                submitBtn.disabled = false;
                submitBtn.className = "w-full py-4 rounded-xl font-bold text-lg transition-all flex justify-center items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white shadow-lg shadow-blue-500/25 cursor-pointer transform hover:-translate-y-1";
            }
        });

        // GSAP Animations (Professional Deep Bounce & Blur)
        gsap.registerPlugin(ScrollTrigger);

        // Hero Section Initial Load
        gsap.fromTo(".gsap-blur-reveal", 
            { autoAlpha: 0, filter: "blur(24px)", y: 60, scale: 0.95 },
            { autoAlpha: 1, filter: "blur(0px)", y: 0, scale: 1, duration: 1.4, stagger: 0.2, ease: "back.out(1.7)" }
        );

        // Skills Section Scroll Reveal (Staggered)
        gsap.fromTo(".gsap-stagger-item", 
            { autoAlpha: 0, filter: "blur(15px)", y: 80, rotationX: -15 },
            { 
                autoAlpha: 1, filter: "blur(0px)", y: 0, rotationX: 0, 
                duration: 1.2, stagger: 0.15, ease: "back.out(1.4)",
                scrollTrigger: { 
                    trigger: "#about", 
                    start: "top 80%",
                    toggleActions: "play none none reverse"
                }
            }
        );

        // Contact Form Scroll Reveal
        gsap.fromTo(".gsap-form-reveal", 
            { autoAlpha: 0, filter: "blur(20px)", y: 100 },
            { 
                autoAlpha: 1, filter: "blur(0px)", y: 0, 
                duration: 1.5, stagger: 0.3, ease: "power4.out",
                scrollTrigger: { 
                    trigger: "#contact", 
                    start: "top 85%"
                }
            }
        );
    </script>
</body>
</html>
