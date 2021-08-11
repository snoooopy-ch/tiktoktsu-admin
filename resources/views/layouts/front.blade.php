<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ env('APP_NAME') }}&nbsp;&nbsp;@yield('title')</title>
    <link rel="apple-touch-icon" href="{{ cAsset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ cAsset('favicon.png') }}">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ cAsset('app-assets/vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ cAsset('app-assets/vendors/css/extensions/shepherd-theme-default.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ cAsset('app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/pages/card-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/plugins/tour/tour.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/pages/app-user.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/custom.css') }}">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ cAsset('app-assets/css/custom-theme.css') }}">

    @yield('styles')
    <style>
        .dataTables_filter {
            display: none;
        }

    </style>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 2-columns  navbar-floating footer-static pink-body" data-open="hover"
    data-menu="horizontal-menu" data-col="2-columns">

    <?php $user = Auth::user(); ?>
    <!-- BEGIN: Header-->
    <?php $routeName = Route::currentRouteName(); ?>

    <div class="container1000" style="">
        <nav
            class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-fixed navbar-shadow navbar-brand-center">
            <!-- スマホヘッダー-->
            <div class="navbar-wrapper">
                <div class="navbar-container content">
                    <div class="navbar-collapse justify-content-end" id="navbar-mobile">
                        <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                            <ul class="nav navbar-nav d-lg-none">
                                <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                        class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                            class="ficon feather icon-menu"></i></a></li>
                            </ul>
                            <a class="nav navbar-nav" href="{{ route('dashboard') }}"><img
                                    src="{{ cAsset('images/customer_1627208365.png') }}" width="50" /></a>
                            <ul class="nav navbar-nav bookmark-icons d-lg-none">
                                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-todo.html"
                                        data-toggle="tooltip" data-placement="top" title="Todo"><i
                                            class="ficon feather icon-check-square"></i></a></li>
                                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html"
                                        data-toggle="tooltip" data-placement="top" title="Chat"><i
                                            class="ficon feather icon-message-square"></i></a></li>
                                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html"
                                        data-toggle="tooltip" data-placement="top" title="Email"><i
                                            class="ficon feather icon-mail"></i></a></li>
                                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-calender.html"
                                        data-toggle="tooltip" data-placement="top" title="Calendar"><i
                                            class="ficon feather icon-calendar"></i></a></li>
                            </ul>
                            <ul class="nav navbar-nav d-lg-none">
                                <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i
                                            class="ficon feather icon-star warning"></i></a>
                                    <div class="bookmark-input search-input">
                                        <div class="bookmark-input-icon"><i class="feather icon-search primary"></i>
                                        </div>
                                        <input class="form-control input" type="text" placeholder="Explore Vuexy..."
                                            tabindex="0" data-search="template-list">
                                        <ul class="search-list search-list-bookmark"></ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-language nav-item d-none"><a class="dropdown-toggle nav-link"
                                    id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span
                                        class="selected-language">English</span></a>
                                <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item"
                                        href="#" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a
                                        class="dropdown-item" href="#" data-language="fr"><i
                                            class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item"
                                        href="#" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a
                                        class="dropdown-item" href="#" data-language="pt"><i
                                            class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
                            </li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link"
                                    style="margin-top: 3px">登録TikToker数
                                    {{ number_format($countInAll) }}人</a></li>
                            <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i
                                        class="ficon feather icon-search"></i></a>
                                <div class="search-input">
                                    <div class="search-input-icon"><i class="feather icon-search primary"></i></div>
                                    <input class="input" type="text" placeholder="検索する" tabindex="-1"
                                        id="search-input-keyword">
                                    <div class="search-input-close"><i class="feather icon-x"></i></div>
                                </div>
                            </li>
                            <li class="dropdown dropdown-notification nav-item d-none"><a
                                    class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i
                                        class="ficon feather icon-bell"></i><span
                                        class="badge badge-pill badge-primary badge-up">5</span></a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <div class="dropdown-header m-0 p-2">
                                            <h3 class="white">5 New</h3><span class="notification-title">App
                                                Notifications</span>
                                        </div>
                                    </li>
                                    <li class="scrollable-container media-list"><a
                                            class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i
                                                        class="feather icon-plus-square font-medium-5 primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="primary media-heading">You have new order!</h6><small
                                                        class="notification-text"> Are your going to meet me
                                                        tonight?</small>
                                                </div><small>
                                                    <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">9
                                                        hours ago</time></small>
                                            </div>
                                        </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i
                                                        class="feather icon-download-cloud font-medium-5 success"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="success media-heading red darken-1">99% Server load</h6>
                                                    <small class="notification-text">You got new order of goods.</small>
                                                </div><small>
                                                    <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">5 hour
                                                        ago</time></small>
                                            </div>
                                        </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i
                                                        class="feather icon-alert-triangle font-medium-5 danger"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="danger media-heading yellow darken-3">Warning
                                                        notifixation</h6><small class="notification-text">Server have
                                                        99% CPU usage.</small>
                                                </div><small>
                                                    <time class="media-meta"
                                                        datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                                            </div>
                                        </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i
                                                        class="feather icon-check-circle font-medium-5 info"></i></div>
                                                <div class="media-body">
                                                    <h6 class="info media-heading">Complete the task</h6><small
                                                        class="notification-text">Cake sesame snaps cupcake</small>
                                                </div><small>
                                                    <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last
                                                        week</time></small>
                                            </div>
                                        </a><a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i
                                                        class="feather icon-file font-medium-5 warning"></i></div>
                                                <div class="media-body">
                                                    <h6 class="warning media-heading">Generate monthly report</h6><small
                                                        class="notification-text">Chocolate cake oat cake tiramisu
                                                        marzipan</small>
                                                </div><small>
                                                    <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">Last
                                                        month</time></small>
                                            </div>
                                        </a></li>
                                    <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center"
                                            href="javascript:void(0)">Read all notifications</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-user nav-item d-none"><a
                                    class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">John
                                            Doe</span><span class="user-status">Available</span></div><span><img
                                            class="round"
                                            src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar"
                                            height="40" width="40"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                        href="page-user-profile.html"><i class="feather icon-user"></i> Edit
                                        Profile</a><a class="dropdown-item" href="app-email.html"><i
                                            class="feather icon-mail"></i> My Inbox</a><a class="dropdown-item"
                                        href="app-todo.html"><i class="feather icon-check-square"></i> Task</a><a
                                        class="dropdown-item" href="app-chat.html"><i
                                            class="feather icon-message-square"></i> Chats</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item"
                                        href="auth-login.html"><i class="feather icon-power"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <ul class="main-search-list-defaultlist d-none">
            <li class="d-flex align-items-center"><a class="pb-25" href="#">
                    <h6 class="text-primary mb-0">Files</h6>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between w-100" href="#">
                    <div class="d-flex">
                        <div class="mr-50"><img src="../../../app-assets/images/icons/xls.png" alt="png" height="32">
                        </div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">Two new item submitted</p><small
                                class="text-muted">Marketing Manager</small>
                        </div>
                    </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between w-100" href="#">
                    <div class="d-flex">
                        <div class="mr-50"><img src="../../../app-assets/images/icons/jpg.png" alt="png" height="32">
                        </div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                                Developer</small>
                        </div>
                    </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between w-100" href="#">
                    <div class="d-flex">
                        <div class="mr-50"><img src="../../../app-assets/images/icons/pdf.png" alt="png" height="32">
                        </div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                                Marketing Manager</small>
                        </div>
                    </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between w-100" href="#">
                    <div class="d-flex">
                        <div class="mr-50"><img src="../../../app-assets/images/icons/doc.png" alt="png" height="32">
                        </div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">Anna_Strong</p><small class="text-muted">Web
                                Designer</small>
                        </div>
                    </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
                </a></li>
            <li class="d-flex align-items-center"><a class="pb-25" href="#">
                    <h6 class="text-primary mb-0">Members</h6>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                    <div class="d-flex align-items-center">
                        <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg"
                                alt="png" height="32"></div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                        </div>
                    </div>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                    <div class="d-flex align-items-center">
                        <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg"
                                alt="png" height="32"></div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                                Developer</small>
                        </div>
                    </div>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                    <div class="d-flex align-items-center">
                        <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg"
                                alt="png" height="32"></div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital
                                Marketing Manager</small>
                        </div>
                    </div>
                </a></li>
            <li class="auto-suggestion d-flex align-items-center cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between py-50 w-100" href="#">
                    <div class="d-flex align-items-center">
                        <div class="avatar mr-50"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg"
                                alt="png" height="32"></div>
                        <div class="search-data">
                            <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web
                                Designer</small>
                        </div>
                    </div>
                </a></li>
        </ul>
        <ul class="main-search-list-defaultlist-other-list d-none">
            <li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer"><a
                    class="d-flex align-items-center justify-content-between w-100 py-50">
                    <div class="d-flex justify-content-start"><span
                            class="mr-75 feather icon-alert-circle"></span><span>No results found.</span></div>
                </a></li>
        </ul>
        <!-- END: Header-->

        <!-- BEGIN: Main Menu-->
        <div class="horizontal-menu-wrapper">
            <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-without-dd-arrow navbar-shadow menu-border"
                role="navigation" data-menu="menu-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mr-auto"><a class="navbar-brand"
                                href="../../../html/ltr/horizontal-menu-template/index.html">
                                <div class="brand-logo"></div>
                                <h2 class="brand-text mb-0">Vuexy</h2>
                            </a></li>
                        <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0"
                                data-toggle="collapse"><i
                                    class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                                    class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                                    data-ticon="icon-disc"></i></a></li>
                    </ul>
                </div>
                <!-- Horizontal menu content-->
                <div class="navbar-container main-menu-content" data-menu="menu-container">
                    <!-- include ../../../includes/mixins-->
                    <ul class="nav navbar-nav justify-content-around" id="main-menu-navigation"
                        data-menu="menu-navigation">
                        <li class="nav-item" data-menu="">
                            <a class="nav-link" href="{{ route('publish') }}" data-toggle=""><i
                                    class="feather icon-user-plus"></i><span data-i18n="Apps">掲載</span></a>
                        </li>
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link"
                                href="index.html" data-toggle="dropdown"><i class="feather icon-home"></i><span
                                    data-i18n="Dashboard">急上昇</span></a>
                            <ul class="dropdown-menu">
                                <li class="" data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.rank', ['key' => 'follower']) }}"
                                        data-toggle="dropdown" data-i18n="Analytics"><i
                                            class="feather icon-users"></i>フォロワー数</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.rank', ['key' => 'heart']) }}"
                                        data-toggle="dropdown" data-i18n="eCommerce"><i
                                            class="feather icon-heart"></i>いいね数</a>
                                </li>
                                <li data-menu="" class="d-none"><a class="dropdown-item"
                                        href="{{ route('dashboard.rank', ['key' => 'music']) }}"
                                        data-toggle="dropdown" data-i18n="eCommerce"><i
                                            class="feather icon-film"></i>楽曲数</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href=""
                                data-toggle="dropdown"><i class="feather icon-users"></i><span
                                    data-i18n="Apps">フォロワー数</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.subrank', ['key' => 'follower', 'period' => 'week']) }}"
                                        data-toggle="dropdown" data-i18n="Email"><i
                                            class="feather icon-activity"></i>週間ランキング</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.subrank', ['key' => 'follower', 'period' => 'month']) }}"
                                        data-toggle="dropdown" data-i18n="Chat"><i
                                            class="feather icon-activity"></i>月間ランキング</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href=""
                                data-toggle="dropdown"><i class="feather icon-heart"></i><span
                                    data-i18n="Apps">いいね数</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.subrank', ['key' => 'heart', 'period' => 'week']) }}"
                                        data-toggle="dropdown" data-i18n="Email"><i
                                            class="feather icon-activity"></i>週間ランキング</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.subrank', ['key' => 'heart', 'period' => 'month']) }}"
                                        data-toggle="dropdown" data-i18n="Chat"><i
                                            class="feather icon-activity"></i>月間ランキング</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href=""
                                data-toggle="dropdown"><i class="feather icon-tv"></i><span
                                    data-i18n="Apps">動画投稿数</span></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.subrank', ['key' => 'music', 'period' => 'week']) }}"
                                        data-toggle="dropdown" data-i18n="Email"><i
                                            class="feather icon-activity"></i>週間ランキング</a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                        href="{{ route('dashboard.subrank', ['key' => 'music', 'period' => 'month']) }}"
                                        data-toggle="dropdown" data-i18n="Chat"><i
                                            class="feather icon-activity"></i>月間ランキング</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" data-menu=""><a class="nav-link" href="{{ route('trend.index') }}"
                                data-toggle=""><i class="feather icon-film"></i><span data-i18n="Apps">人気楽曲</span></a>
                        </li>

                        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#"
                                data-toggle="dropdown"><i class="feather icon-file-plus"></i><span
                                    data-i18n="Apps">ジャンル別</span></a>
                            <ul class="dropdown-menu">
                                @foreach ($categories as $index => $category)
                                    <li data-menu=""><a class="dropdown-item"
                                            href="{{ route('dashboard.category', ['category' => $index]) }}"
                                            data-toggle="dropdown" data-i18n=""><i
                                                class="feather icon-file-plus"></i>{{ $category[0] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="nav-item" data-menu=""><a class="nav-link" href="{{ route('posts') }}"
                                data-toggle=""><i class="feather icon-file-text"></i><span
                                    data-i18n="Apps">ニュース</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        <div class="app-content content">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            <div class="content-wrapper p-0">
                <div class="content-header row">
                    <div class="content-header-left col-md-9 col-12 mb-2">
                        <div class="row breadcrumbs-top">
                            <div class="col-12">
                                <h2 class="content-header-title float-left mb-0">@yield('title')</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-body">
                    @yield('contents')
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        <footer class="footer footer-static footer-light navbar-shadow">
            <a href="{{ route('contact.index') }}">お問い合わせはこちら</a>
            <p class="clearfix blue-grey lighten-2 mb-0"><span class="d-block d-md-inline-block mt-25">COPYRIGHT
                    &copy;2021
                    <a class="text-bold-800 grey darken-2" href="{{ route('home') }}" target="_blank">WEBSTYLE,Inc.
                    </a>All rights Reserved</span>
                <button class="btn btn-primary btn-icon scroll-top" type="button"><i
                        class="feather icon-arrow-up"></i></button>
            </p>
        </footer>
        <!-- END: Footer-->

    </div>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ cAsset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!--<script src="{{ cAsset('app-assets/vendors/js/charts/apexcharts.min.js') }}"></script>-->
    <script src="{{ cAsset('app-assets/vendors/js/extensions/tether.min.js') }}"></script>
    <!--<script src="{{ cAsset('app-assets/vendors/js/extensions/shepherd.min.js') }}"></script>-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ cAsset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ cAsset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ cAsset('app-assets/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ cAsset('vendor/bootbox/bootbox.js') }}"></script>
    <script src="{{ cAsset('js/__common.js') }}"></script>
    <!-- END: Page JS-->

    <script>
        var PUBLIC_URL = '{{ cAsset('/') . '/' }}';
        var BASE_URL = PUBLIC_URL;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $("#search-input-keyword").keyup(function(event) {
            event.stopPropagation();
            event.stopImmediatePropagation();
            event.preventDefault();

            let val = event.target.value;
            if (event.keyCode === 13) {
                if (typeof userTable == 'undefined') {
                    window.location.href = BASE_URL + 'user/' + val;
                } else {
                    userTable.column(2).search(val);
                    userTable.draw();
                    userTable.column(2).search('');
                    event.target.value = '';
                    event.target.blur();
                    $(".search-input-close i").trigger("click");
                }
            }
        });

    </script>

    @yield('scripts')

</body>
<!-- END: Body-->

</html>
