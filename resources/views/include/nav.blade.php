<ul class="menu-inner py-1">
    <!-- Dashboard -->
    @if(auth()->user()->hasPermissionTo('manage-general'))
    <li class="menu-item">
      <a href="{{ route('admin-dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    @elseif(auth()->user()->hasPermissionTo('using'))
    <li class="menu-item">
      <a href="{{ route('employee-dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    @endif

    <!-- Calendar -->
    @if(auth()->user()->can('manage-calendar'))
    <li class="menu-item">
      <a href="{{ route('admin-calendar') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div data-i18n="Attendance">Attendance</div>
      </a>
    </li>
    @endif

    <!-- Calendar -->
    @if(auth()->user()->can('manage-request'))
    <li class="menu-item">
      <a href="{{ route('admin-calendar') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar"></i>
        <div data-i18n="Request">Request Management</div>
      </a>
    </li>
    @endif
    
    @if(auth()->user()->can('manage-employee manage-user manage-role'))
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Human Management</span>
    </li>
    @endif

    <!-- Employees -->
    @if(auth()->user()->can('manage-employee'))
    <li class="menu-item">
      <a href="{{ route('admin-employee') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Employee">Employee Management</div>
      </a>
    </li>
    @endif

    <!-- User -->
    @if(auth()->user()->can('manage-user'))
    <li class="menu-item">
      <a href="{{ route('admin-user-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-pin"></i>
        <div data-i18n="User">User Management</div>
      </a>
    </li>
    @endif

    <!-- User -->
    @if(auth()->user()->can('manage-role'))
    <li class="menu-item">
      <a href="{{ route('admin-role-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-pin"></i>
        <div data-i18n="Role">Role Management</div>
      </a>
    </li>
    @endif

    <!-- Self -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">My Activities</span></li>
    <!-- Schedule -->
    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="{{ route('my-attendance') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Schedule">My Attendance</div>
      </a>
    </li>
    @endif

    <!-- Request -->
    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Request">My Request</div>
      </a>
    </li>
    @endif

    <!-- Other -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Others</span></li>
    <!-- Department -->
    @if(auth()->user()->can('manage-department'))
    <li class="menu-item">
      <a href="{{ route('admin-department-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Department">Department</div>
      </a>
    </li>
    @endif

    <!-- Position -->
    @if(auth()->user()->can('manage-position'))
    <li class="menu-item">
      <a href="{{ route('admin-position-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Position">Position Management</div>
      </a>
    </li>
    @endif
  

    <!-- Settings -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Settings</span></li>
    <!-- Settings -->
    @if(auth()->user()->can('manage-setting'))
    <li class="menu-item">
      <a href="{{ route('admin-position-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Settings">Settings</div>
      </a>
    </li>
    @endif

    <!-- My account -->
    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="{{ route('admin-position-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Settings">My Account</div>
      </a>
    </li>
    @endif
    
    <!-- Tables -->
    <li class="menu-item">
      <a href="tables-basic.html" class="menu-link">
        <i class="menu-icon tf-icons bx bx-table"></i>
        <div data-i18n="Tables">Tables</div>
      </a>
    </li>
    <!-- Misc -->
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
    <li class="menu-item">
      <a
        target="_blank"
        class="menu-link"
      >
        <i class="menu-icon tf-icons bx bx-support"></i>
        <div data-i18n="Support">Support</div>
      </a>
    </li>
    <li class="menu-item">
      <a
        href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
        target="_blank"
        class="menu-link"
      >
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Documentation">Documentation</div>
      </a>
    </li>
  </ul>