<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sidebar-custom" id="sidenavAccordion">

            <div class="sb-sidenav-menu">
                <div class="nav">

                    <div class="sb-sidenav-menu-heading text-white mb-3">NAVIGATION</div>

                    <a class="nav-link text-white active-link mb-2" href="{{ route('admin.dashboard') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-home text-warning"></i>
                        </div>
                        Dashboard
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.users.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-users text-info"></i>
                        </div>
                        Manajemen User
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.kategori.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-tags text-success"></i>
                        </div>
                        Kategori
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.barang.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-box text-warning"></i>
                        </div>
                        Data Barang 
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.peminjaman.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-clipboard-list text-danger"></i>
                        </div>
                        Peminjaman 
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.pengembalian.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-undo-alt text-success"></i>
                        </div>
                        Pengembalian 
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.laporan.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-file-invoice text-warning"></i>
                        </div>
                        Laporan 
                    </a>

                    <a class="nav-link text-white mb-2" href="{{ route('admin.activities.index') }}">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-history text-info"></i>
                        </div>
                        Log Aktivitas
                    </a>

                </div>
            </div>
        </nav>
    </div>
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