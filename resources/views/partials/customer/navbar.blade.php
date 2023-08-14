

<nav class="navbar navbar-expand-lg bg-primary text-white">
    <div class="container px-4 px-lg-5">
        <!-- <img src="/" width="70" height="70" class="d-inline-block align-top" alt=""> -->
        <h3>LOGO</h3>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 text-uppercase">
                <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : '' }} text-white" href="/about">About Us</a></li>


                @if(Auth::user())
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{Auth()->user()->name}}</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="/customer/account">Edit Account</a></li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Accounts</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/login">Login</a></li>
                        </ul>
                    </li>
                @endif

            </ul>

        </div>
    </div>
</nav>
