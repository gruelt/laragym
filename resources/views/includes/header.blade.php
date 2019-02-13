{{--button for collapsed menu--}}
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<a class="navbar-brand" href="/"><img src='{{ asset('images/fjep-logo.png') }}' alt=''> {{env('APP_NAME')}}
    </a>

<div class="collapse navbar-collapse justify-content-end" id='navbarNavDropdown'>
    <ul class="navbar-nav">
        <form class="form-inline  ">
            <input class="form-control col-9 mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success col-2 my-2 my-sm-0" type="submit"><i class="fas fa-search"></i>
            </button>
        </form>

        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdownFlag" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                <img width="25" height="25" alt="{{ session('locale') }}"
                     src="{!! asset('images/' . session('locale') . '.png') !!}"/>
            </a>
            
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                {{ Auth::user()->firstname }} {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#"><i class="fas fa-user"></i> {{__('navbar.informations')}}</a>
                <a class="dropdown-item" href="#"><i class="fas fa-cog"></i> {{__('navbar.preferences')}}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> {{__('navbar.deconnexion')}}</a>
            </div>
        </li>

        <li class="nav-item dropdown d-sm-block d-md-none">
            <a class="nav-link dropdown-toggle" href="#" id="smallerscreenmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menu
            </a>
            <div class="dropdown-menu" aria-labelledby="smallerscreenmenu">
                <a class="dropdown-item" href="#">Dashboard</a>
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Tasks</a>
                <a class="dropdown-item" href="#">Etc ...</a>
            </div>
        </li>
    </ul>
</div>
