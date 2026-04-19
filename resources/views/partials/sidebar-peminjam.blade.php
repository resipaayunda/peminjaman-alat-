<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sidebar-custom">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading text-white mb-3">MENU</div>

                <a class="nav-link text-white active-link mb-2" href="{{ route('peminjam.dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-home text-warning"></i>
                    </div>
                    Dashboard
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('peminjam.alat.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-laptop text-info"></i>
                    </div>
                    Daftar Alat
                </a>
                
                <a class="nav-link text-white mb-2" href="{{ route('peminjam.pengembalian.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-undo-alt text-success"></i>
                    </div>
                    Pengembalian 
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('peminjam.peminjaman.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-history text-danger"></i>
                    </div>
                    Riwayat Peminjaman
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('peminjam.laporan.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-file-invoice text-warning"></i>
                    </div>
                    Laporan 
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('peminjam.activities') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-history text-info"></i>
                    </div>
                    Log Aktivitas 
                </a>

            </div>
        </div>
    </nav>
</div>

<!-- STYLE -->
<style>
    /* Background sidebar */
    .sidebar-custom {
        background-color: #0059FF;
        padding: 15px;
    }

    /* Jarak antar menu + bentuk */
    .nav-link {
        padding: 10px 12px;
        border-radius: 10px;
        transition: 0.3s;
    }

    /* Hover */
    .nav-link:hover {
        background-color: #0041c4;
    }

    /* Active */
    .active-link {
        background-color: white !important;
        color: #0059FF !important;
        font-weight: bold;
    }

    .active-link i {
        color: #0059FF !important;
    }

    /* Biar icon ga terlalu mepet */
    .sb-nav-link-icon {
        margin-right: 10px;
    }
</style>