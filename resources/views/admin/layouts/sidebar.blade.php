<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('admin.dashboard')}}" class="waves-effect">
                        <i class="bx bx-home-circle"></i><span class="badge rounded-pill bg-info float-end"></span>
                        <span key="t-dashboards">Dashboard</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('admin-notification.main')}}" class="waves-effect">
                        <i class="bx bx-bell"></i>
                        <span class="badge bg-danger rounded-pill float-end"></span>
                        <span key="t-dashboards">Notifications</span>
                        <span class="badge bg-danger rounded-pill float-end"></span>

                    </a>

                </li>

                @can('User-View','Role-View','Permission-Create')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-group"></i>
                            <span key="t-tasks">User Management</span>
                        </a>
                        <ul class="sub-menu mm-collapse" aria-expanded="false">
                            @can('User-View')
                            <li><a href="{{ route('user.list')}}">User List</a></li>
                            @endcan
                            @can('Role-View')
                            <li><a href="{{ route('role.list')}}">Roles</a></li>
                            @endcan
                            @can('Permission-View')
                            <li><a href="{{ route('permission.list')}}">Permissions</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                
                @can('Subject-View','Subject-Create','Subject-Edit','Subject-Delete')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fab fa-product-hunt"></i>
                            <span key="t-tasks">Subject</span>
                        </a>
                        <ul class="sub-menu mm-collapse" aria-expanded="false">
                            @can('Subject-Create')
                            <li><a href="{{ route('subject.add') }}">Create Subject</a></li>
                            @endcan

                            @can('Subject-View')
                            <li><a href="{{ route('subject.list') }}">Subject List</a></li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @can('Quiz-View','Quiz-Create','Quiz-Edit','Quiz-Delete')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fab fa-product-hunt"></i>
                            <span key="t-tasks">Quiz</span>
                        </a>
                        <ul class="sub-menu mm-collapse" aria-expanded="false">
                            @can('Quiz-Create')
                            <li><a href="{{ route('quiz.add') }}">Create Quiz</a></li>
                            @endcan

                            @can('Quiz-View')
                            <li><a href="{{ route('quiz.list') }}">Quiz List</a></li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                @hasanyrole('Admin')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-globe"></i>
                        <span key="t-tasks">Setting</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li>
                        <li><a href="{{ route('admin-brand-settings-general-setting')}}">General Setting</a></li>
                    </ul>
                </li>
                @endhasanyrole

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
