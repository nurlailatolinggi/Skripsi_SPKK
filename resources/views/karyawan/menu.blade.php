@php
  $currentRoute = request()->route()->getName();

  $menu = [
    [
      'route'=> route('karyawan.index'),
      'icon'=> 'fas fa-home',
      'menu'=> 'Dashboard'
    ],
    [
      'route'=> route('uploadiku.list'),
      'icon'=> 'fas fa-file-upload',
      'menu'=> 'Dokumen IKU'
    ],
    [
      'route'=> route('uploadiki.list'),
      'icon'=> 'fas fa-file-upload',
      'menu'=> 'Dokumen IKI'
    ],
    // [
    //   'route'=> route('karyawan.laporankinerja'),
    //   'icon'=> 'fas fa-percent',
    //   'menu'=> 'Laporan Kinerja'
    // ],
    [
      'route'=> route('karyawan.laporankinerjakaryawan'),
      'icon'=> 'fas fa-file',
      'menu'=> 'Laporan Kinerja'
    ],
  ];
@endphp

@foreach ($menu as $item)
  @php
    $hasSubmenu = isset($item['submenu']);
    $isActiveParent = $hasSubmenu
      ? collect($item['submenu'])->pluck('route')->contains(url()->current())
      : url()->current() == $item['route'];
  @endphp

  <li class="nav-item {{ $isActiveParent ? 'active' : '' }}">
    <a 
      href="{{ $hasSubmenu ? '#'.Str::slug($item['menu']) : $item['route'] }}" 
      data-bs-toggle="{{ $hasSubmenu ? 'collapse' : '' }}"
      aria-expanded="{{ $isActiveParent ? 'true' : 'false' }}"
      class="{{ $hasSubmenu ? '' : 'nav-link' }} {{ $isActiveParent ? '' : 'collapsed' }}"
    >
      <i class="{{ $item['icon'] }}"></i>
      <p>{{ $item['menu'] }}</p>
      @if($hasSubmenu)
        <span class="caret"></span>
      @endif
    </a>

    @if($hasSubmenu)
      <div class="collapse {{ $isActiveParent ? 'show' : '' }}" id="{{ Str::slug($item['menu']) }}">
        <ul class="nav nav-collapse">
          @foreach ($item['submenu'] as $sub)
            <li class="{{ url()->current() == $sub['route'] ? 'active' : '' }}">
              <a href="{{ $sub['route'] }}">
                <span class="sub-item">{{ $sub['menu'] }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </li>
@endforeach
