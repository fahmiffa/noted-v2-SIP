<ul class="menu">
    <li class="sidebar-item {{ request()->routeIs('main') ? 'active' : null }}">
        <a href="{{ route('main') }}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if (auth()->user()->ijin('bak') && auth()->user()->roles->kode != 'SU')
        <li class="sidebar-item has-sub {{ Request::segment(1) == 'task' ? 'active' : null }}">
            <a href="#" class="sidebar-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>Task</span>
            </a>
            <ul class="submenu submenu-{{ Request::segment(1) == 'task' ? 'open' : 'closed' }}"
                style="--submenu-height: 86px;">
                <li class="submenu-item {{ request()->routeIs('news.index') ? 'active' : null }} {{ Request::segment(2) == 'input-bak' ? 'active' : null }}">
                    <a href="{{ route('news.index') }}" class="submenu-link">BAK</a>
                </li>
                <li class="submenu-item {{ request()->routeIs('meet.index') ? 'active' : null }} {{ Request::segment(2) == 'input-barp' ? 'active' : null }}">
                    <a href="{{ route('meet.index') }}" class="submenu-link">BARP</a>
                </li>
                <li class="submenu-item {{ request()->routeIs('attach.index') ? 'active' : null }} {{ Request::segment(2) == 'attach-step' ? 'active' : null }}">
                    <a href="{{ route('attach.index') }}" class="submenu-link">Lampiran PBG</a>
                </li>
                <li class="submenu-item {{ request()->routeIs('tax.index') ? 'active' : null }}">
                    <a href="{{ route('tax.index') }}" class="submenu-link">Retribusi</a>
                </li>
            </ul>
        </li>
    @endif

    @if (auth()->user()->ijin('doc_formulir') && auth()->user()->roles->kode != 'SU')
        <li class="sidebar-item {{ Request::segment(1) == 'task' ? 'active' : null }}">
            <a href="{{ route('verification.index') }}" class="sidebar-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>Task</span>
            </a>
        </li>
    @endif

    @if (auth()->user()->ijin('verifikasi_bak'))
        <li class="sidebar-item {{ request()->routeIs('ba.verifikasi') ? 'active' : null }}">
            <a href="{{ route('ba.verifikasi') }}" class="sidebar-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>BAK BARP</span>
            </a>
        </li>  
    @endif

    @if (auth()->user()->ijin('master_formulir'))
        {{-- <li class="sidebar-item has-sub {{ Request::segment(1) == 'dokumen' ? 'active' : null }}">
            <a href="#" class="sidebar-link">
                <i class="bi bi-file-text"></i>
                <span>Dokumen</span>
            </a>
            <ul class="submenu submenu-{{ Request::segment(1) == 'dokumen' ? 'open' : 'closed' }}"
                style="--submenu-height: 86px;">
                <li class="submenu-item {{ request()->routeIs('verifikasi.index') ? 'active' : null }}">
                    <a href="{{ route('verifikasi.index') }}" class="submenu-link">Verifikasi</a>
                </li>
                <li class="submenu-item {{ request()->routeIs('consultation.index') ? 'active' : null }}">
                    <a href="{{ route('consultation.index') }}" class="submenu-link">Konsultasi</a>
                </li>
                <li class="submenu-item {{ request()->routeIs('schedule.index') ? 'active' : null }}">
                    <a href="{{ route('schedule.index') }}" class="submenu-link">Jadwal Surat</a>
                </li>
            </ul>
        </li> --}}
        <li class="sidebar-item {{ Request::segment(1) == 'verifikasi' ? 'active' : null }}">
            <a href="{{ route('verifikasi.index') }}" class="sidebar-link">
                <i class="bi bi-file-earmark-text"></i>
                <span>Verifikasi</span>
            </a>
        </li>
        <li class="sidebar-item {{ Request::segment(1) == 'dokumen' ? 'active' : null }}">
            <a href="{{ route('consultation.index') }}" class="sidebar-link">
                <i class="bi bi-send"></i>                
                <span>Penugasan TPT TPA</span>
            </a>
        </li>
    @endif

    <li class="sidebar-item {{ request()->routeIs('req.index') ? 'active' : null }}">
        <a href="{{ route('req.index') }}" class="sidebar-link">
            <i class="bi bi-files"></i>
            <span>Permohonan</span>
        </a>
    </li>

    @if (auth()->user()->ijin('master'))
        <li class="sidebar-item has-sub {{ Request::segment(1) == 'master' ? 'active' : null }}">
            <a href="#" class="sidebar-link">
                <i class="bi bi-grid-fill"></i>
                <span>Master</span>
            </a>
            <ul class="submenu submenu-{{ Request::segment(1) == 'master' ? 'open' : 'closed' }}"
                style="--submenu-height: 86px;">

                <li class="submenu-item has-sub">
                    <a href="#" class="submenu-link">Account</a>
                    <ul class="submenu submenu-level-2 submenu-{{ Request::segment(2) == 'account' ? 'open' : 'closed' }}"
                        style="--submenu-height: 106px;">
                        <li class="submenu-item {{ request()->routeIs('permission.index') ? 'active' : null }}">
                            <a href="{{ route('permission.index') }}" class="submenu-link">Permission</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('role.index') ? 'active' : null }}">
                            <a href="{{ route('role.index') }}" class="submenu-link">Role</a>
                        </li>
                        <li class="submenu-item {{ request()->routeIs('user.index') ? 'active' : null }}">
                            <a href="{{ route('user.index') }}" class="submenu-link">User</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu-item has-sub">
                    <a href="#" class="submenu-link">Dokumen</a>
                    <ul class="submenu submenu-level-2 submenu-{{ Request::segment(2) == 'dokumen' ? 'open' : 'closed' }}"
                        style="--submenu-height: 63px;">
                        <li class="submenu-item ">
                            <a href="{{ route('formulir.index') }}"
                                class="submenu-link {{ request()->routeIs('formulir.index') ? 'active' : null }}">Formulir</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('letter.index') }}"
                                class="submenu-link {{ request()->routeIs('letter.index') ? 'active' : null }}">Surat</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('header.index') }}"
                                class="submenu-link {{ request()->routeIs('header.index') ? 'active' : null }}">Header</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('footer.index') }}"
                                class="submenu-link {{ request()->routeIs('footer.index') ? 'active' : null }}">Footer</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('title.index') }}"
                                class="submenu-link {{ request()->routeIs('title.index') ? 'active' : null }}">Title</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('item.index') }}"
                                class="submenu-link {{ request()->routeIs('item.index') ? 'active' : null }}">Item</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{ route('sub.index') }}"
                                class="submenu-link {{ request()->routeIs('sub.index') ? 'active' : null }}">Sub</a>
                        </li>
                    </ul>
                </li>

                <li class="submenu-item {{ request()->routeIs('kecamatan.index') ? 'active' : null }}">
                    <a href="{{ route('kecamatan.index') }}" class="submenu-link">Kecamatan</a>
                </li>

                <li class="submenu-item {{ request()->routeIs('desa.index') ? 'active' : null }}">
                    <a href="{{ route('desa.index') }}" class="submenu-link">Desa</a>
                </li>

            </ul>
        </li>
    @endif

</ul>
