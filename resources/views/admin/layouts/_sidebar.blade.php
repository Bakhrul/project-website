<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span style="font-size:18px;">
                        Admin Panel
                    </span>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li class="divider"></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{Request::is('admin-panel') ? 'active nav-active' : ''}}">
                <a href="{{url('/admin-panel/')}}">
                    <i class="fa fa-home"></i>
                    <span class="nav-label">Dashboard</span></a>
            </li>
            <li class="{{Request::is('admin-panel/master/*') ? 'active nav-active' : ''}}">
                <a href="javascript:void(0)">
                    <i class="fa fa-desktop" aria-hidden="true"></i>
                    <span class="nav-label">Master</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li
                        class="{{Request::is('admin-panel/master/satuan/*') || Request::is('admin-panel/master/satuan') ? 'nav-active active' : ''}}">
                        <a href="{{route('master.satuan.index')}}">Satuan</a></li>
                    <li
                        class="{{Request::is('admin-panel/master/item/*') || Request::is('admin-panel/master/item') ? 'nav-active active' : ''}}">
                        <a href="{{route('master.item.index')}}">Item</a></li>
                    <li
                        class="{{Request::is('admin-panel/master/pengguna/*') || Request::is('admin-panel/master/pengguna') ? 'nav-active active' : ''}}">
                        <a href="{{route('master.pengguna.index')}}">Pengguna</a></li>
                    <li
                        class="{{Request::is('admin-panel/master/saldo/*') || Request::is('admin-panel/master/saldo') ? 'nav-active active' : ''}}">
                        <a href="{{route('master.saldo.index')}}">Saldo</a></li>
                    <li
                        class="{{Request::is('admin-panel/master/banks/*') || Request::is('admin-panel/master/banks') ? 'nav-active active' : ''}}">
                        <a href="{{route('master.banks.index')}}">Bank</a></li>
                </ul>
            </li>
            <li
                class="{{Request::is('admin-panel/konfirmasi-saldo') || Request::is('admin-panel/konfirmasi-saldo/*') ? 'active nav-active' : ''}}">
                <a href="{{route('konfirmasi_saldo.index')}}">
                    <i class="fa fa-check"></i>
                    <span class="nav-label">Konfirmasi Pembelian Saldo</span></a>
            </li>
        </ul>
    </div>
</nav>
