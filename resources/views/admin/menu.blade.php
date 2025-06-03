@php
  $currentRoute = request()->route()->getName();

  $menu = [
    [
      'route'=> route('admin.index'),
      'icon'=> 'fas fa-home',
      'menu'=> 'Dashboard'
    ],
    [
      'route'=> '#',
      'icon'=> 'fas fa-database',
      'menu'=> 'Master Data',
      'submenu'=> [
        [
          'route'=> route('user.list'),
          'menu'=> 'Tabel User',
        ],
        [
          'route'=> route('jabatan.list'),
          'menu'=> 'Tabel Jabatan',
        ],
        [
          'route'=> route('unit.list'),
          'menu'=> 'Tabel Unit',
        ],
      ]
    ],
    [
      'route'=> route('admin.laporankinerja'),
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
