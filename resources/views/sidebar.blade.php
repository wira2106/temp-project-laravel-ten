<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Monitor Alokasi <sup>OMI</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlokasi"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Alokasi</span>
        </a>
       
        <div id="collapseAlokasi" class="collapse {{ (request()->is('*alokasi*'))|| (request()->is('*home*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-store-setting {{ (request()->is('*home*') || request()->is('*seasonal*'))  && !request()->is('*khusus*')? 'active' : '' }}" href="{{ url('/home/alokasi/seasonal') }}"> Alokasi seasonal</a>
                <a class="collapse-item collapse-item-store-setting {{ (request()->is('*khusus*')) ? 'active' : '' }}" href="{{ url('/home/alokasi/khusus') }}"> Alokasi khusus</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMonitoring"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Monitoring</span>
        </a>
       
        <div id="collapseMonitoring" class="collapse {{ (request()->is('*monitoring*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*bytoko*')) ? 'active' : '' }}" href="{{ url('/monitoring/bytoko') }}">Monitoring by toko</a>
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*byitem*')) ? 'active' : '' }}" href="{{ url('/monitoring/byitem') }}">Monitoring by item</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmail"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Email</span>
        </a>
       
        <div id="collapseEmail" class="collapse {{ (request()->is('*email*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*email*')) ? 'active' : '' }}" href="{{ url('/email') }}">Email</a>
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
