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

                        <?php
                        // $notify=  App\Models\Notification::where('active', 1)->count();
                        ?>
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

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fab fa-product-hunt"></i>
                        <span key="t-tasks">Product Management</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        @can('Product-View')
                        <li><a href="{{ route('product-bundle.list')}}">Product Bundle</a></li>
                        @endcan

                        @can('Categories-View')
                        <li><a href="{{ route('categories.list') }}">Category</a></li>
                        @endcan

                        @can('SubCategories-View')
                        <li><a href="{{ route('sub-category.list')}}">Sub Category</a></li>
                        @endcan

                        @can('Product-View')
                        <li><a href="{{ route('product.list')}}">Product</a></li>
                        @endcan
                    </ul>
                </li>

                @hasanyrole('Admin|Brand Manager|Developer')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-globe"></i>
                        <span key="t-tasks">Brand Setting</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="false">
                        <li>
                        <li><a href="{{ route('admin-brand-settings-general-setting')}}">General Setting</a></li>
                        <li><a href="{{ route('admin-brand-settings-custom-header-footer-form')}}">Custom Header & Footer</a></li>
                    </ul>
                </li>
                @endhasanyrole

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
