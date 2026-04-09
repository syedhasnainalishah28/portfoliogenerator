<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-black">Your Portfolios</h2></x-slot>
    <div class="p-5 sm:p-8">
        <div class="ha-card overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#fff3e3]">
                    <tr class="text-left">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Template</th>
                        <th class="px-4 py-3">Created</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($portfolios as $portfolio)
                        <tr class="border-t border-[#f0e4d8]">
                            <td class="px-4 py-3 font-semibold">{{ $portfolio->full_name }}</td>
                            <td class="px-4 py-3">{{ $portfolio->template_key }}</td>
                            <td class="px-4 py-3">{{ $portfolio->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('portfolios.download', $portfolio) }}" class="ha-btn inline-block px-3 py-2 text-xs">Download ZIP</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-6 text-center text-[#6d4c3f]">No portfolios yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-4">{{ $portfolios->links() }}</div>
        </div>
    </div>
</x-app-layout>
