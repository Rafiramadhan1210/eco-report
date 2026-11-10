@if (session('success'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        <span>✅</span><span>{{ session('success') }}</span>
    </div>
@endif
@if (session('error'))
    <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <span>⚠️</span><span>{{ session('error') }}</span>
    </div>
@endif
