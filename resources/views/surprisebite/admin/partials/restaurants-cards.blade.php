@forelse ($restaurants as $r)
    @php
        $menus = $r->menus ?? collect();
        $mysteryBoxesCount = $menus->count();
    @endphp
    <div class="flex flex-col overflow-hidden rounded-3xl border-2 border-[#f3f4f6] bg-white shadow-lg">
        <div class="relative aspect-[16/10] w-full overflow-hidden bg-slate-100 flex items-center justify-center">
            @if ($r->user && $r->user->avatar_url)
                <img src="{{ $r->user->avatar_url }}" alt="" class="h-full w-full object-cover">
            @else
                <span class="text-slate-400 font-bold text-xl">{{ $r->name }}</span>
            @endif
            <span class="absolute right-3 top-3 rounded-full px-3 py-1 text-xs font-black shadow {{ $r->status === 'unlocked' ? 'bg-emerald-500 text-white' : ($r->status === 'locked' ? 'bg-red-500 text-white' : 'bg-amber-500 text-white') }}">
                {{ $r->status === 'unlocked' ? '✓ Unlocked' : ($r->status === 'locked' ? '🔒 Locked' : 'Pending') }}
            </span>
        </div>
        <div class="flex flex-1 flex-col p-5">
            <h3 class="text-lg font-black text-[#1e2939]">{{ $r->name }}</h3>
            <p class="mt-1 flex items-center gap-1 text-sm font-semibold text-[#6a7282]">
                <x-sb.icon name="map-pin" class="h-4 w-4 shrink-0" /> {{ $r->address_line ?: '—' }}
            </p>
            <p class="mt-2 text-sm text-[#4a5565]">Owner: <strong>{{ $r->user->name ?? 'Unknown' }}</strong></p>
            <p class="mt-2 line-clamp-2 text-sm text-[#4a5565]">{{ \Illuminate\Support\Str::limit($r->description ?? '', 120) }}</p>
            <p class="mt-2 text-xs font-bold text-slate-500">Total Mystery Boxes: {{ $menus->count() }}</p>
            <div class="mt-4 flex flex-wrap gap-2">
                <button type="button"
                        class="edit-btn inline-flex flex-1 items-center justify-center gap-1 rounded-xl bg-gradient-to-r from-[#f97316] to-[#ea580c] px-3 py-2 text-sm font-black text-white"
                        data-json="{{ json_encode([
                            'id' => $r->id,
                            'name' => $r->name,
                            'status' => $r->status,
                        ]) }}">Validasi</button>
                <form method="post" action="{{ route('admin.restaurants.destroy', $r) }}" class="inline"
                      onsubmit="return confirm('Hapus restoran ini? Ini akan menghapus data menu dan order terkait. Lanjutkan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex h-[42px] w-[42px] items-center justify-center rounded-xl border-2 border-red-200 text-red-600 hover:bg-red-50" title="Delete">
                        <x-sb.icon name="x-mark" class="h-5 w-5" />
                    </button>
                </form>
            </div>
        </div>
    </div>
@empty
    <p class="col-span-full mt-4 text-center text-base font-semibold text-[#6a7282]">Tidak ada restoran yang cocok.</p>
@endforelse
