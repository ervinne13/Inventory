
@if (Auth::check())

<?php
if (!session("currentUser.accessibleModuleOrder")) {
    Auth::user()->resetAccessibleModuleOrder();    
}
?>

<aside class="navbar-default sidebar ps-container ps-theme-default affix-top" data-ps-id="e55246e4-d50d-cbc7-c347-7277b532fe40">
    <div class="sidebar-overlay-head">
        <img src="{{skarla_images_url("logo-warning-white@2X.png")}}" alt="Logo" width="80">
        <a href="javascript: void(0)" class="sidebar-switch action-sidebar-close">
            <i class="fa fa-times"></i>
        </a>
    </div>
    <div class="sidebar-content">
        <!-- START Sidebar Header -->
        <div class="add-on-container">
            <div class="sidebar-container-default sidebar-section">
                <div class="media">                  
                    <div class="media-body">
                        <h5 class="media-heading text-white m-t-0 m-b-0"><span>{{Auth::user()->display_name}}</span></h5>
                        <small>{{Auth::user()->getSerializedRoleNames()}}</small>
                    </div>
                    <div class="media-right media-middle">
                        <i class="fa fa-fw fa-user"></i>
                    </div>
                </div>                

            </div>
        </div>
        <!-- END Sidebar Header -->

        <div class="sidebar-content">
            <div class="sidebar-default-visible small text-uppercase sidebar-section m-t-3 m-b-2">
                <strong>Navigation</strong>
            </div>

            <!-- START Tree Sidebar Common -->
            <ul class="side-menu auto-select-sidebar-nav">

                <li class="">
                    <a href="{{url("/")}}">
                        <i class="fa fa-home fa-lg fa-fw"></i>
                        <span class="nav-label">Home</span>                                
                    </a>
                </li>                
                @foreach (session("currentUser.accessibleModuleOrder") AS $moduleGroup)
                <li class="primary-submenu has-submenu">
                    <a href="javascript: void(0)" title="{{$moduleGroup["name"]}}" class="menu-toggle">
                        <i class="fa {{$moduleGroup["icon"]}} fa-lg fa-fw"></i>
                        <span class="nav-label">{{$moduleGroup["name"]}}</span>
                        <i class="fa arrow"></i>
                    </a>
                    <ul data-submenu-title="{{$moduleGroup["name"]}}" class="submenu-level-1 auto-select-sidebar-nav">

                        @foreach($moduleGroup["modules"] AS $module)
                        <li class="">
                            <a href="{{url($module["url"])}}">
                                <i class="fa {{$module["icon"]}} fa-lg fa-fw"></i>
                                <span class="nav-label">{{$module["name"]}}</span>                                
                            </a>
                        </li>
                        @endforeach                       
                    </ul>
                </li>
                @endforeach

            </ul>
            <!-- END Tree Sidebar Common  -->

        </div>

    </div>   
</aside>

@endif