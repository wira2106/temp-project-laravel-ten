<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Member <sup>HO</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMember"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Menu</span>
        </a>
       
        <div id="collapseMember" class="collapse {{ (request()->is('*sms*'))|| (request()->is('*home*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-store-setting {{ (request()->is('*list*')) || (request()->is('*home*')) ? 'active' : '' }}" href="{{ url('/home') }}"> Member</a>
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*sms*')) ? 'active' : '' }}" href="{{ url('/sms') }}">SMS</a>
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
