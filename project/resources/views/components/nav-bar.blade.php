<nav class="navbar navbar-expand navbar-light navbar-bg">
  <a class="sidebar-toggle js-sidebar-toggle">
    <i class="hamburger align-self-center"></i>
  </a>

  <form class="d-none d-sm-inline-block">
    <div class="input-group input-group-navbar">
      <input type="text" class="form-control" placeholder="Search…" aria-label="Search">
      <button class="btn" type="button">
        <i class="align-middle" data-feather="search"></i>
      </button>
    </div>
  </form>

  <div class="navbar-collapse collapse">
    <ul class="navbar-nav navbar-align">
      <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle" href="{{ url('') }}" target="_blank" id="alertsDropdown">
          <div class="position-relative">
            <i class="align-middle" data-feather="bell"></i>
            <span class="indicator">Go</span>
          </div>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-icon js-fullscreen d-none d-lg-block" href="#">
          <div class="position-relative">
            <i class="align-middle" data-feather="maximize"></i>
          </div>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-icon pe-md-0 dropdown-toggle" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('assetss/img/avatars/avatar.jpg') }}" class="avatar img-fluid rounded" alt="Charles Hall" />
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
          <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="settings"></i> Settings &
            Privacy</a>
          <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('dashboard.logout') }}">Log out</a>
        </div>
      </li>
    </ul>
  </div>
</nav>