<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ config('app.name', 'HA Tech Portfolio Generator') }}</title>
    <meta name="description" content="HA Tech The Gen Z Hustler - Signup, login and launch premium portfolio generator.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fbfbfb] text-[#1e1b20] w-full">
    <div class="w-full max-w-[100vw] overflow-x-hidden relative flex flex-col min-h-screen">
        <header class="sticky top-0 z-50 glass-nav transition-all duration-300 w-full">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#f28b11] to-[#f2b311] rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-orange-500/20">
                    H
                </div>
                <div>
                    <p class="text-lg sm:text-xl font-extrabold tracking-tight">HA Tech</p>
                    <p class="text-[8px] sm:text-[10px] uppercase tracking-wider sm:tracking-[0.2em] text-[#5e5963] font-bold">The Gen Z Hustler</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-[#5e5963]">
                <a href="#features" class="hover:text-[#f28b11] transition-colors">Platform</a>
                <a href="#templates" class="hover:text-[#f28b11] transition-colors">Templates</a>
                <a href="#about" class="hover:text-[#f28b11] transition-colors">The Course</a>
            </nav>
            <nav class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="ha-btn px-6 py-2.5 text-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-sm hover:text-[#f28b11] transition-colors px-3">Log in</a>
                    <a href="{{ route('register') }}" class="ha-btn px-6 py-2.5 text-sm shadow-lg shadow-maroon/20">Sign up</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        <section class="relative pt-12 md:pt-20 pb-20 md:pb-28 w-full">
            <!-- Background Decoration - Hidden on Mobile -->
            <div class="hidden md:block absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-[1200px] h-[500px] bg-gradient-to-r from-[#fcf2e3] via-[#ffebd6] to-[#fcf2e3] opacity-60 blur-3xl -z-10 rounded-full"></div>
            
            <div class="mx-auto grid max-w-7xl gap-10 md:gap-12 px-5 md:px-6 lg:grid-cols-2 lg:items-center min-w-0 w-full overflow-hidden">
                <div class="max-w-2xl min-w-0 w-full">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#f2b311]/30 bg-[#fff9ed] px-3 py-1 text-[10px] md:text-xs font-bold text-[#ed8b00] mb-5 md:mb-6 shadow-sm overflow-hidden max-w-full">
                        <span class="w-2 h-2 rounded-full bg-[#f28b11] animate-pulse shrink-0"></span>
                        <span class="truncate">VVIP COURSE EXCLUSIVE</span>
                    </div>
                    <h1 class="text-4xl font-extrabold leading-[1.1] tracking-tight md:text-6xl lg:text-[4rem] text-wrap break-words">
                        Build a <span class="bg-gradient-to-r from-[#f28b11] to-[#f2b311] bg-clip-text text-transparent">Premium</span><br/>Student Portfolio.
                    </h1>
                    <p class="mt-4 md:mt-6 text-base md:text-lg text-[#5e5963] leading-relaxed max-w-xl text-wrap break-words">
                        A state-of-the-art SaaS generator giving you zero-code, beautifully crafted web portfolios instantly. Create your identity today.
                    </p>
                    <div class="mt-6 md:mt-8 flex flex-col sm:flex-row gap-3 md:gap-4 w-full">
                        <a href="{{ route('register') }}" class="ha-btn w-full sm:w-auto text-center px-6 sm:px-8 py-3 sm:py-3.5 text-sm sm:text-base shadow-xl shadow-maroon/10 shrink-0">Start Generating Now</a>
                        <a href="{{ route('login') }}" class="ha-btn-secondary w-full sm:w-auto text-center px-6 sm:px-8 py-3 sm:py-3.5 text-sm sm:text-base shrink-0">View Demos</a>
                    </div>
                    <p class="mt-4 text-[11px] md:text-xs text-[#9ca3af] font-medium text-center sm:text-left text-wrap break-words">No coding knowledge required • Part of The Gen Z Hustle Book</p>
                </div>
                
                <!-- Hero Visual / Book Mockup Placeholder -->
                <div class="relative w-full md:aspect-video lg:aspect-square flex justify-center items-center mt-6 md:mt-0">
                    <!-- Layer 1: Glow -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#f2b311] to-[#f28b11] rounded-[2.5rem] blur-2xl opacity-20 transform -rotate-3 scale-95"></div>
                    <!-- Layer 2: Main Card -->
                    <div class="relative w-full max-w-full sm:max-w-md bg-white border border-gray-100 rounded-3xl sm:rounded-[2rem] shadow-2xl overflow-hidden flex flex-col items-center p-5 sm:p-8 z-10 transition-transform duration-500 hover:scale-100 sm:hover:scale-[1.02]">
                        <div class="w-full flex justify-between items-center mb-6 border-b border-gray-50 pb-4 gap-2 overflow-hidden">
                            <div class="flex gap-1.5 shrink-0">
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-red-400"></div>
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="px-2 sm:px-3 py-1 bg-gray-50 rounded-md text-[9px] sm:text-[10px] font-mono text-gray-400 truncate max-w-[120px] sm:max-w-none">ha-tech.generator</div>
                        </div>
                        <div class="w-full overflow-hidden flex justify-center">
                            <lottie-player
                                src="https://assets5.lottiefiles.com/packages/lf20_jcikwtux.json"
                                background="transparent"
                                speed="1"
                                class="w-full h-[200px] sm:h-[260px] object-contain max-w-full"
                                loop
                                autoplay
                            ></lottie-player>
                        </div>
                        <h3 class="mt-4 text-lg sm:text-xl font-bold text-center break-words w-full">System Initialized</h3>
                        <p class="text-xs sm:text-sm text-[#5e5963] text-center mt-2 break-words w-full">Ready to generate your personal brand assets in seconds.</p>
                        
                        <!-- System Status Badge -->
                        <div class="mt-6 w-full text-center py-2.5 px-4 rounded-xl bg-[#f28b11]/5 border border-[#f28b11]/10 text-[10px] sm:text-xs text-[#f28b11] font-bold tracking-widest uppercase flex items-center justify-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#f28b11] animate-pulse"></span>
                            Premium Toolkit Initialized
                        </div>
                    </div>
                </div>
        </section>
        
        <!-- The Gen Z Hustle Book Section (Redesigned Premium Light) -->
        <section id="about" style="background-color: #ffffff; color: #111111; padding: 120px 0; position: relative; overflow: hidden; border-top: 1px solid #f0f0f0;">
            <!-- Subtle Background Accents -->
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 10% 10%, rgba(242, 139, 17, 0.03), transparent 30%); pointer-events: none;"></div>
            
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <div class="grid lg:grid-cols-2 gap-20 lg:gap-32 items-center">
                    
                    <!-- LEFT: Free-Floating 3D Mockup -->
                    <div class="flex justify-center" style="perspective: 2000px;">
                        <div class="relative group animate-float">
                            <!-- Premium 3D Mockup (Subtle Tilt, No Box) -->
                            <div style="position: relative; transition: all 1s cubic-bezier(0.2, 1, 0.3, 1); transform: rotateY(15deg) rotateX(4deg); transform-style: preserve-3d;" class="hover:rotate-y-[0deg] hover:rotate-x-[0deg]">
                                <img src="{{ asset('images/THE GEN Z HUSTLE.png') }}" alt="The Gen Z Hustle Book" class="w-full max-w-[440px] h-auto block" style="filter: drop-shadow(20px 40px 60px rgba(0,0,0,0.15));">
                                
                                <!-- Subtle Shine Overlay -->
                                <div style="position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%); pointer-events: none; border-radius: 4px;"></div>
                            </div>
                            
                            <!-- Premium Floating Badge (Minimalist) -->
                            <div style="position: absolute; top: -10px; left: -10px; background: #000; color: #fff; padding: 5px 12px; border-radius: 4px; font-weight: 800; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; box-shadow: 0 10px 20px rgba(0,0,0,0.1); transform: rotate(-5deg);">
                                VVIP MODULE
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Content Container -->
                    <div class="max-w-xl">
                        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 5px 12px; border-radius: 50px; background: #fff9f0; border: 1px solid #fee2b3; color: #f28b11; font-size: 10px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 25px;">
                            <span style="width: 5px; height: 5px; border-radius: 50%; background: #f28b11; box-shadow: 0 0 8px #f28b11;"></span>
                            Premium Toolkit
                        </div>
                        
                        <h2 style="font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; line-height: 1.1; margin-bottom: 20px; letter-spacing: -1.5px; color: #000;">
                            Your <span style="color: #f28b11; font-style: italic;">All-in-One</span><br/>Digital Empire Toolkit.
                        </h2>
                        
                        <p style="font-size: 18px; color: #52525b; line-height: 1.6; margin-bottom: 35px; font-weight: 400;">
                            Not just a book, but a comprehensive ecosystem to transform beginners into high-earning digital agency owners.
                        </p>
                        
                        <!-- Premium Features Grid (Soft Cards) -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 45px;">
                            <!-- Card 1 -->
                            <div style="padding: 20px; border-radius: 12px; background: #fafafa; border: 1px solid #f0f0f0; transition: all 0.3s;" onmouseover="this.style.background='#ffffff'; this.style.borderColor='#f28b11'; this.style.boxShadow='0 10px 30px rgba(242, 139, 17, 0.05)';" onmouseout="this.style.background='#fafafa'; this.style.borderColor='#f0f0f0'; this.style.boxShadow='none';">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: white; color: #f28b11; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fas fa-book-open" style="font-size: 16px;"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 6px; color: #000;">Digital Hustle Book</h4>
                                <p style="font-size: 12px; color: #71717a; line-height: 1.4;">A step-by-step roadmap built for the modern developer.</p>
                            </div>
                            <!-- Card 2 -->
                            <div style="padding: 20px; border-radius: 12px; background: #fafafa; border: 1px solid #f0f0f0; transition: all 0.3s;" onmouseover="this.style.background='#ffffff'; this.style.borderColor='#f28b11'; this.style.boxShadow='0 10px 30px rgba(242, 139, 17, 0.05)';" onmouseout="this.style.background='#fafafa'; this.style.borderColor='#f0f0f0'; this.style.boxShadow='none';">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: white; color: #f2b311; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fas fa-magic" style="font-size: 16px;"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 6px; color: #000;">Instant Generator</h4>
                                <p style="font-size: 12px; color: #71717a; line-height: 1.4;">Build professional portfolio pages in under 60 seconds.</p>
                            </div>
                            <!-- Card 3 -->
                            <div style="padding: 20px; border-radius: 12px; background: #fafafa; border: 1px solid #f0f0f0; transition: all 0.3s;" onmouseover="this.style.background='#ffffff'; this.style.borderColor='#f28b11'; this.style.boxShadow='0 10px 30px rgba(242, 139, 17, 0.05)';" onmouseout="this.style.background='#fafafa'; this.style.borderColor='#f0f0f0'; this.style.boxShadow='none';">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: white; color: #f28b11; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fas fa-layer-group" style="font-size: 16px;"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 6px; color: #000;">50+ Templates</h4>
                                <p style="font-size: 12px; color: #71717a; line-height: 1.4;">High-end asset bundle for ultimate client conversion.</p>
                            </div>
                            <!-- Card 4 -->
                            <div style="padding: 20px; border-radius: 12px; background: #fafafa; border: 1px solid #f0f0f0; transition: all 0.3s;" onmouseover="this.style.background='#ffffff'; this.style.borderColor='#f28b11'; this.style.boxShadow='0 10px 30px rgba(242, 139, 17, 0.05)';" onmouseout="this.style.background='#fafafa'; this.style.borderColor='#f0f0f0'; this.style.boxShadow='none';">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: white; color: #f2b311; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
                                    <i class="fas fa-search-dollar" style="font-size: 16px;"></i>
                                </div>
                                <h4 style="font-size: 15px; font-weight: 800; margin-bottom: 6px; color: #000;">Lead AI System</h4>
                                <p style="font-size: 12px; color: #71717a; line-height: 1.4;">Smart outreach tool to hunt high-ticket clients.</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('register') }}" class="inline-block text-center px-12 py-5 text-lg font-bold shadow-2xl shadow-orange-500/10 transform hover:-translate-y-1 transition-all" style="background: linear-gradient(to right, #f28b11, #f2b311); color: white; border-radius: 50px; text-decoration: none;">
                            Get Exclusive Access
                        </a>
                    </div>
                </div>
            </div>
        </section>
        

        <!-- Premium Feature Cards -->
        <section id="features" class="bg-white border-y border-[#e5e7eb] py-24 relative z-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl text-[#1e1b20]">Engineered for Excellence</h2>
                    <p class="mt-4 text-[#5e5963] text-lg">Every element is designed to make your profile stand out to recruiters, clients, and partners.</p>
                </div>
                
                <div class="grid gap-6 md:grid-cols-3">
                    <article class="ha-card p-5 sm:p-8 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#f28b11] flex items-center justify-center mb-6 group-hover:bg-[#f28b11] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Secure SaaS Portal</h3>
                        <p class="text-[#5e5963] leading-relaxed">Protected authentication ensures your generator session and portfolio downloads remain entirely private and accessible only by you.</p>
                    </article>
                    <article class="ha-card p-5 sm:p-8 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#f28b11] flex items-center justify-center mb-6 group-hover:bg-[#f28b11] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Professional Dashboard</h3>
                        <p class="text-[#5e5963] leading-relaxed">Manage your generated portfolios, view recent activity, and track the progress of your digital presence inside an elite workspace.</p>
                    </article>
                    <article class="ha-card p-5 sm:p-8 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#f28b11] flex items-center justify-center mb-6 group-hover:bg-[#f28b11] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">On-The-Fly Generation</h3>
                        <p class="text-[#5e5963] leading-relaxed">Zero server bloat. Your portfolios are compiled in real-time, fetching up to 50 premium template designs into a single deployment zip.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[#2a080d] text-[#e5e7eb] pt-20 pb-12">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-12 md:grid-cols-4 border-b border-white/10 pb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-[#f28b11] flex flex-col items-center justify-center text-white font-bold text-sm">H</div>
                        <span class="text-xl font-bold text-white tracking-tight">HA Tech</span>
                    </div>
                    <p class="text-sm text-gray-400 max-w-md leading-relaxed">
                        Empowering students to build brilliant careers. The ultimate toolkit attached to "The Gen Z Hustle" book, giving you the direct tools to succeed without writing a line of code.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4 tracking-wide">Platform</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#f28b11] transition-colors">Generator Wizard</a></li>
                        <li><a href="#" class="hover:text-[#f28b11] transition-colors">Dashboard Features</a></li>
                        <li><a href="#" class="hover:text-[#f28b11] transition-colors">Pricing & License</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4 tracking-wide">Resources</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-[#f28b11] transition-colors">The Gen Z Hustle Book</a></li>
                        <li><a href="#" class="hover:text-[#f28b11] transition-colors">Support & Help</a></li>
                        <li><a href="#" class="hover:text-[#f28b11] transition-colors">Contact Developer</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500">
                <p>&copy; {{ now()->year }} HA Tech. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    </div>
</body>
</html>
