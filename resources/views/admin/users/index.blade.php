@extends('admin.layout')
@section('title', 'User Intelligence')
@section('page-title', 'Active Agents')

@section('content')
<div class="space-y-10" x-data="{ 
    showEmailModal: false, 
    selectedUser: {id: null, name: '', email: ''},
    openEmailModal(id, name, email) {
        this.selectedUser = {id, name, email};
        this.showEmailModal = true;
    }
}">
    <!-- User List Table -->
    <div class="table-container">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="table-th">Agent Identity</th>
                    <th class="table-th">Subscription Status</th>
                    <th class="table-th">Commencement Date</th>
                    <th class="table-th text-right">Operations</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="table-row">
                    <td class="table-td">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center text-[#D4A853] font-black text-sm shadow-inner">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-white text-base">{{ $user->name }}</div>
                                <div class="text-[11px] text-white/30 tracking-[0.05em] uppercase font-bold mt-0.5">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="table-td">
                        @if($user->hasActiveLicense())
                            <div class="flex flex-col gap-1.5">
                                <span class="badge badge-active w-fit">
                                    {{ $user->license->plan->name }}
                                </span>
                                <span class="text-[10px] text-white/20 font-black uppercase tracking-widest flex items-center gap-1.5">
                                    <i class="far fa-clock"></i>
                                    Expires: {{ $user->license_expires_at->format('M d, Y') }}
                                </span>
                            </div>
                        @else
                            <span class="badge badge-rejected w-fit">
                                No Active License
                            </span>
                        @endif
                    </td>
                    <td class="table-td">
                        <div class="text-xs font-bold text-white/50 tracking-wide">
                            <i class="far fa-calendar-alt mr-2 text-white/20"></i>
                            {{ $user->created_at->format('M d, Y') }}
                        </div>
                    </td>
                    <td class="table-td text-right">
                        <button 
                            @click="openEmailModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}')"
                            class="ha-btn-outline !py-3 !px-5 flex items-center gap-3 ml-auto hover:bg-[#D4A853]/5 hover:text-[#D4A853] hover:border-[#D4A853]/20"
                        >
                            <i class="fas fa-paper-plane text-[10px]"></i>
                            Communications
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="mt-8">
        {{ $users->links() }}
    </div>
    @endif

    <!-- Communication Modal -->
    <template x-if="showEmailModal">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/90 backdrop-blur-md">
            <div 
                @click.away="showEmailModal = false"
                class="w-full max-w-2xl bg-[#090910] border border-white/5 rounded-[40px] shadow-2xl overflow-hidden relative"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <!-- Close Button -->
                <button @click="showEmailModal = false" class="absolute top-8 right-8 text-white/20 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <!-- Header -->
                <div class="p-10 border-b border-white/5">
                    <div class="flex items-center gap-4 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-[#D4A853]/10 flex items-center justify-center text-[#D4A853]">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <h3 class="font-syne font-black text-white text-2xl tracking-tight">Direct Dispatch</h3>
                    </div>
                    <p class="text-[11px] text-white/30 font-bold uppercase tracking-[0.2em]">Target: <span class="text-[#D4A853]" x-text="selectedUser.name"></span> — <span x-text="selectedUser.email"></span></p>
                </div>

                <!-- Form -->
                <form :action="'{{ route('admin.users.index') }}/' + selectedUser.id + '/email'" method="POST" class="p-10 space-y-8">
                    @csrf
                    <div>
                        <label class="ha-label">Payload Subject</label>
                        <input type="text" name="subject" value="VIP Update from HA Tech" required class="ha-input">
                    </div>

                    <div>
                        <label class="ha-label">Transmission Body (HTML Allowed)</label>
                        <textarea name="body" rows="8" required class="ha-input font-mono text-xs leading-relaxed"><b>Hi User,</b><br><br>We have exciting news regarding your HA Tech portfolio generator access...<br><br>Check out your <a href="{{ route('dashboard') }}">VVIP Dashboard</a> now for the latest templates.</textarea>
                        <p class="mt-3 text-[9px] text-white/20 font-bold uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-info-circle text-[#D4A853]"></i>
                            Supports <b>, <i>, <a>, <br> tags.
                        </p>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" @click="showEmailModal = false" class="ha-btn-outline flex-1">Abort Mission</button>
                        <button type="submit" class="ha-btn-gold flex-[2]">Initialize Dispatch</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
