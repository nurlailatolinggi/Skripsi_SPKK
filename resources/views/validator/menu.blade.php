@php
  $currentRoute = request()->route()->getName();

  $menu = [
    [
      'route'=> route('validator.index'),
      'icon'=> 'fas fa-home',
      'menu'=> 'Dashboard'
    ],
    [
      'route'=> '#',
      'icon'=> 'fas fa-database',
      'menu'=> 'Master Data',
      'submenu'=> [
        [
          'route'=> route('iku.list'),
          'menu'=> 'Indikator Kinerja Utama',
        ],
        [
          'route'=> route('iki.list'),
          'menu'=> 'Indikator Kinerja Individu',
        ],
      ]
    ],
    [
      'route'=> '#',
      'icon'=> 'fas fa-user-check',
      'menu'=> 'Validasi Dokumen',
      'submenu'=> [
        [
          'route'=> route('validasiiku.list'),
          'menu'=> 'Indikator Kinerja Utama',
        ],
        [
          'route'=> route('validasiiki.list'),
          'menu'=> 'Indikator Kinerja Individu',
        ],
      ]
    ],
    [
      'route'=> route('validator.laporankinerja'),
      'icon'=> 'fas fa-percent',
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
