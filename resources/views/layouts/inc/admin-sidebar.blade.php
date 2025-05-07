<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-hospital-symbol"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Sun Clinic Hospital</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-hospital"></i>
                    <span>Department</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Department Components:</h6>
                        <a class="collapse-item" href="{{ url('admin/add-department') }}">Add Department</a>
                        <a class="collapse-item" href="{{ url('admin/department') }}">View Department</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-user-md"></i>
                    <span>Doctors</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Doctor Components:</h6>
                        <a class="collapse-item" href="{{ url('admin/add-doctor') }}">Add Doctors</a>
                        <a class="collapse-item" href="{{ url('admin/doctor') }}">View Doctor</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            

           

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Appointment Components:</h6>
                        <a class="collapse-item" href="{{ url('admin/add-appointment') }}">Add Appointment</a>
                        <a class="collapse-item" href="{{ url('admin/add-walkin') }}">Add Walk-in</a>
                        <a class="collapse-item" href="{{ url('admin/appointments') }}">View Appointments</a>
                    </div>
                </div>
            </li>



            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecords"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-file-medical"></i>
                    <span>Patient Records</span>
                </a>
                <div id="collapseRecords" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Records Components:</h6>
                        <a class="collapse-item" href="{{ url('admin/add-record') }}">Add Records</a>
                        <a class="collapse-item" href="{{ url('admin/records') }}">View Records</a>
                    </div>
                </div>
            </li>

           
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTickets"
                    aria-expanded="true" aria-controls="collapseTickets">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Ticket Management</span>
                </a>
                <div id="collapseTickets" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Ticket Components:</h6>
                        <a class="collapse-item" href="{{ url('admin/tickets') }}">Manage Queue</a>
                    </div>
                </div>
            </li>

        
            
            

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

          

        </ul>