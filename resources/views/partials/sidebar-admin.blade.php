<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">NAVIGATION</div>

                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                        Dashboard
                    </a>

                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Manajemen User
                    </a>

                    <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                        Kategori
                    </a>

                    <a class="nav-link" href="{{ route('admin.peminjaman.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                        Peminjaman 
                    </a>

                    <a class="nav-link" href="{{ route('admin.pengembalian.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-undo-alt"></i></div>
                        Pengembalian 
                    </a>

                    <a class="nav-link" href="{{ route('admin.laporan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                        Laporan 
                    </a>

                    <a class="nav-link" href="{{ route('admin.activities.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
                        Log Aktivitas
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>