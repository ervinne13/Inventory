<div class="navbar-default navbar navbar-fixed-top">
    <div class="container-fluid">

        <div class="navbar-header">
            <a class="current navbar-brand" href="../index.html">
                <!--<img alt="{{config('organization_name')}}" class="h-20" src="{{skarla_images_url("logo-warning-black@2X.png")}}">-->
            </a>
            <button class="action-right-sidebar-toggle navbar-toggle collapsed" data-target="#navdbar" data-toggle="collapse" type="button" data-original-title="" title="">
                <i class="fa fa-fw fa-align-right"></i>
            </button>
            <button class="navbar-toggle collapsed" data-target="#navbar" data-toggle="collapse" type="button">
                <i class="fa fa-fw fa-user"></i>
            </button>
            <button class="action-sidebar-open navbar-toggle collapsed" type="button">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar">

            <!-- START Left Side Navbar -->
            <ul class="nav navbar-nav navbar-left clearfix yamm">

                <!-- START Switch Sidebar ON/OFF -->
                <li id="sidebar-switch" class="hidden-xs">
                    <a class="action-toggle-sidebar-slim" data-placement="bottom" data-toggle="tooltip" href="javascript: void(0)" title="" data-original-title="Slim sidebar on/off">
                        <i class="fa fa-lg fa-bars fa-fw"></i>
                    </a>
                </li>
                <!-- END Switch Sidebar ON/OFF -->

                <li>
                    <a href="javascript: void(0)" role="button">
                        <strong>{{config("app.name")}}</strong> {{config("app.organization_name")}}
                    </a>
                </li>
            </ul>
            <!-- START Left Side Navbar -->

            <!-- START Right Side Navbar -->
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">

                    <!-- START Icon Notification with Badge (10)-->
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript: void(0)" role="button">
                        <i class="fa fa-lg fa-fw fa-link hidden-xs"></i>
                        <span class="hidden-xs hidden-sm">
                            Quick Links
                        </span>
                    </a>
                    <!-- END Icon Notification with Badge (10)-->

                    <!-- START Notification Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-right p-t-0 b-t-0 p-b-0 b-b-0 b-a-0">
                        <li>
                            <div class="yamm-content p-t-0 p-r-0 p-l-0 p-b-0">
                                <ul class="list-group m-b-0 b-b-0">
                                    <li class="list-group-item b-r-0 b-l-0 b-r-0 b-t-r-0  b-t-l-0 b-b-2 w-350">
                                        <small class="text-uppercase">
                                            <strong>Quick Links</strong>
                                        </small>
                                        <a role="button" href="../apps/settings-edit.html" class="btn m-t-0 btn-xs btn-default pull-right">
                                            <i class="fa fa-fw fa-gear"></i>
                                        </a>
                                    </li>

                                    <!-- START Scroll Inside Panel -->
                                    <li class="list-group-item b-a-0 p-x-0 p-y-0 b-t-0">
                                        <div class="scroll-300 custom-scrollbar ps-container ps-theme-default">
                                            <a href="#download-here" class="list-group-item b-r-0 b-t-0 b-l-0">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="fa-stack fa-lg">
                                                            <i class="fa fa-circle-thin fa-stack-2x text-primary"></i>
                                                            <i class="fa fa-file fa-stack-1x text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="m-t-0">
                                                            <span>
                                                                Leave Request Form
                                                            </span>
                                                            <p class="small"> Click to download</p>
                                                        </h5>
                                                        <p class="text-nowrap small m-b-0">
                                                            <span>Last Update: 25-May-2014, 02:43</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#download-here" class="list-group-item b-r-0 b-t-0 b-l-0">
                                                <div class="media">
                                                    <div class="media-left">
                                                        <span class="fa-stack fa-lg">
                                                            <i class="fa fa-circle-thin fa-stack-2x text-primary"></i>
                                                            <i class="fa fa-file fa-stack-1x text-primary"></i>
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h5 class="m-t-0">
                                                            <span>
                                                                Overtime Request Form
                                                            </span>
                                                            <p class="small"> Click to download</p>
                                                        </h5>
                                                        <p class="text-nowrap small m-b-0">
                                                            <span>Last Update: 25-May-2014, 02:43</span>
                                                        </p>
                                                    </div>
                                                    </                                                                                                                                                                                                        div>
                                            </a>
                                        </div                                                                                                                                                                                                        >                                                                                                                                                                                                                                  
                                    </li>

                                </ul>
                            </div>

                        </li>
                    </ul>
                    <!-- END Notification Dropdown Menu -->

                </li>
                <!-- END Notification -->

                <li role="separator" class="divider hidden-lg hidden-md hidden-sm"></li>

                <li>
                    @if (Auth::check())
                    <a href="{{url("/logout")}}" role="button">
                        Logout
                    </a>
                    @else
                    <a href="{{url("/login")}}" role="button">
                        Login
                    </a>
                    @endif
                </li>
            </ul>
            <!-- END Right Side Navbar -->
        </div>

    </div>
</div>