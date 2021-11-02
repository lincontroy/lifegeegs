<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
          
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            @if (Auth()->user()->image != '')
            <img src="{{ asset(Auth()->user()->image) }}" alt="" class="image-thumbnail mt-2 rounded-circle profile-widget-picture">
        @else
            <img alt="image" src='https://ui-avatars.com/api/?name={{Auth()->user()->name}}'
                 class="rounded-circle profile-widget-picture ">
        @endif
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">

                @if(Auth()->user()->role_id ==1)
                    <a href="{{ route('admin.profile.index') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                @else
                    <a href="{{ route('merchant.profile.index') }}" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                @endif

              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
