<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sidebar-custom" id="sidenavAccordion">

        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading text-white mb-3">NAVIGATION</div>

                <a class="nav-link text-white active-link mb-2" href="{{ route('petugas.dashboard') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-home text-warning"></i>
                    </div>
                    Dashboard
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('petugas.barang.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-box text-info"></i>
                    </div>
                    Data Barang 
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('petugas.kategori.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-tags text-success"></i>
                    </div>
                    Kategori 
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('petugas.peminjaman.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-check text-warning"></i>
                    </div>
                    Peminjaman
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('petugas.pengembalian.index') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-undo text-danger"></i>
                    </div>
                    Pengembalian
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('petugas.laporan') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-file-invoice text-info"></i>
                    </div>
                    Laporan 
                </a>

                <a class="nav-link text-white mb-2" href="{{ route('petugas.petugas.activities') }}">
                    <div class="sb-nav-link-icon">
                        <i class="fas fa-history text-warning"></i>
                    </div>
                    Log Aktivitas
                </a>

            </div>
        </div>
    </nav>
</div>

<style>
    .sidebar-custom {
        background-color: #0059FF;
        padding: 15px;
    }

    .nav-link {
        padding: 10px 12px;
        border-radius: 10px;
        transition: 0.3s;
    }

    .nav-link:hover {
        background-color: #0041c4;
    }

    .active-link {
        background-color: white !important;
        color: #0059FF !important;
        font-weight: bold;
    }

    .active-link i {
        color: #0059FF !important;
    }

    .sb-nav-link-icon {
        margin-right: 10px;
    }
</style>