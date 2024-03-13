<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Stock Opname <sup>IC</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseinitial_so"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Initial SO</span>
        </a>
       
        <div id="collapseinitial_so" class="collapse {{ (request()->is('*home*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*home*')) ? 'active' : '' }}" href="{{ url('/home') }}">Initial SO</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseproses_draft_lhso"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Proses Draft LHSO</span>
        </a>
       
        <div id="collapseproses_draft_lhso" class="collapse {{ (request()->is('*proses_draft_lhso*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*proses_draft_lhso*')) ? 'active' : '' }}" href="{{ url('/proses_draft_lhso') }}">Proses Draft LHSO</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseadjust_so"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Adjust SO</span>
        </a>
       
        <div id="collapseadjust_so" class="collapse {{ (request()->is('*adjust_so*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*adjust_so*')) ? 'active' : '' }}" href="{{ url('/adjust_so') }}">Adjust SO</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsereset_so"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Reset SO</span>
        </a>
       
        <div id="collapsereset_so" class="collapse {{ (request()->is('*reset_so*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*reset_so*')) ? 'active' : '' }}" href="{{ url('/reset_so') }}">Reset SO</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsereport"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Report</span>
        </a>
       
        <div id="collapsereport" class="collapse {{ (request()->is('*report*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*report*')) ? 'active' : '' }}" href="{{ url('/report') }}">Report</a>
            </div>
        </div>
    </li>
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsemonitoring_so"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Monitoring SO</span>
        </a>
       
        <div id="collapsemonitoring_so" class="collapse {{ (request()->is('*monitoring_so*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-royalti {{ (request()->is('*monitoring_so*')) ? 'active' : '' }}" href="{{ url('/monitoring_so') }}">Monitoring SO</a>
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
