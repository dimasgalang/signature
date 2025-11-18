<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/chutex.svg') }}" style="width: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">Chutex <sup>Sys</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if($roleusers[0]->rolename == 'Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
            aria-expanded="true" aria-controls="collapseUser">
            <i class="fas fa-fw fa-users"></i>
            <span>User</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('user.index') }}">Daftar User</a>
                <a class="collapse-item" href="{{ route('role.index') }}">Daftar Role</a>
            </div>
        </div>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApproval"
            aria-expanded="true" aria-controls="collapseApproval">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Approval</span>
        </a>
        <div id="collapseApproval" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('approval.index') }}">Approval List</a>
                <a class="collapse-item" href="{{ route('attachment.index') }}">Attachment List</a>
                <a class="collapse-item" href="{{ route('approval.indexHandover') }}">Handover List</a>
                <a class="collapse-item" href="{{ route('approval.indexLeaver') }}">Leaver List</a>
                <a class="collapse-item" href="{{ route('approval.indexCommitment') }}">Commitment List</a>
                <a class="collapse-item" href="{{ route('approval.indexItAccess') }}">IT Access List</a>
                <a class="collapse-item" href="{{ route('approval.indexDeactivate') }}">Deactivate User</a>
                @if(Auth::user()->dept === 'IT')
                <a class="collapse-item" href="{{ route('approval.indexSurveillance') }}">Surveillance System</a>
                <a class="collapse-item" href="{{ route('computer-inspection.index') }}">Computer Inspection</a>
                <a class="collapse-item" href="{{ route('finger-inspection.index') }}">Finger Inspection</a>
                @endif
            </div>
        </div>
    </li>

    {{-- @if($roleusers[0]->rolename == 'Admin' || Auth::user()->dept === 'PURCHASE' || Auth::user()->dept === 'PURCHASE HOD') --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePurchase"
            aria-expanded="true" aria-controls="collapsePurchase">
            <i class="fas fa-fw fa-check-square"></i>
            <span>Purchase</span>
        </a>
        <div id="collapsePurchase" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('purchase-requestion.index') }}">Purchase Request List</a>
            </div>
        </div>
    </li>
    {{-- @endif --}}

    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCommitment"
            aria-expanded="true" aria-controls="collapseCommitment">
            <i class="fas fa-fw fa-check-square"></i>
            <span>IT SOP</span>
        </a>
        <div id="collapseCommitment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if($roleusers[0]->rolename == 'Admin')
                    <a class="collapse-item" href="{{ route('handover.index') }}">Handover List</a>
                    <a class="collapse-item" href="{{ route('commitment.index') }}">Commitment List</a>
                @endif
                <a class="collapse-item" href="{{ route('leaver.index') }}">Leaver List</a>
                <a class="collapse-item" href="{{ route('it-access-request.index') }}">It Access List</a>
                <a class="collapse-item" href="{{ route('cyber-user.index') }}">Deactivate User</a>
            </div>
        </div>
    </li>

    @if($roleusers[0]->rolename == 'Admin')
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTools"
            aria-expanded="true" aria-controls="collapseTools">
            <i class="fas fa-fw fa-cog"></i>
            <span>Tools</span>
        </a>
        <div id="collapseTools" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('speech.index') }}">Text To Speech</a>
                <a class="collapse-item" href="{{ route('converter.index') }}">Excel To PDF</a>
            </div>
        </div>
    </li> -->
    {{-- SysLogs --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSyslogs"
            aria-expanded="true" aria-controls="collapseSyslogs">
            <i class="fas fa-fw fa-file"></i>
            <span>SysLogs</span>
        </a>
        <div id="collapseSyslogs" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('syslog.index') }}">System Logs</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTemplate"
            aria-expanded="true" aria-controls="collapseTemplate">
            <i class="fas fa-fw fa-file"></i>
            <span>Template</span>
        </a>
        <div id="collapseTemplate" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('template.lpp') }}">LPP</a>
                <a class="collapse-item" href="{{ route('template.handover') }}">Handover</a>
                <a class="collapse-item" href="{{ route('template.commitment') }}">Commitment</a>
            </div>
        </div>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExport"
            aria-expanded="true" aria-controls="collapseExport">
            <i class="fas fa-fw fa-file-pdf"></i>
            <span>Export</span>
        </a>
        <div id="collapseExport" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('export.lpp') }}">LPP</a>
                <a class="collapse-item" href="{{ route('export.lpp_pdf') }}">LPP PDF</a>
            </div>
        </div>
    </li> -->
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->

</ul>
<!-- End of Sidebar -->