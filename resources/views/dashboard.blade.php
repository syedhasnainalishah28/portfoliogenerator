<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold tracking-tight text-[#1e1b20]">Dashboard Overview</h2>
            <div class="flex items-center gap-2 text-sm text-[#5e5963]">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                System Operational
            </div>
        </div>
    </x-slot>

    <div class="p-4 sm:p-8 max-w-7xl mx-auto space-y-6">
        <!-- Welcome Banner -->
        <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#2a080d] to-[#4a0e17] p-6 lg:p-8 text-white shadow-xl shadow-maroon/10">
            <div class="relative z-10">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#f2b311] mb-2">Welcome Back</p>
                <h3 class="text-2xl md:text-3xl font-extrabold tracking-tight">Hi {{ auth()->user()->name }}, let's build something great.</h3>
                <p class="mt-2 text-[#e5e7eb] max-w-xl text-sm leading-relaxed">
                    Access the industry-leading portfolio generator, manage your active templates, and download your latest creations instantly from this unified workspace.
                </p>
            </div>
            <!-- Decals -->
            <div class="absolute right-0 top-0 -translate-y-1/4 translate-x-1/4 w-64 h-64 bg-gradient-to-bl from-[#f28b11] to-transparent rounded-full opacity-20 blur-3xl"></div>
        </section>

        <div class="grid gap-4 lg:gap-6 lg:grid-cols-12">
            <!-- Stats -->
            <section class="ha-card p-5 lg:p-6 lg:col-span-4 flex flex-col justify-center">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#9ca3af]">Total Portfolios</p>
                    <div class="p-2 bg-orange-50 rounded-lg text-[#f28b11]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
                <p class="text-4xl md:text-5xl font-extrabold tracking-tight text-[#1e1b20]">{{ $portfolioCount }}</p>
                
                <div class="mt-6 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#f28b11] to-[#f2b311] rounded-full" style="width: {{ min(100, $portfolioCount * 10) }}%"></div>
                </div>
                <p class="mt-2 text-xs font-medium text-[#5e5963]">Progress towards 10 portfolios milestone</p>
            </section>

            <!-- Activity -->
            <section class="ha-card p-0 lg:col-span-8 overflow-hidden flex flex-col">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h4 class="text-base font-bold text-[#1e1b20]">Recent Activity</h4>
                    <a href="{{ route('portfolios.index') }}" class="text-xs font-semibold text-[#f28b11] hover:underline">View All</a>
                </div>
                
                <div class="divide-y divide-gray-100 flex-1">
                    @forelse($latestPortfolios as $portfolio)
                        <div class="p-4 px-5 hover:bg-gray-50 flex items-center justify-between transition-colors">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold border border-gray-200">
                                    {{ strtoupper(substr($portfolio->full_name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-[#1e1b20] text-sm truncate max-w-[150px] sm:max-w-xs">{{ $portfolio->full_name }}</p>
                                    <p class="text-xs text-[#5e5963] mt-0.5">Template: <span class="font-semibold text-gray-700">{{ str_replace('_', ' ', $portfolio->template_key) }}</span></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800">
                                    Generated
                                </span>
                                <p class="text-[10px] md:text-[11px] text-gray-400 mt-1">{{ $portfolio->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center flex flex-col items-center justify-center h-full">
                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 mb-3 border border-gray-100">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-[#5e5963]">No portfolios generated yet.</p>
                            <a href="{{ route('generator') }}" class="text-[#f28b11] text-sm mt-1 hover:underline font-semibold">Start your first one now</a>
                        </div>
                    @endforelse
                </div>
            </section>
            
            <!-- License Next Phase Tracker -->
            <section class="ha-card p-5 lg:p-6 lg:col-span-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h4 class="text-base font-bold text-[#1e1b20] flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#f2b311]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                            License Verification
                        </h4>
                        <p class="mt-1 text-xs md:text-sm text-[#5e5963] max-w-2xl">
                            License functionality is planned for the next phase of "The Gen Z Hustle" launch. Currently, you have full unrestricted access to the generator.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
