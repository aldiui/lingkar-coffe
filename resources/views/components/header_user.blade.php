<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('images/couch.png') }}"
                style="width:70px;"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">Dashboard</a>
                </li>
                <li class="nav-item {{ Request::is('penjualan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('penjualan') }}">Penjualan</a>
                </li>
                <li class="nav-item {{ Request::is('stok') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('stok') }}">Stok</a>
                </li>
                <li class="nav-item {{ Request::is('keuangan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('keuangan') }}">Keuangan</a>
                </li>
                <li class="nav-item {{ Request::is('harga') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('harga') }}">Harga</a>
                </li>
                <li class="nav-item {{ Request::is('profil') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('profil') }}">Profil</a>
                </li>
                <li class="nav-item {{ Request::is('logout') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
