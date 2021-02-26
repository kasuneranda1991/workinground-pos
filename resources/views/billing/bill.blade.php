<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title> {{ Auth::user()->shop->shop_name }} | Workinground.com | POS Billing Dashboard </title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('logo/logo.png')}}" type="image/x-icon">
    <!-- to avoid mixed content error ajax http to https -->
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <!-- <link href="billing/plugins/bootstrap/css/bootstrap.css" rel="stylesheet"> -->
    <link href="https://res.cloudinary.com/workinground/raw/upload/v1556009990/billing/plugins/bootstrap/css/bootstrap.min_wiith2.css" rel="stylesheet">

    <!-- JQuery DataTable Css -->
    <!-- <link href="billing/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet"> -->
    <link href="https://res.cloudinary.com/workinground/raw/upload/v1556012470/billing/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.min_xjaywt.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <!-- <link href="billing/plugins/node-waves/waves.css" rel="stylesheet" /> -->
    <link href="https://res.cloudinary.com/workinground/raw/upload/v1556012681/billing/plugins/node-waves/waves.min_ki7wvg.css" rel="stylesheet" />
    <!-- <link href="billing/css/materialize.css" rel="stylesheet" /> -->
    <link href="https://res.cloudinary.com/workinground/raw/upload/v1556009976/billing/css/materialize_jv6mlf.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/search.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.min.css" rel="stylesheet" />
    <!-- Custom Css -->
    <link href="https://res.cloudinary.com/workinground/raw/upload/v1556009978/billing/css/style.min_er0uzo.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="https://res.cloudinary.com/workinground/raw/upload/v1556009979/billing/css/themes/all-themes.min_wci0cx.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/notification.css">
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div id="search-bar" class="search-bar ui search transparent inverted" >
        <div class="search-icon">
            <!-- <i class="material-icons">search</i> -->
        </div>
        <div class="close-search" style="top: 10px;">
            <i class="material-icons">close</i>
        </div>
        <input type="text" class="prompt" placeholder="Search item here...">
        <div class="results"></div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid" style="background: #0f0c29;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #24243e, #302b63, #0f0c29);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #24243e, #302b63, #0f0c29); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="#">BILLING DASHBOARD</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a id="shopping_cart_trigger" role="button">
                            <i class="material-icons">shopping_cart</i>
                            <span class="label-count" id="unsettle-bill"></span>
                        </a>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="#returnItemModal" class="dropdown-toggle" data-toggle="modal" role="button">
                            <i class="material-icons">delete_forever</i>
                            <!-- <span class="label-count">9</span> -->
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="/"  role="button">
                            <i class="material-icons">home</i>
                        </a>
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">contact_support</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="user/{{ Auth::user()->profile_pic }}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }}</div>
                    <div class="email">{{ Auth::user()->shop->shop_name }}</div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN CATEGORY</li>
                    <!-- start catogery -->
                    <li><a href='#' id="all_product"><span>ALL</span></a></li>
                    <section id="category">
                    </section>
                    <!-- end catogery -->  
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy;<a href="javascript:void(0);">workinground.com</a>.
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">Help Tips</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Press  together for Help Tips.
                          <span><kbd><kbd>shift</kbd> + <kbd>H</kbd></kbd></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Press to close Pop up modals.
                          <span><kbd><kbd>esc</kbd></kbd></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          To switch Bill Settle Window instant, Press  together
                          <span><kbd><kbd>shift</kbd> + <kbd>F</kbd></kbd></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          To switch Return Bill item Window instant, Press together
                          <span><kbd><kbd>shift</kbd> + <kbd>R</kbd></kbd></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          To switch Shopping Cart Window instant, Press together
                          <span><kbd><kbd>shift</kbd> + <kbd>C</kbd></kbd></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          For Get Search Bar instant, Press together
                          <span><kbd><kbd>shift</kbd> + <kbd>S</kbd></kbd></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          For Get Category Left Side Bar instant, Press together
                          <span><kbd><kbd>shift</kbd> + <kbd>TAB</kbd></kbd></span>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2 id="catogery_name">All PRODUCT</h2>
            </div>
            
              @include('billing/products')
              @include('billing/billing-item-form')
              @include('billing/shopping-cart')
              <input type="hidden" id="printer_type" value="{{ Auth::user()->print_type }}">
              
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012467/billing/plugins/jquery/jquery.min_afmcrv.js"></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>

    <!-- Bootstrap Core Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556010047/billing/plugins/bootstrap/js/bootstrap.min_qzjkqo.js"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556010171/billing/plugins/bootstrap-notify/bootstrap-notify.min_lulbvv.js"></script>

     <!-- JQuery Steps Plugin Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012493/billing/plugins/jquery-steps/jquery.steps.min_dtm4g5.js"></script>

    <!-- Select Plugin Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556010175/billing/plugins/bootstrap-select/js/bootstrap-select.min_ywq0zj.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012489/billing/plugins/jquery-slimscroll/jquery.slimscroll_ylhj2c.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012681/billing/plugins/node-waves/waves.min_aoomlp.js"></script>

    <!-- Custom Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556009979/billing/js/admin.min_kbplrp.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556009982/billing/js/pages/ui/notifications_k9mo51.js"></script>

    <!-- Demo Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556009979/billing/js/demo.min_zm6rhf.js"></script>

    <!-- Mousetrap Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mousetrap/1.6.2/mousetrap.min.js"></script>

    <!-- Script Js -->
    <!-- <script src="https://res.cloudinary.com/workinground/raw/upload/v1556017083/billing/js/script.min_qbshtv.js"></script> -->
    <script src="{{ asset('billing/js/script.js') }}"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556009984/billing/js/shortcut.min_ooeorf.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012494/billing/plugins/jquery-validation/jquery.validate_pkb12j.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556009981/billing/js/pages/forms/form-validation_n7xpln.js"></script>
    <script src="js/notification.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/search.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/api.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/components/dropdown.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012473/billing/plugins/jquery-datatable/jquery.dataTables_enm6m4.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012487/billing/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.min_ahana3.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012469/billing/plugins/jquery-datatable/extensions/export/dataTables.buttons.min_zasqz7.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012468/billing/plugins/jquery-datatable/extensions/export/buttons.flash.min_oijude.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012469/billing/plugins/jquery-datatable/extensions/export/jszip.min_ku1yke.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012477/billing/plugins/jquery-datatable/extensions/export/pdfmake.min_vbfklh.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012477/billing/plugins/jquery-datatable/extensions/export/vfs_fonts_o4k5yv.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012468/billing/plugins/jquery-datatable/extensions/export/buttons.html5.min_wsraei.js"></script>
    <script src="https://res.cloudinary.com/workinground/raw/upload/v1556012469/billing/plugins/jquery-datatable/extensions/export/buttons.print.min_kfo3en.js"></script>

    @if(Auth::user()->print_type == 'pos')
        <!-- <script src="{{ asset('printer/webprint.js') }}"></script>   -->
    @endif
</body>
</html>
