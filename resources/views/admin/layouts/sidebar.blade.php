 <!-- Menu -->
 @php
    $permission = ['admin.permission.list','admin.permission.create','admin.permission.edit'];
    $role = ['admin.role.list','admin.role.create','admin.role.edit'];
    $staffManagement = ['admin.staff.list','admin.staff.create','admin.staff.edit'];
    $destination = ['admin.destination.country.index','admin.destination.country.create','admin.destination.country.edit'];
    $state = ['admin.destination.state.index','admin.destination.state.create','admin.destination.state.edit'];
    $region =['admin.destination.region.index','admin.destination.region.create','admin.destination.region.edit'];
    $city = ['admin.destination.city.index','admin.destination.city.create','admin.destination.city.edit'];
    $subCity = ['admin.destination.subcity.index','admin.destination.subcity.create']

 @endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class=""> <img src="{{  asset('frontend-assets/images/rent-for-vacation-logo.png') }}" alt="" srcset="" class="mx-auto d-block" style="width:100%"></span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item @if(request()->route()->getName()=='admin.dashboard') active @endif">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>


        @canany(['country-list','country-create','country-edit','country-delete','state-list','state-create','state-edit','state-delete','','region-list','region-create','region-edit','region-delete','city-create','city-list','city-edit','city-delete','sub-city-list','sub-city-create','sub-city-edit','sub-city-delete'])
            {{-- Destination Management --}}
            <li class="menu-item @if(in_array(request()->route()->getName(),array_merge($destination,$state, $region,$city,$subCity))) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Destination</div>
                </a>
                <ul class="menu-sub">
                    @canany('country-list','country-create','country-edit','country-delete')
                        <li class="menu-item  @if(in_array(request()->route()->getName(),$destination)) active @endif">
                            <a href="{{ route("admin.destination.country.index") }}" class="menu-link">
                                <div data-i18n="Without menu">Manage Country</div>
                            </a>
                        </li>
                    @endcanany
                    @canany('state-list','state-create','state-edit','state-delete')
                        <li class="menu-item  @if(in_array(request()->route()->getName(),$state)) active @endif">
                            <a href="{{ route("admin.destination.state.index") }}" class="menu-link">
                                <div data-i18n="Without menu">Manage State</div>
                            </a>
                        </li>
                    @endcanany
                    @canany('region-list','region-create','region-delete','region-edit')
                        <li class="menu-item  @if(in_array(request()->route()->getName(),$region)) active @endif">
                            <a href="{{ route("admin.destination.region.index") }}" class="menu-link">
                                <div data-i18n="Without menu">Manage Region</div>
                            </a>
                        </li>
                    @endcanany
                    @canany('city-list','city-edit','city-delete','city-create')
                        <li class="menu-item  @if(in_array(request()->route()->getName(),$city)) active @endif">
                            <a href="{{ route("admin.destination.city.index") }}" class="menu-link">
                                <div data-i18n="Without menu">Manage City</div>
                            </a>
                        </li>
                    @endcanany
                    @canany('sub-city-list','sub-city-create','sub-city-edit','sub-city-delete')
                        <li class="menu-item  @if(in_array(request()->route()->getName(),$subCity)) active @endif">
                            <a href="{{ route("admin.destination.subcity.index") }}" class="menu-link">
                                <div data-i18n="Without menu">Manage Sub City</div>
                            </a>
                        </li>
                    @endcanany
                </ul>
            </li>
        @endcanany

        @canany(['role-create','role-list','role-edit','role-delete','permission-list','permission-create','permission-edit','permission-delete'])
            <!-- Role Management -->
            <li class="menu-item @if(in_array(request()->route()->getName(),array_merge($permission,$role))) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Role Management</div>
                </a>
                <ul class="menu-sub">
                    @can('role-list')
                        <li class="menu-item  @if(in_array(request()->route()->getName(),$role)) active @endif">
                            <a href="{{ route("admin.role.list") }}" class="menu-link">
                                <div data-i18n="Without menu">Manage Role</div>
                            </a>
                        </li>
                    @endcan
                    @can('permission-list')
                    <li class="menu-item  @if(in_array(request()->route()->getName(),$permission)) active @endif">
                        <a href="{{ route('admin.permission.list') }}" class="menu-link">
                            <div data-i18n="Without navbar">Manage Permission</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany
        @canany(['user-list','user-edit', 'user-create','user-delete'])
           <!-- User Management -->
            <li class="menu-item @if(in_array(request()->route()->getName(),array_merge($staffManagement,['admin.owner.index']))) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Staff Management</div>
                </a>
                <ul class="menu-sub">
                    @can('user-list')
                    <li class="menu-item  @if(in_array(request()->route()->getName(),$staffManagement)) active @endif">
                        <a href="{{ route("admin.staff.list") }}" class="menu-link">
                            <div data-i18n="Without menu">Manage Staff</div>
                        </a>
                    </li>
                    @endcan
                    @can('owner-list')
                    <li class="menu-item  @if(in_array(request()->route()->getName(),array('admin.owner.index'))) active @endif">
                        <a href="{{ route("admin.owner.index") }}" class="menu-link">
                            <div data-i18n="Without menu">Manage Owner</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        @canany(['property-list','property-create'])
        <li class="menu-item @if(in_array(request()->route()->getName(),array('admin.property.index','admin.property.create'))) active @endif">
            <a href="{{ route('admin.property.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Manage Property</div>
            </a>
        </li>
        @endcanany
    </ul>
  </aside>
  <!-- / Menu -->
  <!-- Layout container -->
  <div class="layout-page">
