<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Report System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto ">
          <li class="nav-item">
            <a class="nav-link mx-2 active" aria-current="page" href="{{ route('home.index') }}">Home</a>
          </li>
          @auth
          <li class="nav-item">
            <a class="nav-link mx-2" href="{{ route('report_customer_type.index') }}">Report</a>
          </li>
          <!-- <li class="nav-item dropdown">
            <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Report
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="{{ route('report_customer_type.index') }}">Customer Type</a></li>
              <li><a class="dropdown-item" href="{{ route('report.index') }}">Brand Product</a></li>
              <li><a class="dropdown-item" href="#">Supplier</a></li>
            </ul>
          </li> -->
          @endauth
          <li class="nav-item dropdown">
            <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{auth()->user()->name}}&nbsp;
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              @auth
                @role('Developer')
                  <li><a href="{{ route('users.index') }}" class="dropdown-item">Users</a></li>
                  <li><a href="{{ route('roles.index') }}" class="dropdown-item">Roles</a></li>
                  <li><a href="{{ route('permissions.index') }}" class="dropdown-item">Permissions</a></li>
                @endrole
                <a href="{{ route('logout.perform') }}" class="dropdown-item"> Logout</a>
              @endauth
            </ul>
          </li>
        </ul>
      </div>
    </div>
    </nav>