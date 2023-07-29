<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
      <span class="sidebar-brand-text align-middle">
        MAS
        <sup><small class="badge bg-primary text-uppercase">Pro</small></sup>
      </span>
      <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
        <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
        <path d="M20 12L12 16L4 12"></path>
        <path d="M20 16L12 20L4 16"></path>
      </svg>
    </a>

    <div class="sidebar-user">
      <div class="d-flex justify-content-center">
        <div class="flex-shrink-0">
          <img src="{{ asset('assetss/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
        </div>
        <div class="flex-grow-1 ps-2">
          <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
            {{ Auth()->user()->username }}
          </a>
          <div class="dropdown-menu dropdown-menu-start">
            <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
            <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="settings"></i> Settings &
              Privacy</a>
            <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('dashboard.logout') }}">Log out</a>
          </div>

          <div class="sidebar-user-subtitle">{{ Auth()->user()->email_pegawai }}</div>
        </div>
      </div>
    </div>

    <ul class="sidebar-nav">
      <li class="sidebar-header">
        Menu
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="#">
          <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
          <span class="sidebar-badge badge bg-primary">Pro</span>
        </a>
      </li>
    </ul>

    <div class="sidebar-cta">
      <div class="sidebar-cta-content">
        <strong class="d-inline-block mb-2">Go to site</strong>
        <div class="mb-3 text-sm">
          Check and view your updates sites here
        </div>

        <div class="d-grid">
          <a href="{{ url('') }}" class="btn btn-outline-primary" target="_blank">VISIT</a>
        </div>
      </div>
    </div>
  </div>
</nav>