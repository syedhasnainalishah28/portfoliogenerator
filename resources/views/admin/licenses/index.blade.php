@extends('admin.layout')
@section('title', 'Vault Management')
@section('page-title', 'Vault Analytics')

@section('content')
<div class="space-y-10">
    <div class="flex gap-6 mb-8 flex-wrap items-center justify-between">
        {{-- Search + Filter --}}
        <form method="GET" class="flex gap-4 flex-wrap items-center bg-white/[0.02] p-2 rounded-2x border border-white/5 backdrop-blur-md">
            <div class="relative group">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-white/20 group-focus-within:text-[#D4A853] transition-colors"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search signature, user, mail..."
                    class="ha-input !pl-12 !py-3 !px-6 w-64 md:w-96 border-none bg-white/[0.03] shadow-none focus:bg-white/[0.05]">
            </div>
            
            <div class="h-8 w-px bg-white/10 mx-2 hidden sm:block"></div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.licenses.index') }}" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all {{ !request('status') ? 'bg-white/10 text-white' : 'text-white/30 hover:text-white hover:bg-white/5' }}">Static</a>
                @foreach(['active','expired','unused'] as $s)
                <a href="{{ route('admin.licenses.index', ['status' => $s] + request()->except('status')) }}"
                    class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all {{ request('status') === $s ? 'badge-'.$s : 'text-white/30 hover:text-white hover:bg-white/5' }}">
                    {{ $s }}
                </a>
                @endforeach
            </div>
        </form>

        <a href="{{ route('admin.licenses.generate') }}" class="ha-btn-gold !py-3.5 !px-8 flex items-center gap-3">
            <i class="fas fa-plus text-[10px]"></i>
            Forge Key
        </a>
    </div>

    <!-- License Vault -->
    <div class="table-container">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="table-th">Cryptographic Signature</th>
                    <th class="table-th">Assigned Agent</th>
                    <th class="table-th">Framework Tier</th>
                    <th class="table-th">Deployment</th>
                    <th class="table-th">Expiry Node</th>
                    <th class="table-th">Status</th>
                    <th class="table-th text-right">Modifications</th>
                </tr>
            </thead>
            <tbody>
                @forelse($licenses as $license)
                <tr class="table-row">
                    <td class="table-td">
                        <div class="font-mono text-[11px] font-black tracking-[0.2em] text-[#D4A853]">
                            {{ $license->license_key }}
                        </div>
                    </td>
                    <td class="table-td">
                        @if($license->user)
                            <div class="font-bold text-white text-sm">{{ $license->user->name }}</div>
                            <div class="text-[10px] text-white/30 font-black uppercase tracking-wider mt-0.5">{{ $license->user->email }}</div>
                        @else
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 bg-white/[0.03] border border-white/5 rounded text-[9px] font-black uppercase tracking-widest text-white/20">
                                <i class="fas fa-unlink"></i>
                                Unbound
                            </div>
                        @endif
                    </td>
                    <td class="table-td">
                        <span class="text-xs font-bold text-white/70">{{ $license->plan->name }}</span>
                    </td>
                    <td class="table-td">
                        <div class="text-[10px] font-black uppercase text-white/30 tracking-widest">
                            <i class="far fa-calendar-check mr-1.5 text-white/10"></i>
                            {{ $license->activated_at ? $license->activated_at->format('d M y') : 'N/A' }}
                        </div>
                    </td>
                    <td class="table-td text-[11px] font-bold {{ $license->isExpired() ? 'text-red-500/60' : 'text-emerald-500/60' }}">
                        {{ $license->expires_at?->format('d M y') ?? '—' }}
                    </td>
                    <td class="table-td">
                        <span class="badge badge-{{ $license->status_badge }}">
                            {{ $license->status_badge }}
                        </span>
                    </td>
                    <td class="table-td">
                        <div class="flex items-center justify-end gap-4">
                            {{-- Extend Flow --}}
                            <form method="POST" action="{{ route('admin.licenses.extend', $license) }}" class="flex items-center bg-white/[0.03] p-1 border border-white/5 rounded-xl">
                                @csrf
                                <input type="number" name="months" value="1" min="1" max="24"
                                    class="w-10 bg-transparent border-none text-center text-[11px] font-black text-white focus:outline-none">
                                <button type="submit" class="px-4 py-2 bg-[#D4A853] text-[#050508] text-[9px] font-black uppercase tracking-widest rounded-lg hover:brightness-110 transition-all">Extend</button>
                            </form>
                            
                            {{-- Termination --}}
                            <form method="POST" action="{{ route('admin.licenses.expire', $license) }}">
                                @csrf
                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-500/5 border border-red-500/10 text-red-500/40 hover:text-red-500 hover:bg-red-500/10 transition-all" onclick="return confirm('Kill this license instantly?')">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="table-td text-center py-24">
                        <i class="fas fa-key text-4xl text-white/5 mb-4 block"></i>
                        <span class="text-white/20 font-black uppercase tracking-widest text-xs">No records found in the vault.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($licenses->hasPages())
    <div class="mt-8">
        {{ $licenses->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
