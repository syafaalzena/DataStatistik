<div class="tab-nav mb-4">
    <a href="{{ route('tangkap.input', $kabupaten->id) }}"
       class="tab-item {{ request()->routeIs('tangkap.input') || request()->routeIs('tangkap.produksi.*') ? 'active' : '' }}">
        Data Produksi
    </a>
    <a href="{{ route('tangkap.trip.input', $kabupaten->id) }}"
       class="tab-item {{ request()->routeIs('tangkap.trip.*') ? 'active' : '' }}">
        Data Trip
    </a>
    <span class="tab-item disabled" title="Segera hadir">
        Data Tahunan
    </span>
</div>