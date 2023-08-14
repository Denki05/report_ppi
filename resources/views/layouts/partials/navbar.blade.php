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
          @role('Developer')
          <li class="nav-item">
            <a class="nav-link mx-2" href="{{ route('users.index') }}">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="{{ route('roles.index') }}">Roles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2" href="{{ route('permissions.index') }}">Permissions</a>
          </li>
          @endrole
          @endauth
        </ul>
      </div>

      <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
          @auth
          <li class="nav-item">
            <a class="nav-link mx-2" href="{{ route('logout.perform') }}">Logout</a>
          </li>
          @endauth
        </ul>
      </div>
    </div>  
    </nav>