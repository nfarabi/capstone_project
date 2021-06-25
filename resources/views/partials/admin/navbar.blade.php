<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <a href="{{ route('admin.misc.clear-cache') }}" class="btn btn-default btn-flat">Clear Cache</a>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('images/admin/user-placeholder_x160.png') }}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ asset('images/admin/user-placeholder_x160.png') }}" class="img-circle elevation-2" alt="User Image">

                    <p>
                        {{ auth()->user()->name }} - {{ optional(auth()->user()->role)->name }}
                        <small>Member since {{ auth()->user()->created_at->format('M\\. Y') }}</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('admin.users.show', auth()->user()) }}" class="btn btn-default btn-flat">Profile</a>
                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="javascript:;">
                <i class="flag-icon flag-icon-{{ request()->get('_language')->code }}"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0 language-switcher">
                @foreach($_languages as $language)
                    <a href="javascript:;" class="dropdown-item {{ request()->get('_language')->code == $language->code ? 'active' : '' }}" data-language-code="{{ $language->code }}">
                        <i class="flag-icon flag-icon-{{ $language->code }} mr-2"></i> {{ $language->label }}
                    </a>
                @endforeach
            </div>
        </li>
        {{--<li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li>--}}
    </ul>
</nav>
