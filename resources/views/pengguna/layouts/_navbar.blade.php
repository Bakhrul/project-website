<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">Sistem Pemantauan Harga Produk<br>Nama Brand</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto nav-link-group">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : ''}}" href="{{url('/')}}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('pembelian-saldo') ? 'active' : ''}}"
                        href="{{route('pembelian_saldo.index')}}">Pembelian Saldo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('history-pembelian-saldo') ? 'active' : ''}}"
                        href="{{route('history_saldo.index')}}">History Saldo</a>
                </li>
                @if(Auth::check())
                    @if(Auth::user()->u_type == 'admin')
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{url('admin-panel')}}">Admin Panel</a>
                        </li>
                    @endif
                @endif
                <li class="nav-item">
                    @if(Auth::check())
                    <a class="nav-link" href="{{route('login.index')}}">
                        <img src="{{asset('storage/images/pengguna')}}/{{Auth::user()->u_photo}}" class="user-nav-image"
                            width="30px"
                            onerror="this.onerror=null; this.src='{{asset('member-template/images/avatar-placeholder.png')}}'">
                    </a>
                    @else
                    <a class="nav-link" href="{{route('profile.index')}}">
                        <img src="{{asset('member-template/images/avatar-placeholder.png')}}" class="user-nav-image"
                            width="30px">
                    </a>
                    @endif
                </li>
            </ul>

        </div>
    </div>
</nav>
