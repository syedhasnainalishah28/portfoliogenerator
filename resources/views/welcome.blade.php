<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ config('app.name', 'HA Tech Portfolio Generator') }}</title>
    <meta name="description" content="HA Tech The Gen Z Hustler - Signup, login and launch premium portfolio generator.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
          theme: {
            extend: {
              fontFamily: {
                syne: ['Syne', 'sans-serif'],
                jakarta: ['Plus Jakarta Sans', 'sans-serif'],
              },
              colors: {
                gold: {
                  DEFAULT: '#D4A853',
                  light: '#F0C97A',
                  dark: '#A67C3A',
                  glow: 'rgba(212,168,83,0.3)',
                },
                ink: {
                  DEFAULT: '#090910',
                  900: '#050508',
                  800: '#0F0F1A',
                }
              },
              animation: {
                'float-book': 'floatBook 5s ease-in-out infinite',
                'shimmer': 'shimmer 3s linear infinite',
                'glow-pulse': 'glowPulse 3s ease-in-out infinite',
                'ray-move': 'rayMove 10s ease-in-out infinite',
                'float-particle': 'floatParticle 15s linear infinite',
              },
              keyframes: {
                floatBook: {
                  '0%, 100%': { transform: 'translateY(0px) rotateY(-5deg)' },
                  '50%': { transform: 'translateY(-20px) rotateY(2deg)' },
                },
                shimmer: {
                  '0%': { backgroundPosition: '-200% center' },
                  '100%': { backgroundPosition: '200% center' },
                },
                glowPulse: {
                  '0%, 100%': { boxShadow: '0 0 20px rgba(212,168,83,0.3)' },
                  '50%': { boxShadow: '0 0 50px rgba(212,168,83,0.6)' },
                },
                rayMove: {
                  '0%, 100%': { transform: 'translateX(-30%) rotate(-45deg)', opacity: '0.1' },
                  '50%': { transform: 'translateX(30%) rotate(-45deg)', opacity: '0.3' },
                },
                floatParticle: {
                  '0%': { transform: 'translateY(100vh) translateX(0) rotate(0deg)', opacity: '0' },
                  '20%': { opacity: '0.4' },
                  '80%': { opacity: '0.4' },
                  '100%': { transform: 'translateY(-20vh) translateX(50px) rotate(360deg)', opacity: '0' },
                }
              }
            }
          }
        }
      </script>
      <style>
        .gold-shimmer {
          background: linear-gradient(90deg, #A67C3A 0%, #F0C97A 25%, #D4A853 50%, #F0C97A 75%, #A67C3A 100%);
          background-size: 200% auto;
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          animation: shimmer 4s linear infinite;
        }
    
        .book-shadow {
          filter: drop-shadow(0 25px 50px rgba(0,0,0,0.8));
        }
    
        .glass-card {
          background: rgba(255, 255, 255, 0.03);
          backdrop-filter: blur(12px);
          border: 1px solid rgba(255, 255, 255, 0.08);
          transition: all 0.3s ease;
        }
    
        .glass-card:hover {
          border-color: rgba(212, 168, 83, 0.3);
          background: rgba(212, 168, 83, 0.05);
          transform: translateY(-5px);
        }
        
        .light-ray {
          width: 100vw;
          height: 150vh;
          background: linear-gradient(90deg, transparent, rgba(212,168,83,0.05), transparent);
          position: absolute;
          top: -25%;
          left: -25%;
          transform: rotate(-45deg);
          pointer-events: none;
        }

        .section-noise {
          position: absolute;
          inset: 0;
          background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
          pointer-events: none;
          z-index: 5;
        }
      </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#fbfbfb] text-[#1e1b20] w-full">
    <div class="w-full max-w-[100vw] overflow-x-hidden relative flex flex-col min-h-screen">
        <header class="sticky top-0 z-50 glass-nav transition-all duration-300 w-full">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('HA-Tech.png') }}" class="w-10 h-10 object-contain drop-shadow-[0_0_15px_rgba(242,139,17,0.4)]" alt="HA Tech">
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
            
            <div class="mx-auto grid max-w-7xl gap-10 md:gap-16 px-5 md:px-6 lg:grid-cols-[2fr_3fr] lg:items-center min-w-0 w-full overflow-hidden">
                <div class="max-w-2xl min-w-0 w-full">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#f2b311]/30 bg-[#fff9ed] px-3 py-1 text-[10px] md:text-xs font-bold text-[#ed8b00] mb-5 md:mb-6 shadow-sm overflow-hidden max-w-full">
                        <span class="w-2 h-2 rounded-full bg-[#f28b11] animate-pulse shrink-0"></span>
                        <span class="truncate">VVIP COURSE EXCLUSIVE</span>
                    </div>
                    <h1 class="text-4xl font-extrabold leading-[1.1] tracking-tight md:text-6xl lg:text-[4rem] text-wrap break-words">
                        Build a <span class="bg-gradient-to-r from-[#f28b11] to-[#f2b311] bg-clip-text text-transparent">Premium</span><br/>Digital Identity.
                    </h1>
                    <p class="mt-4 md:mt-6 text-base md:text-lg text-[#5e5963] leading-relaxed max-w-xl text-wrap break-words">
                        Stop sending resumes. Start sending experiences. Our AI-driven engine generates production-ready, high-converting portfolios in seconds. Launch your career, zero code required.
                    </p>
                    <div class="mt-6 md:mt-8 flex flex-col sm:flex-row gap-3 md:gap-4 w-full">
                        <a href="{{ route('register') }}" class="ha-btn w-full sm:w-auto text-center px-6 sm:px-8 py-3 sm:py-3.5 text-sm sm:text-base shadow-xl shadow-maroon/10 shrink-0">Start Generating Now</a>
                        <a href="{{ route('login') }}" class="ha-btn-secondary w-full sm:w-auto text-center px-6 sm:px-8 py-3 sm:py-3.5 text-sm sm:text-base shrink-0">View Demos</a>
                    </div>
                    <p class="mt-4 text-[11px] md:text-xs text-[#9ca3af] font-medium text-center sm:text-left text-wrap break-words">No coding knowledge required • Part of The Gen Z Hustle Book</p>
                </div>
                
                <!-- Hero Visual / Book Mockup Placeholder -->
                <div class="relative w-full flex justify-center items-center mt-6 md:mt-0">
                    <!-- Layer 1: Glow -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#f2b311] to-[#f28b11] rounded-[2.5rem] blur-2xl opacity-20 transform -rotate-3 scale-95"></div>
                    <!-- Layer 2: Main Card -->
                    <div class="relative w-full bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden flex flex-col z-10 transition-transform duration-500 hover:scale-[1.01]">
                        <div class="flex justify-between items-center px-4 py-3 border-b border-gray-100">
                            <div class="flex gap-1.5 shrink-0">
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-red-400"></div>
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-yellow-400"></div>
                                <div class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div class="px-2 sm:px-3 py-1 bg-gray-50 rounded-md text-[9px] sm:text-[10px] font-mono text-gray-400 truncate max-w-[120px] sm:max-w-none">ha-tech.generator</div>
                        </div>
                        <div class="w-full overflow-hidden flex justify-center">
                            <video 
                                class="w-full h-auto object-contain" 
                                autoplay 
                                loop 
                                muted 
                                playsinline
                            >
                                <source src="{{ asset('videos/shah-video.mp4') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        <!-- Bottom bar -->
                        <div class="flex items-center justify-between px-4 py-3 border-t border-gray-100 bg-gray-50/60">
                            <div>
                                <div class="text-sm font-bold text-[#1e1b20]">System Initialized</div>
                                <div class="text-[10px] text-[#9ca3af] mt-0.5">Ready to generate your brand assets</div>
                            </div>
                            <div class="flex items-center gap-1.5 bg-[#f28b11]/10 border border-[#f28b11]/20 text-[#f28b11] text-[9px] font-bold tracking-wider uppercase px-3 py-1.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f28b11] animate-pulse"></span>
                                Live
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        
        
        

        <!-- Premium Feature Cards -->
        <section id="features" class="bg-white border-y border-[#e5e7eb] py-24 relative z-20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl text-[#1e1b20]">Client-Magnet Designs</h2>
                    <p class="mt-4 text-[#5e5963] text-lg">Every element is designed to make your profile stand out to recruiters, clients, and partners.</p>
                </div>
                
                <div class="grid gap-6 md:grid-cols-3">
                    <article class="ha-card p-5 sm:p-8 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#f28b11] flex items-center justify-center mb-6 group-hover:bg-[#f28b11] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Exclusive Private Access</h3>
                        <p class="text-[#5e5963] leading-relaxed">Protected authentication ensures your generator session and portfolio downloads remain entirely private and accessible only by you.</p>
                    </article>
                    <article class="ha-card p-5 sm:p-8 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#f28b11] flex items-center justify-center mb-6 group-hover:bg-[#f28b11] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Hustler’s Control Center</h3>
                        <p class="text-[#5e5963] leading-relaxed">Manage your generated portfolios, view recent activity, and track the progress of your digital presence inside an elite workspace.</p>
                    </article>
                    <article class="ha-card p-5 sm:p-8 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-[#f28b11] flex items-center justify-center mb-6 group-hover:bg-[#f28b11] group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Instant 1-Click Deployment</h3>
                        <p class="text-[#5e5963] leading-relaxed">Zero server bloat. Your portfolios are compiled in real-time, fetching up to 50 premium template designs into a single deployment zip.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section id="how-it-works" class="bg-[#fafafa] py-24 relative overflow-hidden">
            <!-- Subtle background grid -->
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#1e1b20 1px, transparent 1px), linear-gradient(90deg, #1e1b20 1px, transparent 1px); background-size: 40px 40px;"></div>

            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <!-- Header -->
                <div class="text-center max-w-2xl mx-auto mb-20">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#f2b311]/30 bg-[#fff9ed] px-4 py-1.5 text-xs font-bold text-[#ed8b00] mb-5 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#f28b11] animate-pulse"></span>
                        ZERO LEARNING CURVE
                    </div>
                    <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl text-[#1e1b20]">Launch in <span class="bg-gradient-to-r from-[#f28b11] to-[#f2b311] bg-clip-text text-transparent">3 Simple Steps</span></h2>
                    <p class="mt-4 text-[#5e5963] text-lg">No experience needed. No code required. Just fill, pick, and launch.</p>
                </div>

                <!-- Steps -->
                <div class="grid md:grid-cols-3 gap-8 relative">

                    <!-- Connector Line (Desktop only) -->
                    <div class="hidden md:block absolute top-14 left-[calc(16.67%+24px)] right-[calc(16.67%+24px)] h-px bg-gradient-to-r from-[#f28b11]/30 via-[#f2b311]/60 to-[#f28b11]/30 z-0"></div>

                    <!-- Step 01 -->
                    <div class="relative z-10 group text-center flex flex-col items-center">
                        <div class="relative mb-6">
                            <div class="w-28 h-28 rounded-[2rem] bg-white border-2 border-[#f28b11]/20 shadow-xl flex items-center justify-center group-hover:border-[#f28b11] group-hover:shadow-[0_0_40px_rgba(242,139,17,0.15)] transition-all duration-500">
                                <svg class="w-12 h-12 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <div class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#f28b11] text-white text-xs font-black flex items-center justify-center shadow-lg">01</div>
                        </div>
                        <h3 class="text-xl font-extrabold text-[#1e1b20] mb-3">Enter Your Details</h3>
                        <p class="text-[#5e5963] text-sm leading-relaxed max-w-xs">Tell us your name, bio, skills, and experiences. Takes less than 2 minutes — no technical knowledge needed.</p>
                    </div>

                    <!-- Step 02 -->
                    <div class="relative z-10 group text-center flex flex-col items-center">
                        <div class="relative mb-6">
                            <div class="w-28 h-28 rounded-[2rem] bg-white border-2 border-[#f28b11]/20 shadow-xl flex items-center justify-center group-hover:border-[#f28b11] group-hover:shadow-[0_0_40px_rgba(242,139,17,0.15)] transition-all duration-500">
                                <svg class="w-12 h-12 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                                </svg>
                            </div>
                            <div class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#f28b11] text-white text-xs font-black flex items-center justify-center shadow-lg">02</div>
                        </div>
                        <h3 class="text-xl font-extrabold text-[#1e1b20] mb-3">Pick Your Signature Style</h3>
                        <p class="text-[#5e5963] text-sm leading-relaxed max-w-xs">Choose from 50+ professionally crafted templates. Each one is conversion-optimised and recruiter-approved.</p>
                    </div>

                    <!-- Step 03 -->
                    <div class="relative z-10 group text-center flex flex-col items-center">
                        <div class="relative mb-6">
                            <div class="w-28 h-28 rounded-[2rem] bg-white border-2 border-[#f28b11]/20 shadow-xl flex items-center justify-center group-hover:border-[#f28b11] group-hover:shadow-[0_0_40px_rgba(242,139,17,0.15)] transition-all duration-500">
                                <svg class="w-12 h-12 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </div>
                            <div class="absolute -top-3 -right-3 w-8 h-8 rounded-full bg-[#f28b11] text-white text-xs font-black flex items-center justify-center shadow-lg">03</div>
                        </div>
                        <h3 class="text-xl font-extrabold text-[#1e1b20] mb-3">One-Click Launch</h3>
                        <p class="text-[#5e5963] text-sm leading-relaxed max-w-xs">Download your production-ready ZIP. Your entire portfolio — live, deployed, professional — in a single click.</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-16 text-center">
                    <a href="{{ route('register') }}" class="ha-btn inline-flex items-center gap-3 px-8 py-4 text-base shadow-xl shadow-maroon/10">
                        Start Building Free
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <p class="mt-3 text-xs text-[#9ca3af] font-medium">Takes less than 5 minutes. No credit card required.</p>
                </div>
            </div>
        </section>

        <!-- The Gen Z Hustle Book Section (Custom Premium Dark Theme) -->
        <section id="about" class="relative min-h-[auto] lg:min-h-screen flex items-center justify-center py-6 md:py-20 px-6 overflow-hidden bg-ink text-white">
            <div class="section-noise"></div>
    
            <!-- Luxury Background System -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <!-- Animated Rays (Hidden on Mobile) -->
                <div class="light-ray animate-ray-move hidden md:block" style="animation-delay: 0s"></div>
                <div class="light-ray animate-ray-move hidden md:block" style="animation-delay: -5s; opacity: 0.05"></div>
                
                <!-- Diamond Particles -->
                <div class="absolute inset-0">
                <div class="absolute bottom-[-50px] left-[15%] text-gold/20 text-sm animate-float-particle" style="animation-duration: 12s; animation-delay: 0s"><i class="fas fa-diamond"></i></div>
                <div class="absolute bottom-[-50px] left-[45%] text-gold/10 text-xs animate-float-particle" style="animation-duration: 18s; animation-delay: 2s"><i class="fas fa-diamond"></i></div>
                <div class="absolute bottom-[-50px] left-[75%] text-gold/15 text-sm animate-float-particle" style="animation-duration: 15s; animation-delay: 5s"><i class="fas fa-diamond"></i></div>
                <div class="absolute bottom-[-50px] left-[85%] text-gold/5 text-xs animate-float-particle" style="animation-duration: 20s; animation-delay: 8s"><i class="fas fa-diamond"></i></div>
                </div>
    
                <!-- Glass Architectural Slabs (Hidden on Mobile) -->
                <div class="absolute -right-20 top-20 w-64 h-[70vh] bg-white/[0.02] backdrop-blur-3xl skew-x-[-20deg] border-l border-white/5 hidden md:block"></div>
                <div class="absolute -left-32 bottom-20 w-80 h-[50vh] bg-white/[0.02] backdrop-blur-2xl skew-x-[-20deg] border-r border-white/5 hidden md:block"></div>
            </div>
    
            <div class="max-w-7xl mx-auto w-full grid lg:grid-cols-2 gap-4 lg:gap-16 items-center relative z-20">
                
                <!-- Left Side: Content -->
                <div class="order-2 lg:order-1 space-y-4 md:space-y-8">
                <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-full text-[10px] font-black tracking-[0.2em] text-white/50 uppercase">
                    <span class="w-1 h-1 rounded-full bg-gold animate-pulse"></span> Exclusive Release
                </div>
                
                <h1 class="font-syne font-extrabold leading-tight text-5xl md:text-7xl">
                    Build Your <br>
                    <span class="gold-shimmer">Digital Empire</span>
                </h1>
                
                <p class="text-white/50 text-lg md:text-xl max-w-xl leading-relaxed">
                    Zero coding skills? No problem. I'll teach you how to build your digital empire using AI and modern tools. 
                    <span class="text-white/80 font-medium">This isn't just a book; it's a complete roadmap designed to transform your professional life.</span>
                </p>
    
                <!-- Feature Grid (Premium Minimalist) -->
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="group relative">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-full border border-gold/30 flex items-center justify-center text-gold text-sm group-hover:bg-gold group-hover:text-ink transition-all duration-500">
                        01
                        </div>
                        <h4 class="font-syne font-bold text-white tracking-wide">ZERO TO PRO</h4>
                    </div>
                    <p class="text-white/30 text-xs leading-relaxed pl-14">Our step-by-step approach ensures a seamless transition from beginner to high-ticket expert.</p>
                    </div>
                    <div class="group relative">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-full border border-[#5CF0C8]/30 flex items-center justify-center text-[#5CF0C8] text-sm group-hover:bg-[#5CF0C8] group-hover:text-ink transition-all duration-500">
                        02
                        </div>
                        <h4 class="font-syne font-bold text-white tracking-wide uppercase">AI Mastery</h4>
                    </div>
                    <p class="text-white/30 text-xs leading-relaxed pl-14">Master the manipulation of modern AI tools to accelerate your creative workflow by 10x.</p>
                    </div>
                </div>
    
                <div class="pt-10 flex flex-col sm:flex-row items-center gap-6">
                    <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-10 py-5 font-syne font-black text-ink bg-gold rounded-full overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-[0_0_40px_rgba(212,168,83,0.2)] hover:shadow-[0_0_60px_rgba(212,168,83,0.4)]">
                    <span class="relative flex items-center gap-3 text-sm tracking-wider uppercase">
                        Download Now <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                    </a>
                    <div class="flex -space-x-3">
                    <div class="w-10 h-10 rounded-full border-2 border-ink bg-gray-800 flex items-center justify-center text-[10px] font-bold">AA</div>
                    <div class="w-10 h-10 rounded-full border-2 border-ink bg-gray-700 flex items-center justify-center text-[10px] font-bold">MK</div>
                    <div class="w-10 h-10 rounded-full border-2 border-ink bg-gray-600 flex items-center justify-center text-[10px] font-bold">SZ</div>
                    <div class="w-10 h-10 rounded-full border-2 border-ink bg-gold text-ink flex items-center justify-center text-[10px] font-bold">+2k</div>
                    </div>
                </div>
                </div>
    
                <!-- Right Side: Visual -->
                <div class="order-1 lg:order-2 flex justify-center perspective-2000">
                <div class="relative group">
                    
                    <!-- Minimalist Reflection / Platform (Tighter on Mobile) -->
                    <div class="absolute -bottom-4 md:-bottom-12 left-1/2 -translate-x-1/2 w-3/4 h-2 bg-gold/20 blur-2xl rounded-full scale-x-150"></div>
                    
                    <!-- Book Wrapper -->
                    <div class="relative animate-float-book transform-style-3d rotate-y-[-15deg] group-hover:rotate-y-0 transition-all duration-[1.2s] ease-out">
                    <img src="{{ asset('images/THE GEN Z HUSTLE.png') }}" 
                            alt="The Gen Z Hustle Book Cover" 
                            class="w-[300px] md:w-[420px] h-auto rounded-r-lg book-shadow relative z-10">
                    
                    <!-- Luxury Lens Flare -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-gold/20 blur-[60px] rounded-full pointer-events-none mix-blend-screen"></div>
                    </div>
    
                    <!-- Dynamic floating badge -->
                    <div class="absolute -top-6 -left-6 z-20 bg-ink-900/80 backdrop-blur-xl border border-gold/30 px-5 py-4 rounded-2xl shadow-2xl animate-bounce" style="animation-duration: 4s">
                    <div class="flex items-center gap-3">
                        <div class="text-3xl">🔥</div>
                        <div>
                        <div class="text-white font-syne font-black text-sm leading-none">HIGH DEMAND</div>
                        <div class="text-gold text-[10px] font-bold tracking-tighter mt-1 uppercase">Limited Copies Left</div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
    
            <!-- Bottom Subtle Divider -->
            <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 1px; background: linear-gradient(to right, transparent, #f3f4f6, transparent);"></div>
        </section>

        <!-- Choose Your Aesthetic - Template Showcase -->
        <section id="templates" class="bg-white py-24 relative overflow-hidden">
            <!-- Soft background -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[900px] h-[400px] bg-gradient-to-r from-[#fff9ed] via-[#ffebd6] to-[#fff9ed] opacity-60 blur-3xl -z-10 rounded-full"></div>

            <div class="mx-auto max-w-7xl px-6">
                <!-- Header -->
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#f2b311]/30 bg-[#fff9ed] px-4 py-1.5 text-xs font-bold text-[#ed8b00] mb-5 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#f28b11] animate-pulse"></span>
                        50+ PREMIUM TEMPLATES
                    </div>
                    <h2 class="text-3xl font-extrabold tracking-tight md:text-4xl text-[#1e1b20]">Choose Your <span class="bg-gradient-to-r from-[#f28b11] to-[#f2b311] bg-clip-text text-transparent">Aesthetic</span></h2>
                    <p class="mt-4 text-[#5e5963] text-lg">Every template is built to convert — designed to impress recruiters, clients, and collaborators on sight.</p>
                </div>

                <!-- Template Cards Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8" id="template-gallery">

                    <!-- Card 1: Marcus -->
                    <div class="group relative bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(242,139,17,0.15)]">
                        <!-- Screenshot -->
                        <div class="relative overflow-hidden h-64 select-none" oncontextmenu="return false;">
                            <img src="{{ asset('images/template-marcus.png') }}"
                                alt="Creative Gradient Template"
                                class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                                draggable="false">
                            <!-- Hover overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-5">
                                <button onclick="openPreview('{{ asset('templates/template-3/index.html') }}')"
                                    class="bg-white text-[#f28b11] font-bold text-xs px-5 py-2.5 rounded-full shadow-xl hover:bg-[#f28b11] hover:text-white transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Live Preview
                                </button>
                            </div>
                        </div>
                        <!-- Card Footer -->
                        <div class="p-5 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-extrabold text-[#1e1b20]">Creative Gradient</div>
                                <div class="text-xs text-[#9ca3af] mt-0.5">Bold • Colourful • Gen Z</div>
                            </div>
                            <button onclick="openPreview('{{ asset('templates/template-3/index.html') }}')"
                                class="text-xs font-bold text-[#f28b11] border border-[#f28b11]/30 px-4 py-1.5 rounded-full hover:bg-[#f28b11] hover:text-white transition-all duration-200">
                                Preview
                            </button>
                        </div>
                    </div>

                    <!-- Card 2: Zara -->
                    <div class="group relative bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(242,139,17,0.15)]">
                        <div class="relative overflow-hidden h-64 select-none" oncontextmenu="return false;">
                            <img src="{{ asset('images/template-zara.png') }}"
                                alt="Glassmorphism Template"
                                class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                                draggable="false">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-5">
                                <button onclick="openPreview('{{ asset('templates/template-4/index.html') }}')"
                                    class="bg-white text-[#f28b11] font-bold text-xs px-5 py-2.5 rounded-full shadow-xl hover:bg-[#f28b11] hover:text-white transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Live Preview
                                </button>
                            </div>
                        </div>
                        <div class="p-5 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-extrabold text-[#1e1b20]">Glassmorphism</div>
                                <div class="text-xs text-[#9ca3af] mt-0.5">Elegant • Frosted • Minimal</div>
                            </div>
                            <button onclick="openPreview('{{ asset('templates/template-4/index.html') }}')"
                                class="text-xs font-bold text-[#f28b11] border border-[#f28b11]/30 px-4 py-1.5 rounded-full hover:bg-[#f28b11] hover:text-white transition-all duration-200">
                                Preview
                            </button>
                        </div>
                    </div>

                    <!-- Card 3: Alex -->
                    <div class="group relative bg-white rounded-2xl border border-gray-100 shadow-lg overflow-hidden hover:-translate-y-2 transition-all duration-500 hover:shadow-[0_20px_60px_rgba(242,139,17,0.15)]">
                        <div class="relative overflow-hidden h-64 select-none" oncontextmenu="return false;">
                            <img src="{{ asset('images/template-alex.png') }}"
                                alt="Neon Dark Template"
                                class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                                draggable="false">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-5">
                                <button onclick="openPreview('{{ asset('templates/template-1/index.html') }}')"
                                    class="bg-white text-[#f28b11] font-bold text-xs px-5 py-2.5 rounded-full shadow-xl hover:bg-[#f28b11] hover:text-white transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.641 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Live Preview
                                </button>
                            </div>
                        </div>
                        <div class="p-5 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-extrabold text-[#1e1b20]">Neon Dark</div>
                                <div class="text-xs text-[#9ca3af] mt-0.5">Dark • Electric • Developer</div>
                            </div>
                            <button onclick="openPreview('{{ asset('templates/template-1/index.html') }}')"
                                class="text-xs font-bold text-[#f28b11] border border-[#f28b11]/30 px-4 py-1.5 rounded-full hover:bg-[#f28b11] hover:text-white transition-all duration-200">
                                Preview
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Bottom CTA -->
                <div class="mt-14 text-center">
                    <p class="text-[#9ca3af] text-sm mb-4">These are just 3 of 50+ templates waiting for you.</p>
                    <a href="{{ route('register') }}" class="ha-btn inline-flex items-center gap-3 px-8 py-4 text-base shadow-xl shadow-maroon/10">
                        Unlock All Templates
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Preview Modal -->
        <div id="preview-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4" style="background: rgba(0,0,0,0.85); backdrop-filter: blur(6px);">
            <div class="relative w-full max-w-6xl h-[85vh] bg-white rounded-2xl overflow-hidden shadow-2xl flex flex-col">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100 shrink-0">
                    <div class="flex gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <div class="text-xs font-mono text-gray-400">ha-tech.preview — read only</div>
                    <button onclick="closePreview()" class="w-8 h-8 rounded-full bg-gray-200 hover:bg-red-100 hover:text-red-500 flex items-center justify-center text-gray-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <!-- Iframe + Blocker Overlay -->
                <div class="relative flex-1 overflow-hidden">
                    <iframe id="preview-iframe" src="" class="w-full h-full border-0" sandbox="allow-scripts allow-same-origin" title="Template Preview"></iframe>
                    <!-- Transparent overlay to block right-click and text selection inside iframe -->
                    <div class="absolute inset-0 z-10 select-none" oncontextmenu="return false;" style="pointer-events: none; background: transparent;"></div>
                </div>
                <!-- Sign up nudge -->
                <div class="px-5 py-3 bg-[#fff9ed] border-t border-[#f2b311]/20 text-center text-xs text-[#ed8b00] font-semibold shrink-0">
                    🔒 Want this template? <a href="{{ route('register') }}" class="underline font-bold hover:text-[#f28b11]">Sign up free</a> to generate your own version instantly.
                </div>
            </div>
        </div>

    </main>

    <!-- ═══════════════════════════════════════════════════════════
         PRICING SECTION
    ═══════════════════════════════════════════════════════════ -->
    <section id="pricing" class="relative py-28 overflow-hidden" style="background: #0a0a10;">

        <!-- Background effects -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] rounded-full blur-[120px] opacity-20" style="background: radial-gradient(ellipse, #f28b11 0%, transparent 70%);"></div>
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(255,255,255,0.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.8) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-6">

            <!-- Live Rate Ticker -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex items-center gap-3 bg-white/5 border border-white/10 rounded-full px-5 py-2.5 text-xs text-white/60">
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span class="font-bold text-white/80">LIVE RATE</span>
                    </span>
                    <span class="text-white/30">|</span>
                    <span>1 USD = <span id="live-rate-display" class="text-[#f2b311] font-black">Loading...</span> PKR</span>
                    <span class="text-white/30">|</span>
                    <span id="rate-change-indicator" class="font-semibold"></span>
                    <span class="text-white/30">|</span>
                    <a href="https://finance.yahoo.com/quote/USDPKR=X/" target="_blank" class="text-white/30 hover:text-[#f28b11] transition-colors text-[10px] tracking-wider">Yahoo Finance ↗</a>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center max-w-2xl mx-auto mb-8">
                <div class="inline-flex items-center gap-2 rounded-full border border-[#f2b311]/30 bg-[#f2b311]/10 px-4 py-1.5 text-xs font-bold text-[#f2b311] mb-6 tracking-widest uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f28b11] animate-pulse"></span>
                    Simple, Transparent Pricing
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                    Invest in Your <span style="background: linear-gradient(135deg, #f28b11, #f2b311); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Empire</span>
                </h2>
                <p class="mt-5 text-white/50 text-lg leading-relaxed">One payment. Lifetime-changing results. Choose the plan that matches your ambition.</p>
            </div>

            <!-- Currency Toggle -->
            <div class="flex justify-center mb-12">
                <div class="inline-flex items-center bg-white/5 border border-white/10 rounded-full p-1" role="group">
                    <button id="btn-pkr" onclick="setCurrency('PKR')"
                        class="px-6 py-2 rounded-full text-sm font-black transition-all duration-300 bg-gradient-to-r from-[#f28b11] to-[#f2b311] text-black">
                        ₨ PKR
                    </button>
                    <button id="btn-usd" onclick="setCurrency('USD')"
                        class="px-6 py-2 rounded-full text-sm font-black transition-all duration-300 text-white/50 hover:text-white">
                        $ USD
                    </button>
                </div>
            </div>

            <!-- Pricing Cards -->
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8 items-start">

                <!-- Plan 1: Starter -->
                <div class="group relative rounded-2xl border border-white/10 p-8 transition-all duration-500 hover:-translate-y-2 hover:border-[#f28b11]/40 hover:shadow-[0_20px_60px_rgba(242,139,17,0.1)]" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px);">
                    <div class="text-xs font-black tracking-[0.2em] text-white/30 uppercase mb-4">Personal Branding</div>
                    <div class="text-xl font-black text-white mb-1">The Starter</div>
                    <div class="flex items-end gap-1 mt-4 mb-6">
                        <span class="text-4xl font-black text-white price-display" data-usd="9">₨ 2,500</span>
                        <span class="text-white/40 text-sm mb-1.5 period-display">/ Month</span>
                    </div>
                    <ul class="space-y-3.5 mb-8">
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Full Access to Portfolio Generator
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            10+ Premium Personal Templates
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Instant ZIP Downloads
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Standard Support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full text-center py-3.5 rounded-xl border border-white/20 text-white text-sm font-bold hover:bg-white/10 transition-all duration-300">
                        Get Started
                    </a>
                </div>

                <!-- Plan 2: Freelancer (MOST POPULAR) -->
                <div class="relative rounded-2xl p-8 transition-all duration-500 hover:-translate-y-2" style="background: linear-gradient(145deg, #1a1008, #0f0a02); border: 1px solid #f2b311; box-shadow: 0 0 80px rgba(242,139,17,0.2), inset 0 1px 0 rgba(242,179,17,0.2);">
                    <!-- Most Popular Badge -->
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-[#f28b11] to-[#f2b311] text-black text-[10px] font-black tracking-widest uppercase px-5 py-1.5 rounded-full shadow-lg">
                        ⚡ Most Popular
                    </div>
                    <div class="flex items-center gap-3 mb-4 mt-2">
                        <img src="{{ asset('HA-Tech.png') }}" class="w-8 h-8 object-contain shrink-0 drop-shadow-[0_0_10px_rgba(242,139,17,0.3)]" alt="HA Tech">
                        <div class="text-xs font-black tracking-[0.2em] text-[#f2b311]/60 uppercase">Agency in a Box</div>
                    </div>
                    <div class="text-xl font-black text-white mb-1">The Freelancer</div>
                    <div class="flex items-end gap-1 mt-4 mb-6">
                        <span class="text-4xl font-black text-white price-display" data-usd="39">&#x20a8; 10,900</span>
                        <span class="text-white/40 text-sm mb-1.5 period-display">/ 6 Months</span>
                    </div>
                    <ul class="space-y-3.5 mb-8">
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            <span><span style="-webkit-text-fill-color: #f2b311; font-weight: 800;">Unlimited</span> Website Generations</span>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Access to All Categories (Gym, Business, SaaS…)
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            50+ Elite Industry Templates
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Commercial License (Sell to Clients)
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/80">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Advanced Theme Customization
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="group block w-full text-center py-3.5 rounded-xl text-black text-sm font-black transition-all duration-300 hover:opacity-90 hover:shadow-[0_0_30px_rgba(242,139,17,0.5)]" style="background: linear-gradient(135deg, #f28b11, #f2b311);">
                        <img src="{{ asset('HA-Tech.png') }}" class="w-10 h-10 object-contain drop-shadow-[0_0_15px_rgba(242,139,17,0.4)] transition-all group-hover:scale-105" alt="HA Tech">
                        Upgrade to Pro
                    </a>
                </div>

                <!-- Plan 3: Agency Boss -->
                <div class="group relative rounded-2xl border border-white/10 p-8 transition-all duration-500 hover:-translate-y-2 hover:border-[#f28b11]/40 hover:shadow-[0_20px_60px_rgba(242,139,17,0.1)]" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px);">
                    <!-- Best Value Badge -->
                    <div class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-white/60 text-[10px] font-black tracking-widest uppercase px-3 py-1 rounded-full mb-4">
                        🏆 Best Value
                    </div>
                    <div class="text-xs font-black tracking-[0.2em] text-white/30 uppercase mb-1">Unlimited Growth</div>
                    <div class="text-xl font-black text-white mb-1">The Agency Boss</div>
                    <div class="flex items-end gap-1 mt-4 mb-6">
                        <span class="text-4xl font-black text-white price-display" data-usd="59">&#x20a8; 16,500</span>
                        <span class="text-white/40 text-sm mb-1.5 period-display">/ Year</span>
                    </div>
                    <ul class="space-y-3.5 mb-8">
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Everything in Freelancer Plan
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Priority "Founder-Level" Support
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Beta Access to New Templates
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            SEO Optimization Toolkit
                        </li>
                        <li class="flex items-center gap-3 text-sm text-white/70">
                            <span class="w-5 h-5 rounded-full bg-[#f28b11]/20 border border-[#f28b11]/40 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#f28b11]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </span>
                            Exclusive "Client-Closing" Guide (PDF)
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block w-full text-center py-3.5 rounded-xl border border-[#f28b11]/40 text-[#f2b311] text-sm font-bold hover:bg-[#f28b11]/10 transition-all duration-300">
                        Claim Your Empire
                    </a>
                </div>
            </div>

            <!-- ── Comparison Table ─────────────────────────────────── -->
            <div class="mt-24">
                <h3 class="text-center text-2xl font-extrabold text-white mb-3">Plan Comparison</h3>
                <p class="text-center text-white/40 text-sm mb-10">See exactly what you get with each plan</p>

                <div class="overflow-x-auto rounded-2xl border border-white/10" style="background: rgba(255,255,255,0.03);">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10">
                                <th class="text-left px-6 py-5 text-white/40 font-semibold w-1/2">Feature</th>
                                <th class="px-6 py-5 text-center text-white/60 font-bold">Starter<br><span class="text-[#f28b11] font-black">$9/mo</span></th>
                                <th class="px-6 py-5 text-center font-bold" style="background: rgba(242,139,17,0.08);">
                                    <span class="text-[#f2b311]">Freelancer</span><br><span class="text-[#f28b11] font-black">$39/6mo</span>
                                </th>
                                <th class="px-6 py-5 text-center text-white/60 font-bold">Agency Boss<br><span class="text-[#f28b11] font-black">$59/yr</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @php
                            $rows = [
                                ['Portfolio Generator Access', true, true, true],
                                ['Personal Templates (10+)', true, true, true],
                                ['Instant ZIP Downloads', true, true, true],
                                ['Standard Support', true, true, true],
                                ['Unlimited Generations', false, true, true],
                                ['All Categories (Gym, SaaS, Business…)', false, true, true],
                                ['50+ Elite Templates', false, true, true],
                                ['Commercial License', false, true, true],
                                ['Advanced Theme Customization', false, true, true],
                                ['Priority Founder-Level Support', false, false, true],
                                ['Beta Access to New Templates', false, false, true],
                                ['SEO Optimization Toolkit', false, false, true],
                                ['Client-Closing PDF Guide', false, false, true],
                            ];
                            @endphp
                            @foreach($rows as $row)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-4 text-white/60">{{ $row[0] }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($row[1])
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-500/20 text-green-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500/20 text-red-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center" style="background: rgba(242,139,17,0.05);">
                                    @if($row[2])
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-[#f28b11]/30 text-[#f2b311]">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500/20 text-red-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row[3])
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-500/20 text-green-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500/20 text-red-400">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

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

    <script>
        // ── Preview Modal ──────────────────────────────────────────────
        function openPreview(url) {
            const modal = document.getElementById('preview-modal');
            document.getElementById('preview-iframe').src = url;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closePreview() {
            const modal = document.getElementById('preview-modal');
            document.getElementById('preview-iframe').src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Close on backdrop click
        document.getElementById('preview-modal').addEventListener('click', function(e) {
            if (e.target === this) closePreview();
        });

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePreview();
        });

        // ── Global Right-Click Protection on template images ──────────
        document.querySelectorAll('#template-gallery img').forEach(function(img) {
            img.addEventListener('contextmenu', function(e) { e.preventDefault(); return false; });
            img.addEventListener('dragstart', function(e) { e.preventDefault(); return false; });
        });

        // ══════════════════════════════════════════════════
        // LIVE USD/PKR CURRENCY CONVERTER
        // ══════════════════════════════════════════════════
        let currentRate = 278; // fallback rate
        let currentCurrency = 'PKR';

        // Fetch live rate
        async function fetchLiveRate() {
            try {
                const res = await fetch('https://open.er-api.com/v6/latest/USD');
                const data = await res.json();
                if (data && data.rates && data.rates.PKR) {
                    currentRate = data.rates.PKR;
                    document.getElementById('live-rate-display').textContent = currentRate.toFixed(2);

                    // Show change indicator
                    const indicator = document.getElementById('rate-change-indicator');
                    indicator.textContent = '≈ Market Rate';
                    indicator.style.color = '#4ade80';

                    // Update prices based on current currency selection
                    updatePrices();
                }
            } catch (e) {
                // Use fallback rate
                document.getElementById('live-rate-display').textContent = currentRate.toFixed(2) + ' (est.)';
                updatePrices();
            }
        }

        // Update all price displays
        function updatePrices() {
            document.querySelectorAll('.price-display').forEach(function(el) {
                const usd = parseFloat(el.getAttribute('data-usd'));
                if (currentCurrency === 'PKR') {
                    const pkr = Math.round(usd * currentRate);
                    el.textContent = '\u20a8 ' + pkr.toLocaleString('en-PK');
                } else {
                    el.textContent = '$' + usd;
                }
                // Fade animation
                el.style.opacity = '0';
                el.style.transform = 'translateY(-4px)';
                setTimeout(function() {
                    el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, 50);
            });
        }

        // Toggle currency
        function setCurrency(currency) {
            currentCurrency = currency;
            updatePrices();

            // Update button styles
            const btnPkr = document.getElementById('btn-pkr');
            const btnUsd = document.getElementById('btn-usd');

            if (currency === 'PKR') {
                btnPkr.style.cssText = 'background: linear-gradient(135deg, #f28b11, #f2b311); color: black;';
                btnUsd.style.cssText = 'background: transparent; color: rgba(255,255,255,0.4);';
            } else {
                btnUsd.style.cssText = 'background: linear-gradient(135deg, #f28b11, #f2b311); color: black;';
                btnPkr.style.cssText = 'background: transparent; color: rgba(255,255,255,0.4);';
            }
        }

        // Init
        fetchLiveRate();
        // Refresh every 5 minutes
        setInterval(fetchLiveRate, 300000);
    </script>
    </div>
</body>
</html>
