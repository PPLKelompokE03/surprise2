<x-layouts.admin title="Restaurant Management" active="restaurants">
    <div class="rounded-[24px] border-2 border-[#f3f4f6] bg-white p-6 shadow-[0_20px_25px_-5px_rgba(0,0,0,0.1),0_8px_10px_-6px_rgba(0,0,0,0.1)] sm:p-8"
         style="background-image: linear-gradient(141.254deg, rgb(249, 250, 251) 0%, rgba(255, 247, 237, 0.35) 100%);">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-base font-bold text-[#4a5565] hover:text-[#f97316]">
            <span class="text-lg" aria-hidden="true">←</span>
            Back to Admin Dashboard
        </a>

        <div class="mt-4 flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black tracking-tight text-[#1e2939] sm:text-4xl">Restaurant Management</h2>
                <p class="mt-1 text-base font-semibold text-[#4a5565]">Kelola restoran &amp; mystery boxes</p>
            </div>
            <button type="button" onclick="document.getElementById('dlg-add').showModal()"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#f97316] to-[#ea580c] px-6 py-3 text-base font-black text-white shadow-lg hover:opacity-95">
                <span aria-hidden="true">+</span> Add Restaurant
            </button>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border-2 border-orange-100 bg-white px-6 py-5 shadow-md">
                <p class="text-sm font-bold text-[#4a5565]">Total Restaurants</p>
                <p class="mt-2 text-4xl font-black text-[#f97316]" id="rt-rest-total">{{ number_format($stats['total_restaurants']) }}</p>
            </div>
            <div class="rounded-2xl border-2 border-emerald-100 bg-white px-6 py-5 shadow-md">
                <p class="text-sm font-bold text-[#4a5565]">Total Mystery Boxes</p>
                <p class="mt-2 text-4xl font-black text-[#00a63e]" id="rt-rest-boxes">{{ number_format($stats['total_boxes']) }}</p>
            </div>
            <div class="rounded-2xl border-2 border-sky-100 bg-white px-6 py-5 shadow-md">
                <p class="text-sm font-bold text-[#4a5565]">Active Restaurants</p>
                <p class="mt-2 text-4xl font-black text-[#0284c7]" id="rt-rest-active">{{ number_format($stats['active']) }}</p>
            </div>
            <div class="rounded-2xl border-2 border-violet-100 bg-white px-6 py-5 shadow-md">
                <p class="text-sm font-bold text-[#4a5565]">Pending Approval</p>
                <p class="mt-2 text-4xl font-black text-[#7c3aed]" id="rt-rest-pending">{{ number_format($stats['pending']) }}</p>
            </div>
        </div>

        <form method="get" action="{{ route('admin.restaurants') }}" class="mt-8">
            <div class="relative">
                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><x-sb.icon name="search" class="h-5 w-5" /></span>
                <input type="search" name="q" value="{{ $q }}"
                       placeholder="Search restaurants by name or location..."
                       class="w-full rounded-[14px] border-2 border-[#e5e7eb] py-3 pl-12 pr-4 text-base font-semibold text-[#1e2939] placeholder:text-[#71717a]/70 focus:border-[#f97316] focus:outline-none focus:ring-2 focus:ring-[#f97316]/25" />
            </div>
        </form>

        <div id="rt-restaurants-grid" class="mt-8 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
            @include('surprisebite.admin.partials.restaurants-cards', ['restaurants' => $restaurants, 'money' => $money])
        </div>
    </div>

    <dialog id="dlg-edit" class="w-full max-w-sm rounded-3xl border-2 border-slate-200 p-0 shadow-2xl backdrop:bg-slate-900/40">
        <form id="form-edit" method="post" class="p-6">
            @csrf
            @method('PUT')
            <h3 class="text-xl font-black text-slate-900">Validasi Mitra</h3>
            <p class="mt-2 text-sm text-slate-600" id="edit-restaurant-name"></p>
            <div class="mt-4 space-y-3">
                <label class="block text-sm font-bold text-slate-700">Status Akses
                    <select name="status" id="edit-status" class="mt-1 w-full rounded-xl border-2 border-slate-200 px-3 py-2 font-semibold">
                        <option value="unlocked">Sah (Unlocked)</option>
                        <option value="locked">Kunci Akses (Locked)</option>
                        <option value="pending">Menunggu (Pending)</option>
                    </select>
                </label>
                <p class="text-xs text-slate-500">Jika dikunci (locked), mitra tidak akan bisa beroperasi.</p>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('dlg-edit').close()" class="rounded-xl bg-slate-200 px-5 py-2.5 text-sm font-black text-slate-800">Batal</button>
                <button type="submit" class="rounded-xl bg-gradient-to-r from-[#f97316] to-[#ea580c] px-5 py-2.5 text-sm font-black text-white">Simpan</button>
            </div>
        </form>
    </dialog>

    <script>
        document.addEventListener('click', function (e) {
            var btn = e.target.closest('.edit-btn');
            if (!btn || !btn.closest('#rt-restaurants-grid')) return;
            var d = JSON.parse(btn.getAttribute('data-json'));
            var f = document.getElementById('form-edit');
            f.action = '{{ url('/admin/restaurants') }}/' + d.id;
            document.getElementById('edit-restaurant-name').textContent = d.name;
            document.getElementById('edit-status').value = d.status || 'pending';
            document.getElementById('dlg-edit').showModal();
        });
    </script>
</x-layouts.admin>
