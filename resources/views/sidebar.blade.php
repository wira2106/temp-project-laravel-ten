<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-2">Upload PB IDM <sup>Material Voucher</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMember"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Menu</span>
        </a>
       
        <div id="collapseMember" class="collapse {{ (request()->is('*voucher*'))||(request()->is('*zona*'))|| (request()->is('*home*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-store-setting {{ (request()->is('*upload*')) || (request()->is('*home*')) ? 'active' : '' }}" href="{{ url('/home') }}"> Upload PB IDM</a>
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*zona*')) ? 'active' : '' }}" href="{{ url('/zona') }}">Zona Majalah</a>
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*voucher*')) ? 'active' : '' }}" href="{{ url('/voucher') }}">Upload Voucher</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->
</ul>
