<header class="header">
    <? /*
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center align-items-center py-3">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <div class="header__logo"></div>
            </a>
            <ul class="nav nav-pills">
                @if(Auth::user()->isadmin())
                    <li class="nav-item {{ (request()->is('user*')) ? 'active' : '' }}"><a href="{{ route('users') }}" class="nav-link">Users</a></li>
                    <li class="nav-item {{ (request()->is('project*')) ? 'active' : '' }}"><a href="{{ route('projects') }}" class="nav-link">Projects</a></li>
                @else
                    <li class="nav-item {{ (request()->is('detail*')) ? 'active' : '' }}"><a href="{{ route('details') }}" class="nav-link">My profile</a></li>
                    <li class="nav-item {{ (request()->is('investments*')) ? 'active' : '' }}"><a href="{{ route('investments') }}" class="nav-link">My Investments</a></li>
                    <li class="nav-item {{ (request()->is('opportunities*')) ? 'active' : '' }}"><a href="{{ route('opportunities') }}" class="nav-link">Investment opportunities</a></li>
                @endif
                <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">logout</a></li>
            </ul>
        </div>
    </div>
    */ ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="header__logo"></div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav navbar-nav ms-auto">
                        @if(Auth::user()->isadmin())
                            <li class="nav-item {{ (request()->is('user*')) ? 'active' : '' }}"><a href="{{ route('users') }}" class="nav-link">Users</a></li>
                            <li class="nav-item {{ (request()->is('project*')) ? 'active' : '' }}"><a href="{{ route('projects') }}" class="nav-link">Projects</a></li>
                        @else
                            <li class="nav-item {{ (request()->is('detail*')) ? 'active' : '' }}"><a href="{{ route('details') }}" class="nav-link">My profile</a></li>
                            <li class="nav-item {{ (request()->is('investments*')) ? 'active' : '' }}"><a href="{{ route('investments') }}" class="nav-link">My Investments</a></li>
                            <li class="nav-item {{ (request()->is('opportunities*')) ? 'active' : '' }}"><a href="{{ route('opportunities') }}" class="nav-link">Investment opportunities</a></li>
                        @endif
                        <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>


</header>
