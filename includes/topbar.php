<div class="topbar">

    <nav class="navbar-custom">
        <!-- Search input -->
        <div class="search-wrap" id="search-wrap">
            <div class="search-bar">
                <input class="search-input" type="search" placeholder="Search" />
                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                    <i class="mdi mdi-close-circle"></i>
                </a>
            </div>
        </div>

        <ul class="list-inline float-right mb-0">
            <!-- User-->
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="<?php if(empty($image_path)||is_null($image_path)):echo 'assets/uploads/propic.png';else: echo $image_path;endif; ?>" alt="user" class="rounded-circle">
                    <span><?php echo $fname; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <a class="dropdown-item pro_modal" href="#" id="<?php echo $user_id; ?>"><i class="dripicons-user text-muted"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="dripicons-exit text-muted"></i> Logout</a>
                </div>
            </li>
            <!-- Search 
                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link waves-effect toggle-search" href="#"  data-target="#search-wrap">
                                <i class="mdi mdi-magnify noti-icon"></i>
                            </a>
                        </li>-->
            <!-- Fullscreen 
                        <li class="list-inline-item dropdown notification-list hidden-xs-down">
                            <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                <i class="mdi mdi-fullscreen noti-icon"></i>
                            </a>
                        </li>-->
            <!-- notification-->
            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" id="notifyIcon" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ion-ios7-bell noti-icon"></i>
                    <span class="badge badge-plan noti-icon-badge xd-none text-white" style="padding-top: .1em!important;padding-bottom:.1em!important">!</span>
                </a>
            </li>
        </ul>
        <!-- Page title -->
        <ul class="list-inline menu-left mb-0">
            <li class="list-inline-item">
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="ion-navicon"></i>
                </button>
            </li>