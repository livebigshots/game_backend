<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link anchor text-center">
        <img src="{{ asset('Images/logo.png') }}" alt="Game Prediction" class="brand-image"
            style="opacity: .8; padding-left:22%">
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>
    @php
        $routeArray = request()->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $action) = explode('@', $controllerAction);
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item active" >
                    <a href="{{route('dashboard') }}" class="nav-link {{ (request()->is('dashboard*')) ? 'active' : '' }}">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>Dashboard</p>

                    </a>
                </li>
                <li class="nav-item active z">
                    <a href="{{route('user-list') }}"  class="nav-link {{ in_array( $controller, ['UserController']) ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                      <p style="margin-left: 10px">Users</p>
                    </a>
                </li>
                <li class="nav-item active z">
                    <a href="{{route('color-prediction-list') }}"  class="nav-link {{ in_array( $controller, ['ColorPredictionController']) ? 'active' : '' }}">
                        <i class="fas fa-paint-brush"></i>
                      <p style="margin-left: 10px">Color Prediction</p>
                    </a>
                </li>
                <li class="nav-item active z">
                    <a href="{{route('number-prediction-list') }}"  class="nav-link {{ in_array( $controller, ['NumberPredictionController']) ? 'active' : '' }}">
                        <i class="fas fa-gamepad"></i>
                      <p style="margin-left: 10px">Number Prediction</p>
                    </a>
                </li>
                <li class="nav-item active z">
                    <a href="{{route('payment-list') }}"  class="nav-link {{ in_array( $controller, ['PaymentController']) ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave"></i>
                        <p style="margin-left: 10px">Payment</p>
                    </a>
                </li>
                <li class="nav-item active z">
                    <a href="{{route('withdraw-list') }}"  class="nav-link {{ in_array( $controller, ['WithdrawController']) ? 'active' : '' }}">
                        <i class="fas fa-cash-register"></i>
                        <p style="margin-left: 10px">Withdraw</p>
                    </a>
                </li>
                <li class="nav-item active z">
                    <a href="{{route('contact-list') }}"  class="nav-link {{ in_array( $controller, ['ContactUsController']) ? 'active' : '' }}">
                        <i class="fas fa-phone"></i>
                        <p style="margin-left: 10px">Contact Us</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
