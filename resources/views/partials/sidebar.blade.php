<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="" class="logo d-flex align-items-center">
        <img
          src="{{asset('images/logo.png')}}"
          alt="navbar brand"
          class="navbar-brand"
          width="50"
        />
        <div>
          <h1 class="text-white mb-0 ms-2">SPKK</h1>
        </div>
      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
      @switch(auth()->user()->role)
        @case("ADMIN")
          @include('admin.menu')
        @break
        @case("VALIDATOR")
          @include('validator.menu')
        @break
        @case("KARYAWAN")
          @include('karyawan.menu')
        @break
      @endswitch
      </ul>
    </div>
  </div>
</div>
<!-- End Sidebar -->