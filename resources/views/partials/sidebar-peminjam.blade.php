<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">MENU</div>

                <a class="nav-link" href="{{ route('peminjam.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="{{ route('peminjam.alat.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-laptop"></i></div>
                    Daftar Alat
                </a>

                <a class="nav-link" href="{{ route('peminjam.peminjaman.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                    Riwayat Peminjaman
                </a>

                

            </div>
        </div>
    </nav>
</div>
