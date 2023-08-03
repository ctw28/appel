<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link text-white " href="{{route('mahasiswa.dashboard')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        @if(!empty($data))
        <a class="nav-link text-white " href="{{route('mahasiswa.laporan.add')}}">
            @else
            <a class="nav-link text-white " href="#">
                @endif
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">report</i>
                </div>
                <span class="nav-link-text ms-1">Pelaporan</span>
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
    <li class="nav-item">
        <a class="nav-link text-white " href="{{route('mahasiswa.ppl')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">app_registration</i>
            </div>
            <span class="nav-link-text ms-1">Pendaftaran {{session('fakultasData')->singkatan}}</span>
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