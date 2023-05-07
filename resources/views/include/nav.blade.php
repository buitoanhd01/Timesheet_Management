<ul class="menu-inner py-1">
    <!-- Dashboard -->
    @if(auth()->user()->hasPermissionTo('using'))
    <li class="menu-item">
      <a href="{{ route('admin-dashboard') }}" class="menu-link">
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
      <a href="{{ route('admin-request') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-mail-send"></i>
        <div data-i18n="Request">Leave Management</div>
      </a>
    </li>
    @endif

    @if(auth()->user()->can('manage-report'))
    <li class="menu-item">
      <a href="{{ route('admin-report')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-report"></i>
        <div data-i18n="Report">Report</div>
      </a>
    </li>
    @endif

    {{-- @if(auth()->user()->can('manage-request'))
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons bx bx-money"></i>
        <div data-i18n="Request">Salary Management</div>
      </a>
    </li>
    @endif --}}
    
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
        <i class="menu-icon tf-icons bx bx-registered"></i>
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
        <i class="menu-icon tf-icons bx bx-calendar-check"></i>
        <div data-i18n="Attendance">My Attendance</div>
      </a>
    </li>
    @endif

    <!-- Request -->
    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="{{ route('employee-request') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-comment-error"></i>
        <div data-i18n="Request">My Leave</div>
      </a>
    </li>
    @endif

    <!-- Request -->
    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="{{ route('employee-report') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-credit-card"></i>
        <div data-i18n="my-report">My Report</div>
      </a>
    </li>
    @endif

    <!-- Other -->
    @if(auth()->user()->can('manage-department manage-position'))
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Others</span></li>
    @endif
    <!-- Department -->
    @if(auth()->user()->can('manage-department'))
    <li class="menu-item">
      <a href="{{ route('admin-department-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-building"></i>
        <div data-i18n="Department">Department</div>
      </a>
    </li>
    @endif

    <!-- Position -->
    @if(auth()->user()->can('manage-position'))
    <li class="menu-item">
      <a href="{{ route('admin-position-management') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-id-card"></i>
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
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Settings">Settings</div>
      </a>
    </li>
    @endif

    <!-- My account -->
    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="{{ route('my-account')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Settings">My Account</div>
      </a>
    </li>
    @endif

    @if(auth()->user()->can('using'))
    <li class="menu-item">
      <a href="{{ route('my-profile-show')}}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-collection"></i>
        <div data-i18n="Settings">My Profie</div>
      </a>
    </li>
    @endif
    
    <li class="menu-header small text-uppercase"><span class="menu-header-text"></span></li>
    <li class="menu-item">
      <a href="#" onclick="event.preventDefault();
      document.getElementById('logout-form').submit();" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div data-i18n="Settings">Logout</div>
      </a>
    </li>
  </ul>
  <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>