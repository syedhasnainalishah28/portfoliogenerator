@extends('admin.layout')
@section('title', 'Intelligence Center')
@section('page-title', 'Active Agents')

@section('content')
<div class="space-y-8" x-data="{ 
    showEmailModal: false, 
    selectedUser: {id: null, name: '', email: ''}
}"
@open-communication-modal.window="showEmailModal = true; selectedUser = $event.detail">

    <!-- Active Agents Table -->
    <div class="bg-brand-panel border border-white/5 rounded-2xl overflow-hidden backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-white/[0.02] border-b border-white/5 text-[10px] font-bold uppercase tracking-widest text-white/30">
                        <th class="px-6 py-5 text-center w-24"># ID</th>
                        <th class="px-6 py-5">Agent Identity</th>
                        <th class="px-6 py-5">Access Tier</th>
                        <th class="px-6 py-5">Onboarded</th>
                        <th class="px-6 py-5 text-right w-32">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    @foreach($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <span class="font-mono text-xs font-semibold text-white/30">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-brand-gold/10 flex items-center justify-center text-brand-gold font-bold text-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-white group-hover:text-brand-gold transition-colors">{{ $user->name }}</span>
                                    <span class="text-[10px] font-bold tracking-wider uppercase text-white/30 mt-0.5">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->hasActiveLicense())
                                <div class="flex flex-col gap-1.5">
                                    <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-lg text-[9px] font-bold uppercase tracking-widest w-fit">
                                        {{ $user->license->plan->name }}
                                    </span>
                                    <span class="text-[9px] text-white/30 font-semibold tracking-wider flex items-center gap-1.5">
                                        <i class="far fa-clock"></i> Expires: {{ $user->license_expires_at->format('M d, Y') }}
                                    </span>
                                </div>
                            @else
                                <span class="bg-white/5 text-white/40 border border-white/10 px-3 py-1 rounded-lg text-[9px] font-bold uppercase tracking-widest w-fit">
                                    No Active Auth
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold text-white/50">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <!-- Bulletproof button using alpine dispatch -->
                            <button 
                                type="button"
                                @click="$dispatch('open-communication-modal', { id: {{ $user->id }}, name: '{{ addslashes($user->name) }}', email: '{{ addslashes($user->email) }}' })"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-gold/10 text-brand-gold hover:bg-brand-gold/20 text-xs font-bold uppercase tracking-wider transition-colors"
                            >
                                <i class="fas fa-satellite-dish"></i> Ping
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
    <div class="mt-8">
        {{ $users->links() }}
    </div>
    @endif

    <!-- Fully Isolated Communication Modal -->
    <template x-teleport="body">
        <div x-show="showEmailModal" class="relative z-[9999]" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div x-show="showEmailModal" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-brand-dark/95 backdrop-blur-sm transition-opacity"
                 @click="showEmailModal = false">
            </div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <!-- Modal Panel -->
                    <div x-show="showEmailModal"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         class="relative transform overflow-hidden rounded-3xl bg-brand-surface border border-brand-gold/20 text-left shadow-[0_0_50px_rgba(212,168,83,0.1)] transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                        
                        <div class="p-8 sm:p-10">
                            <!-- Close Btn -->
                            <button @click="showEmailModal = false" class="absolute top-8 right-8 w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-white/40 hover:text-white hover:bg-white/10 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>

                            <div class="flex items-center gap-4 mb-8">
                                <div class="w-12 h-12 rounded-xl bg-brand-gold/10 flex items-center justify-center text-brand-gold text-lg">
                                    <i class="fas fa-tower-broadcast"></i>
                                </div>
                                <div>
                                    <h3 class="font-syne font-bold text-white text-2xl" id="modal-title">Signal Dispatch</h3>
                                    <p class="text-[10px] text-brand-gold font-bold uppercase tracking-widest mt-1">Target: <span x-text="selectedUser.name"></span> (<span x-text="selectedUser.email"></span>)</p>
                                </div>
                            </div>

                            <form :action="'{{ route('admin.users.index') }}/' + selectedUser.id + '/email'" method="POST" class="space-y-6">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-2">Payload Header (Subject)</label>
                                    <input type="text" name="subject" value="VIP Update from HA Tech" required 
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3.5 text-sm text-white placeholder-white/20 focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-bold uppercase tracking-widest text-white/40 mb-2">Transmission Body (HTML Enabled)</label>
                                    <textarea name="body" rows="6" required 
                                        class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-4 text-xs font-mono text-brand-gold/80 placeholder-white/20 focus:outline-none focus:border-brand-gold/50 focus:ring-1 focus:ring-brand-gold/50 transition-all leading-relaxed"><b>Hi User,</b><br><br>We have exciting news regarding your HA Tech portfolio generator access...<br><br>Check out your <a href="{{ route('dashboard') }}">VVIP Dashboard</a> now for the latest templates.</textarea>
                                </div>

                                <div class="flex gap-4 pt-4 mt-8 border-t border-white/5">
                                    <button type="button" @click="showEmailModal = false" class="flex-1 py-4 rounded-xl border border-white/10 text-white/60 text-xs font-bold uppercase tracking-widest hover:bg-white/5 transition-colors">
                                        Abort
                                    </button>
                                    <button type="submit" class="flex-[2] py-4 rounded-xl bg-brand-gold text-black text-xs font-bold uppercase tracking-widest hover:brightness-110 shadow-lg shadow-brand-gold/20 transition-all">
                                        Establish Uplink
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection
