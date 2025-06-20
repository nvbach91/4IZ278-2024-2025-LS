<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Rezervační Systém</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">
                @if (Auth::check())


                    @php
                        $user = Auth::user();
                        $owned = $user->ownedBusiness();
                        $managed = $user->managedBusinesses();
                    @endphp

                    <li class="nav-item dropdown me-3">
                        <a class="btn btn-secondary dropdown-toggle d-flex align-items-center icon-link" href="#"
                            role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-briefcase me-1"></i>
                            Business
                        </a>
                        <ul class="dropdown-menu">
                            {{-- Owned business --}}
                            @if ($owned)
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center"
                                        href="{{ route('business.show', $owned->id) }}">
                                        <span><i class="fa-solid fa-briefcase me-1"></i> {{ $owned->name }}</span>
                                        <span class="badge bg-primary">Vlastník</span>
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('business.create') }}">
                                        <i class="fa-solid fa-plus me-1"></i> Vytvořit Business
                                    </a>
                                </li>
                            @endif

                            {{-- Managed businesses --}}
                            @if ($managed->isNotEmpty())
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li class="dropdown-header text-muted small">Spravuji</li>
                                @foreach ($managed as $biz)
                                    {{-- Avoid duplicate if also owned --}}
                                    @if (!$owned || $biz->id !== $owned->id)
                                        <li>
                                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                                href="{{ route('business.show', $biz->id) }}">
                                                <span><i class="fa-solid fa-briefcase me-1"></i>
                                                    {{ $biz->name }}</span>
                                                <span class="badge bg-secondary">Správce</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>




                    <li class="nav-item dropdown ms-auto">
                        <a class="dropdown-toggle d-flex align-items-center icon-link btn btn-secondary" href="#"
                            role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user"></i>
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}#profile">Můj Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.reservations') }}#reservations">Moje
                                    Rezervace</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.profile') }}#business">Business</a></li>
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
