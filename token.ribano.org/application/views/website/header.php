<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="shortcut icon" href="<?php echo base_url(html_escape($settings->favicon)); ?>">
        <link href="https://fonts.googleapis.com/css?family=Tajawal:200,300,400,500,700,800,900" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <link href="<?php echo base_url('assets/website/css/bootstrap.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/fontawesome/css/fontawesome-all.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/css/metisMenu.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/css/jquery.mCustomScrollbar.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/css/magnific-popup.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/slick/slick.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/slick/slick-theme.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/plugins/FlipClock/compiled/flipclock.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/css/style.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/css/style.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/website/css/style-new.css')?>" rel="stylesheet">
        <title><?php echo html_escape($settings->title) ?></title>
        <script type="text/javascript">
            const base_url = '<?php echo html_escape(base_url()); ?>';
            var segment    = '<?php echo html_escape($this->uri->segment(1)); ?>';
            var language   = '<?php echo strtolower(html_escape($languageinfo->language_name)); ?>';
        </script>
    </head>
    <body id="page-top" class="body-bg">
        <div id="loader-wrapper">
            <div id="loader"></div>
            <div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>
        </div>
        <!-- /.End of loader wrapper --> 
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
            <div class="container"> <a class="navbar-brand" href="<?php echo base_url(); ?>"><img class="logo" src="<?php echo !empty($settings->logo_web)?base_url(html_escape($settings->logo_web)):base_url('assets/website/img/logo.png'); ?>" alt="<?php echo html_escape($settings->title) ?>"></a>
                <div class="nav-toggle-btn d-flex d-lg-none">
                    <div class="lng_dropdown">
                        <?php echo form_open('#',array('id'=>'language_select2')); ?>
                        <select name="lang" class="lng_select2">
                            <?php if(!empty($web_language)){ 
                                    foreach ($web_language as $key => $lang) {
                            ?>
                                        <option value="<?php echo html_escape($lang->iso); ?>" data-image="<?php echo base_url("assets/images/flags/".strtolower(html_escape($lang->flag)).".png"); ?>" data-title="<?php echo html_escape($lang->language_name); ?>" <?php echo $languageId==$lang->id?"selected":""; ?>><?php echo strtoupper(html_escape($lang->iso));?></option>
                            <?php
                                    }   
                             } ?>
                        </select>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle user-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                        <?php if($this->session->userdata('user_id')!=NULL){?>
                            <a class="dropdown-item" href="<?php echo base_url('shareholder/home'); ?>"><?php echo display('dashboard'); ?></a> 
                            <a class="dropdown-item" href="<?php echo base_url('shareholder/auth/logout'); ?>"><?php echo display('logout'); ?></a>
                        <?php } else{ ?>
                            <?php if(!$this->session->userdata('isAdmin')){ ?>
                                <a class="dropdown-item" href="<?php echo base_url('login') ?>">Login or Register</a>
                            <?php }else{ ?>
                                <a class="dropdown-item" href="<?php echo base_url('backend/dashboard/home') ?>">Dashboard</a>
                        <?php } } ?>
                        </div>
                    </div>
                    <button type="button" class="navbar-toggler" id="sidebarCollapse">
                        <span class="navbar-toggler-icon"></span> 
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav mx-auto">

                        <?php foreach ($category as $key => $value) { ?>

                                <?php if($value->cat_id==5){ ?>
                                <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php echo html_escape($value->slug); ?> </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php  foreach ($subcategory as $key => $subcat) { ?>

                                            <a class="dropdown-item js-scroll-trigger" href="<?php echo base_url()?>#<?php echo html_escape($subcat->link); ?>"><?php echo html_escape($subcat->slug); ?></a>
                                    <?php } ?>
                                    </div>
                                </li>
                                <?php }else{ ?>

                                    <?php if(strtolower($value->slug)=="home"){ ?>
                                        <li class="nav-item"> <a class="nav-link js-scroll-trigger" href="<?php echo base_url()?>"><?php echo html_escape($value->slug); ?></a> </li>
                                    <?php }else{ ?>
                                        <li class="nav-item"> <a class="nav-link js-scroll-trigger" href="<?php echo base_url()?>#<?php echo html_escape($value->link); ?>"><?php echo html_escape($value->slug); ?></a> </li>
                                    <?php } ?>
                        <?php } } ?>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <div class="lng_dropdown">
                                <?php echo form_open('#',array('id'=>'language_select')); ?>
                                <select name="lang" class="lng_select">

                                    <?php if(!empty($web_language)){ 

                                            foreach ($web_language as $key => $lang) {
                                    ?>
                                                <option value="<?php echo html_escape($lang->iso); ?>" data-image="<?php echo base_url("assets/images/flags/".strtolower(html_escape($lang->flag)).".png"); ?>" data-title="<?php echo html_escape($lang->language_name); ?>" <?php echo $languageId==$lang->id?"selected":""; ?>><?php echo strtoupper(html_escape($lang->iso));?></option>
                                    <?php
                                            }   
                                     } ?>
                                </select>
                                <?php echo form_close(); ?>
                            </div>
                        </li>
                        
                        <?php if($this->session->userdata('user_id')!=NULL){?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?php echo display('account'); ?></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                                <a class="dropdown-item" href="<?php echo base_url('shareholder/home'); ?>"><?php echo display('dashboard'); ?></a> 
                                <a class="dropdown-item" href="<?php echo base_url('shareholder/auth/logout'); ?>"><?php echo display('logout'); ?></a>
                            </div>
                        </li>
                        <?php } else{ ?>
                            <?php if(!$this->session->userdata('isAdmin')){ ?>
                            <li class="nav-item"> <a href="<?php echo base_url('login') ?>" class="btn btn-round btn-link">Login or Register</a></li>
                            <?php }else{ ?>
                            <li class="nav-item"> <a href="<?php echo base_url('backend/dashboard/home') ?>" class="btn btn-round btn-link">Dashboard</a></li>
                        <?php } } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /.End of navbar -->
        <nav id="sidebar">
            <div id="dismiss"> <i class="fas fa-times"></i> </div>
            <ul class="metismenu list-unstyled" id="mobile-menu">
                <?php foreach ($category as $key => $value) { ?>

                            <?php if($value->cat_id==5){ ?>
                            <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Packages </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php  foreach ($subcategory as $key => $subcat) { ?>

                                        <a class="dropdown-item js-scroll-trigger" href="<?php echo base_url()?>#<?php echo html_escape($subcat->link); ?>"><?php echo html_escape($subcat->slug); ?></a>
                                <?php } ?>
                                </div>
                            </li>
                            <?php }else{ ?>

                                <li class="nav-item"> <a class="nav-link js-scroll-trigger" href="<?php echo base_url()?>#<?php echo html_escape($value->link); ?>"><?php echo html_escape($value->slug); ?></a> </li>
                <?php } } ?>
            </ul>
        </nav>
        <div class="overlay" id="overlay"></div>