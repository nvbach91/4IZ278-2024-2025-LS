<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Rezervační Systém</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">
                @if (Auth::check())

                    @if (Auth::user()->ownedBusiness())
                        <li class="nav-item me-3">

                            <a href="{{ route('business.show', Auth::user()->ownedBusiness()->id) }}"
                                class="d-flex align-items-center icon-link btn btn-secondary">
                                <i class="fa-solid fa-briefcase"></i>
                                {{ Auth::user()->ownedBusiness()->name }}
                            </a>
                        </li>
                    @endif

                    <li class="nav-item dropdown ms-auto">
                        <a class="dropdown-toggle d-flex align-items-center icon-link btn btn-secondary" href="#"
                            role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">Můj Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">Moje Rezervace</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}">Můj Business</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>

                                <a class="dropdown-item icon-link" href="{{ route('logout') }}"><i
                                        class="fa-solid fa-right-from-bracket"></i> Odhlásit se</a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">

                        <a class="nav-link icon-link" href="{{ route('login') }}"> <i
                                class="fa-solid fa-right-to-bracket"></i> Přihlášení</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
