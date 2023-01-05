<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link text-white " href="{{route('dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white " href="{{route('admin.ppl')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">featured_play_list</i>
            </div>
            <span class="nav-link-text ms-1">Data {{session('fakultasData')->singkatan}}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-white " href="{{route('admin.pengaturan.fakultas')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">settings</i>
            </div>
            <span class="nav-link-text ms-1">Pengaturan</span>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link text-white " href="{{route('admin.ppl.peserta')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">how_to_reg</i>
            </div>
            <span class="nav-link-text ms-1">Peserta</span>
        </a>
    </li> -->
</ul>