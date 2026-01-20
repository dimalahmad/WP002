<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="#" class="brand-link">
            <!-- Ganti dengan Logo Perusahaan jika tersedia -->
            <img src="{{ asset('vendor/adminlte/assets/img/AdminLTELogo.png') }}" alt="Logo Aplikasi"
                class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">WORK PERMIT</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                data-accordion="false">


                <!-- Grup User -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>
                            User
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.master-os') }}"
                                class="nav-link {{ request()->routeIs('user.master-os') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Master OS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.master-vendor') }}"
                                class="nav-link {{ request()->routeIs('user.master-vendor') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Master Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.work-permit.index') }}"
                                class="nav-link {{ request()->routeIs('user.work-permit*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Work Permit</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Grup Corsec -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-check"></i>
                        <p>
                            Corsec
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('corsec.work-permit-masuk') }}"
                                class="nav-link {{ request()->routeIs('corsec.work-permit-masuk') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Work Permit Masuk</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Grup HSE -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-heart-pulse"></i>
                        <p>
                            HSE
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('hse.master-apd') }}"
                                class="nav-link {{ request()->routeIs('hse.master-apd') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Master APD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hse.master-pengaman') }}"
                                class="nav-link {{ request()->routeIs('hse.master-pengaman') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Master Pengaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hse.master-ikb') }}"
                                class="nav-link {{ request()->routeIs('hse.master-ikb') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Master IKB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hse.master-blacklist') }}"
                                class="nav-link {{ request()->routeIs('hse.master-blacklist') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Master Blacklist</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hse.work-permit-hse') }}"
                                class="nav-link {{ request()->routeIs('hse.work-permit-hse') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Work Permit HSE</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
    <!-- Footer Sidebar (Profil) jika diperlukan seperti pada gambar kiri bawah -->
    <div class="sidebar-footer p-3 d-flex align-items-center"
        style="position: absolute; bottom: 0; width: 100%; border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="image me-2">
            <img src="{{ asset('vendor/adminlte/assets/img/user2-160x160.jpg') }}" class="rounded-circle elevation-2"
                alt="User Image" style="width: 40px;">
        </div>
        <div class="info text-white">
            <div class="fw-bold">Budi</div>
            <small>1234567890</small>
        </div>
    </div>
</aside>