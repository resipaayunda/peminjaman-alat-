<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">NAVIGATION</div>

                <a class="nav-link" href="{{ route('petugas.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="{{ route('petugas.peminjaman.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-check"></i></div>
                    Peminjaman
                </a>

                <a class="nav-link" href="{{ route('petugas.pengembalian.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-undo"></i></div>
                    Pengembalian
                </a>
            </div>
        </div>
    </nav>
</div>
