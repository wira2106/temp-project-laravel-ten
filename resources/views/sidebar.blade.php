<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> MB ALASAN PB DARURAT<sup> </sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item nav-item-store">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStore"
            aria-expanded="true" aria-controls="collapseDemand">
            <i class="fas fa-fw fa-cog"></i>
            <span>Store</span>
        </a>
        <div id="collapseStore" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item collapse-item-store-setting" href="{{ url('/store-setting') }}">Store
                    Setting</a>
                <a class="collapse-item collapse-item-royalti" href="{{ url('/get-royalti') }}">Royalti</a>
                <a class="collapse-item collapse-item-special-store" href="{{ url('/get-special-store') }}">Special
                    Store</a>
                <a class="collapse-item collapse-item-edit-royalti" href="{{ url('/get-edit-royalti') }}" hidden>Edit
                    Royalti</a>
                {{-- Menu Pengajuan Royalti --}}
                @if (session()->get('sequencenumber') != '1')
                    <a class="collapse-item collapse-item-approval-apply-royalti"
                        href="{{ url('/approval-apply-royalti') }}">Approval Apply
                        Royalti</a>
                @endif
                {{-- Menu Approval Royalti --}}
                @if (session()->get('sequencenumber') == '1')
                    <a class="collapse-item collapse-item-apply-royalti" href="{{ url('/apply-royalti') }}">Apply
                        Royalti</a>
                @endif
                <a class="collapse-item collapse-item-rejected-apply-royalti"
                    href="{{ url('/list-rejected-apply-royalti') }}">Rejected Apply
                    Royalti</a>
                <a class="collapse-item collapse-item-royalti-rate-report"
                    href="{{ url('/list-royalti-rate-report') }}">Royalti Rate Report</a>
                <a class="collapse-item collapse-item-monitoring-approval-report"
                    href="{{ url('/list-monitoring-approval-report') }}">Monitoring Approval</a>
                <a class="collapse-item collapse-item-royalti-recap-report"
                    href="{{ url('/list-royalti-recap-report') }}">Royalti Recap Report</a>
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
