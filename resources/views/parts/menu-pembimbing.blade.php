<!-- <div class="menu_section">
    <h3>Menu</h3>
    <ul class="nav side-menu">
        <li><a href="{{route('pembimbing.dashboard')}}"><i class="fa fa-home"></i> Dashboard </a></li>
        <li><a href="{{route('pembimbing.list')}}"><i class="fa fa-table"></i> Penilaian</span></a></li>
    </ul>
</div> -->

<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link text-white " href="{{route('pembimbing.dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white " href="#">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">settings</i>
            </div>
            <span class="nav-link-text ms-1">Pengaturan</span>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link text-white " href="{{route('mahasiswa.ppl.diikuti','berjalan')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">star</i>
            </div>
            <span class="nav-link-text ms-1">PLP Diikuti</span>
        </a>
    </li> -->

</ul>