<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa-solid fa-circle-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px; min-width: 11rem;">
                <a class="nav-link" href="{{ url('profile') }}" role="button">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a title="Logout" title="LogOut" href="{{ route('logout') }}"
                    class=" nav-link {{ request()->is('logout*') ? 'active' : '' }}" onclick="return logout(event);">
                    <i class="fas fa-power-off"></i> LogOut
                </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </ul>

</nav>
<script type="text/javascript">
    function logout(event) {
        event.preventDefault();
        var check = confirm("Do you really want to logout?");
        if (check) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
