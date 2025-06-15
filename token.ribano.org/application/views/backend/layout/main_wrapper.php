<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
//get site_align setting
$settings = $this->db->select("*")
    ->get('setting')
    ->row();
$help_notify = $this->db->select('id')->from('dbt_messenger')->where('reciver_id','admin')->where('status',1)->get()->num_rows();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo  htmlspecialchars_decode($settings->title) ?> - <?php echo (!empty($title)?html_escape($title):null) ?></title>

        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&display=swap" rel="stylesheet">

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="<?php echo base_url(!empty($settings->favicon)?html_escape($settings->favicon):"assets/images/icons/favicon.png"); ?>">

        <!-- jquery ui css -->
        <link href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- Bootstrap --> 
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css"/>
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>

        <!-- Font Awesome 4.7.0 -->
        <link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- semantic css -->
        <link href="<?php echo base_url(); ?>assets/css/semantic.min.css" rel="stylesheet" type="text/css"/> 
        <!-- sliderAccess css -->
        <link href="<?php echo base_url(); ?>assets/css/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css"/> 
        <!-- slider  -->
        <link href="<?php echo base_url(); ?>assets/css/select2.min.css" rel="stylesheet" type="text/css"/> 
        <!-- DataTables CSS -->
        <link href="<?php echo  base_url('assets/datatables/css/dataTables.min.css') ?>" rel="stylesheet" type="text/css"/> 
  

        <!-- pe-icon-7-stroke -->
        <link href="<?php echo base_url('assets/css/pe-icon-7-stroke.css') ?>" rel="stylesheet" type="text/css"/> 
        <!-- themify icon css -->
        <link href="<?php echo base_url('assets/css/themify-icons.css') ?>" rel="stylesheet" type="text/css"/> 
        <!-- Pace css -->
        <link href="<?php echo base_url('assets/css/flash.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- Footable css -->
        <link href="<?php echo base_url('assets/css/footable.core.min.css') ?>" rel="stylesheet" type="text/css"/>

        <!-- Theme style -->
        <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url('assets/css/custom-new.css') ?>" rel="stylesheet" type="text/css"/>
        <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
            <!-- THEME RTL -->
            <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css"/>
        <?php } ?>


        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js') ?>" type="text/javascript"></script>

        <!-- Footable js -->
        <script src="<?php echo base_url('assets/js/footable.all.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.dd.min.js') ?>" type="text/javascript"></script>

        <script type="text/javascript">
            const base_url = '<?php echo html_escape(base_url()); ?>';
            var segment    = '<?php echo html_escape($this->uri->segment(2)); ?>';
            var language   = '<?php echo html_escape($settings->language); ?>';
        </script>

    </head>

    <body class="hold-transition sidebar-mini">
        <div class="se-pre-con"></div>

        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">  

                <a href="<?php echo base_url('backend/dashboard') ?>" class="logo"> <!-- Logo -->
                    <span class="logo-mini">
                        <img src="<?php echo base_url(!empty($settings->logo)?html_escape($settings->logo):"assets/images/icons/logo.png"); ?>" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="<?php echo base_url(!empty($settings->logo)?html_escape($settings->logo):"assets/images/icons/logo.png"); ?>" alt="">
                    </span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <!-- Sidebar toggle button-->
                        <span class="sr-only">Toggle navigation</span>
                        <span class="pe-7s-keypad"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li><a href="<?php echo base_url(); ?>" target="_blank"><i class="pe-7s-link" ></i></a></li>
                            <!-- settings -->
                            <li class="dropdown dropdown-user">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="pe-7s-settings"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo base_url('backend/dashboard/home/profile'); ?>"><i class="pe-7s-users"></i> <?php echo display('profile') ?></a></li>
                                    <li><a href="<?php echo base_url('backend/dashboard/home/edit_profile'); ?>"><i class="pe-7s-settings"></i> <?php echo display('edit_profile') ?></a></li>
                                    <li><a href="<?php echo base_url('logout') ?>"><i class="pe-7s-key"></i> <?php echo display('logout') ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- =============================================== -->
            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel text-center">
                        <?php $image = $this->session->userdata('image'); ?>
                        <div class="image">
                            <img src="<?php echo base_url(!empty($image)?html_escape($image):"assets/images/icons/user.png") ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="info">
                            <p><?php echo $this->session->userdata('fullname') ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i>
                            <?php echo display('admin'); ?></a>
                        </div>
                    </div> 

                    <!-- sidebar menu -->
                    <?php if($this->session->userdata('role_id')!=0){ ?>
                            <ul class="sidebar-menu">
                                <?php foreach ($backend_main_menu as $key => $main_menu) { ?>

                                    <?php if($main_menu->id==1){ 

                                            $permission = 0;

                                            foreach ($admin_role as $key => $access) {
                                                
                                                if($main_menu->id==$access->main_menu_id){

                                                    if($access->create_permission==1 || $access->read_permission==1 || $access->edit_permission==1 || $access->delete_permission==1){

                                                        $permission = 1;
                                                        break;
                                                    }
                                                }
                                            }
                                    ?>
                                            <?php if($permission==1){ ?>
                                                <li class="<?php echo (($this->uri->segment(3) == '' || $this->uri->segment(3) == 'home' ) ? "active" : null) ?>">
                                                    <a href="<?php echo base_url('backend/dashboard') ?>"><i class="fa fa ti-home"></i> <span><?php echo display('dashboard') ?></span></a>
                                                </li>
                                            <?php } ?>

                                    <?php }else if($main_menu->id==10){

                                            $permission = 0;

                                            foreach ($admin_role as $key => $access) {
                                                
                                                if($main_menu->id==$access->main_menu_id){

                                                    if($access->create_permission==1 || $access->read_permission==1 || $access->edit_permission==1 || $access->delete_permission==1){

                                                        $permission = 1;
                                                        break;
                                                    }
                                                }
                                            }

                                    ?>
                                            <?php if($permission==1){ ?>   
                                                <li class="<?php echo (($this->uri->segment(2) == "helpline") ? "active" : null) ?>">
                                                    <a href="<?php echo base_url("backend/helpline") ?>"><i class="fa fa-commenting"></i> <span>HelpLine</span><?php echo $help_notify>0?"<span class='helpline-notification'><i class='notify-text'>$help_notify</i></span>":""; ?></a>
                                                </li>
                                            <?php } ?>
    

                                    <?php }else if($main_menu->id==11){ 

                                                $permission = 0;
                                                foreach ($admin_role as $key => $access) {
                                                    
                                                    if($main_menu->id==$access->main_menu_id){

                                                        if($access->create_permission==1 || $access->read_permission==1 || $access->edit_permission==1 || $access->delete_permission==1){

                                                            $permission = 1;

                                                            break;
                                                        }
                                                        
                                                    }
                                                }

                                    ?>
                                            <?php if($permission==1){ ?>
                                                <li>
                                                    <a target="_blank" href="https://forum.bdtask.com/"><i class="fa fa-question-circle"></i><span>Support</span></a>
                                                </li>
                                            <?php } ?>

                                    <?php }else if(!empty($main_menu->link)){

                                        $permission = 0;
                                        foreach ($admin_role as $key => $access) {
                                            
                                            if($main_menu->id==$access->main_menu_id){

                                                if($access->create_permission==1 || $access->read_permission==1 || $access->edit_permission==1 || $access->delete_permission==1){

                                                    $permission = 1;

                                                    break;
                                                }
                                                
                                            }
                                        }

                                    ?>

                                        <?php if($permission==1){ ?>    
                                            <li>
                                                <a href="<?php echo base_url('backend/'.html_escape($main_menu->link)); ?>"><i class="fa <?php echo htmlspecialchars_decode($main_menu->icon); ?>"></i><span><?php echo html_escape($main_menu->menu_name); ?></span></a>
                                            </li>
                                        <?php } ?>

                                    <?php }else{

                                            if(strpos($main_menu->menu_name," ")){

                                                $mainsegment = strtolower(str_replace(" ","_",$main_menu->menu_name));
                                            }else{

                                                $mainsegment = strtolower($main_menu->menu_name);
                                            }

                                            $mainpermission = 0;

                                            foreach ($admin_role as $key => $access) {
                                                
                                                if($main_menu->id==$access->main_menu_id){

                                                    if($access->create_permission==1 || $access->read_permission==1 || $access->edit_permission==1 || $access->delete_permission==1){

                                                        $mainpermission = 1;

                                                         break;
                                                    }
                                                }
                                            }
                                     ?>

                                    <?php if($mainpermission==1){ ?>

                                        <li class="treeview <?php echo $this->uri->segment(2)==$mainsegment?'active':null; ?>">
                                            <a href="#">
                                                <i class="fa <?php echo htmlspecialchars_decode($main_menu->icon); ?>"></i> <span>&nbsp;<?php echo html_escape($main_menu->menu_name); ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a> 
                                            <ul class="treeview-menu">
                                        
                                    <?php foreach ($backend_sub_menu as $key => $sub_menu) { ?>

                                            <?php if($main_menu->id==$sub_menu->parent_id){ ?>
                                                    
                                                
                                                    <?php
                                                        if(strpos($sub_menu->link,'/')){
                                                            $linkexplod = explode('/', $sub_menu->link);
                                                            $segment = array_pop($linkexplod);
                                                        }
                                                        else{
                                                            $segment = $sub_menu->link;
                                                        }
                                                        if(strpos($sub_menu->menu_name," ")){

                                                            $segmentclass = strtolower(str_replace(" ","_",$sub_menu->menu_name));
                                                        }else{

                                                            $segmentclass = strtolower($sub_menu->menu_name);
                                                        }

                                                        $permission = 0;

                                                        foreach ($admin_role as $key => $access) {
                                                            
                                                            if($sub_menu->id==$access->sub_menu_id){

                                                                if($access->create_permission==1 || $access->read_permission==1 || $access->edit_permission==1 || $access->delete_permission==1){

                                                                    $permission = 1;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                <?php if($permission==1){ ?>

                                                    <?php
                                                            if(strpos($sub_menu->link,'/')){
                                                                $linkexplod = explode('/', $sub_menu->link);
                                                                $segment = array_pop($linkexplod);
                                                            }
                                                            else{
                                                                $segment = $sub_menu->link;
                                                            }
                                                            if(strpos($sub_menu->menu_name," ")){

                                                                $segmentclass = strtolower(str_replace(" ","_",$sub_menu->menu_name));
                                                            }else{

                                                                $segmentclass = strtolower($sub_menu->menu_name);
                                                            }
                                                            switch ($segmentclass) {
                                                                case 'shareholder_list':
                                                                    $segmentclass = "shareholder";
                                                                    break;
                                                                case 'verify_shareholder':
                                                                    $segmentclass = "pending_user_verification_list";
                                                                    break;
                                                                case 'subscriber':
                                                                    $segmentclass = "subscriber_list";
                                                                    break;
                                                                case 'financial_documents':
                                                                    $segmentclass = "financial";
                                                                    break;
                                                                case 'business_documents':
                                                                    $segmentclass = "business";
                                                                    break;
                                                                case 'legal_documents':
                                                                    $segmentclass = "legal";
                                                                    break;
                                                                case 'others':
                                                                    $segmentclass = "other";
                                                                    break;
                                                                case 'sto_releasing':
                                                                    $segmentclass = "sto_release";
                                                                    break;
                                                                case 'security_setting':
                                                                    $segmentclass = "security";
                                                                    break;
                                                                case 'email_and_sms_setting':
                                                                    $segmentclass = "email_sms_setting";
                                                                    break;
                                                                case 'email_and_sms_gateway':
                                                                    $segmentclass = "email_sms_gateway";
                                                                    break;
                                                                case 'language_setting':
                                                                    $segmentclass = "language";
                                                                    break;
                                                                case 'affiliation_setup':
                                                                    $segmentclass = "affiliation";
                                                                    break;
                                                                case 'history':
                                                                    $segmentclass = "exchange_history";
                                                                    break;
                                                                case 'running':
                                                                    $segmentclass = "exchange_running";
                                                                    break;
                                                                case 'canceled':
                                                                    $segmentclass = "exchange_canceled";
                                                                    break;                   
                                                                default:
                                                                    $segmentclass = $segmentclass;
                                                                    break;
                                                            }
                                                        ?>
                                                    <li class="<?php echo $this->uri->segment(3)==$segmentclass?'active':null; ?>"><a href="<?php echo base_url("backend/".htmlspecialchars_decode($sub_menu->link)) ?>"><?php echo !empty($sub_menu->icon)?"<i class='fa ".htmlspecialchars_decode($sub_menu->icon)."'></i>":null; ?> <?php echo htmlspecialchars_decode($sub_menu->menu_name); ?> </a></li>
                                                    

                                            <?php } } ?>

                                <?php } ?>

                                            </ul>
                                        </li>

                                <?php } } } ?>
                            </ul>
                    <?php }else{ ?>

                            <ul class="sidebar-menu">
                                <?php foreach ($backend_main_menu as $key => $main_menu) { ?>

                                    <?php if($main_menu->id==1){ ?>

                                                <li class="<?php echo (($this->uri->segment(3) == '' || $this->uri->segment(3) == 'home' ) ? "active" : null) ?>">
                                                    <a href="<?php echo base_url('backend/dashboard') ?>"><i class="fa fa ti-home"></i> <span><?php echo display('dashboard') ?></span></a>
                                                </li>

                                    <?php }else if($main_menu->id==10){ ?>

                                                <li class="<?php echo (($this->uri->segment(2) == "helpline") ? "active" : null) ?>">
                                                    <a href="<?php echo base_url("backend/helpline") ?>"><i class="fa fa-commenting"></i> <span>HelpLine</span><?php echo $help_notify>0?"<span class='helpline-notification'><i class='notify-text'>$help_notify</i></span>":""; ?></a>
                                                </li>

                                    <?php }else if($main_menu->id==11){ ?>

                                                <li>
                                                    <a target="_blank" href="https://forum.bdtask.com/"><i class="fa fa-question-circle"></i><span>Support</span></a>
                                                </li>

                                    <?php }else if(!empty($main_menu->link)){ ?>

                                            <li>
                                                <a href="<?php echo base_url('backend/'.html_escape($main_menu->link)); ?>"><i class="fa <?php echo htmlspecialchars_decode($main_menu->icon); ?>"></i><span><?php echo html_escape($main_menu->menu_name); ?></span></a>
                                            </li>

                                    <?php }else{

                                            if(strpos($main_menu->menu_name," ")){

                                                $mainsegment = strtolower(str_replace(" ","_",$main_menu->menu_name));
                                            }else{

                                                $mainsegment = strtolower($main_menu->menu_name);
                                            }
                                     ?>

                                        <li class="treeview <?php echo $this->uri->segment(2)==$mainsegment?'active':null; ?>">
                                            <a href="#">
                                                <i class="fa <?php echo htmlspecialchars_decode($main_menu->icon); ?>"></i> <span>&nbsp;<?php echo html_escape($main_menu->menu_name); ?></span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a> 
                                            <ul class="treeview-menu">
                                        
                                    <?php foreach ($backend_sub_menu as $key => $sub_menu) { ?>

                                            <?php if($main_menu->id==$sub_menu->parent_id){ ?>
                                                    
                                                
                                                        <?php
                                                            if(strpos($sub_menu->link,'/')){
                                                                $linkexplod = explode('/', $sub_menu->link);
                                                                $segment = array_pop($linkexplod);
                                                            }
                                                            else{
                                                                $segment = $sub_menu->link;
                                                            }
                                                            if(strpos($sub_menu->menu_name," ")){

                                                                $segmentclass = strtolower(str_replace(" ","_",$sub_menu->menu_name));
                                                            }else{

                                                                $segmentclass = strtolower($sub_menu->menu_name);
                                                            }
                                                            switch ($segmentclass) {
                                                                case 'shareholder_list':
                                                                    $segmentclass = "shareholder";
                                                                    break;
                                                                case 'verify_shareholder':
                                                                    $segmentclass = "pending_user_verification_list";
                                                                    break;
                                                                case 'subscriber':
                                                                    $segmentclass = "subscriber_list";
                                                                    break;
                                                                case 'financial_documents':
                                                                    $segmentclass = "financial";
                                                                    break;
                                                                case 'business_documents':
                                                                    $segmentclass = "business";
                                                                    break;
                                                                case 'legal_documents':
                                                                    $segmentclass = "legal";
                                                                    break;
                                                                case 'others':
                                                                    $segmentclass = "other";
                                                                    break;
                                                                case 'sto_releasing':
                                                                    $segmentclass = "sto_release";
                                                                    break;
                                                                case 'security_setting':
                                                                    $segmentclass = "security";
                                                                    break;
                                                                case 'email_and_sms_setting':
                                                                    $segmentclass = "email_sms_setting";
                                                                    break;
                                                                case 'email_and_sms_gateway':
                                                                    $segmentclass = "email_sms_gateway";
                                                                    break;
                                                                case 'language_setting':
                                                                    $segmentclass = "language";
                                                                    break;
                                                                case 'affiliation_setup':
                                                                    $segmentclass = "affiliation";
                                                                    break;
                                                                case 'history':
                                                                    $segmentclass = "exchange_history";
                                                                    break;
                                                                case 'running':
                                                                    $segmentclass = "exchange_running";
                                                                    break;
                                                                case 'canceled':
                                                                    $segmentclass = "exchange_canceled";
                                                                    break;
                                                                default:
                                                                    $segmentclass = $segmentclass;
                                                                    break;
                                                            }
                                                        ?>
                                                        <li class="<?php echo $this->uri->segment(3)==$segmentclass?'active':null; ?>"><a href="<?php echo base_url("backend/".html_escape($sub_menu->link)) ?>"><?php echo !empty($sub_menu->icon)?"<i class='fa ".html_escape($sub_menu->icon)."'></i>":null; ?> <?php echo html_escape($sub_menu->menu_name); ?> </a></li>
                                                    

                                            <?php } ?>

                                <?php } ?>

                                            </ul>
                                        </li>

                                <?php } } ?>
                            </ul>

                    <?php } ?>
                </div> <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">

                    <div class="p-l-30 p-r-30">
                        <div class="header-icon"><i class="pe-7s-world"></i></div>
                        <div class="header-title">
                            <h1><?php echo (($this->uri->segment(2)=="dashboard" || $this->uri->segment(3)=='home'|| $this->uri->segment(3)==null)?"Dashboard":str_replace('_', ' ', ucfirst($this->uri->segment(1)))) ?></h1>
                            <small><?php echo (!empty($title)?html_escape($title):null) ?></small> 
                        </div>
                    </div>
                </section>
                <!-- Main content -->
                <div class="content"> 

                    <!-- alert message -->
                    <?php if ($this->session->flashdata('message') != null) {  ?>
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('message'); ?>
                    </div> 
                    <?php } ?>
                    
                    <?php if ($this->session->flashdata('exception') != null) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo $this->session->flashdata('exception'); ?>
                    </div>
                    <?php } ?>
                    
                    <?php if (validation_errors()) {  ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php } ?>
                    

                    <!-- content -->
                    <?php echo (!empty($content)?htmlspecialchars_decode($content):null); ?>

                </div> <!-- /.content -->
            </div> <!-- /.content-wrapper -->

            <footer class="main-footer">
                <?php echo  htmlspecialchars_decode($settings->footer_text) ?>
            </footer>
        </div> <!-- ./wrapper -->

        <link href="<?php echo base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet" type="text/css"/>
 
        <!-- jquery-ui js -->
        <script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script> 
        <!-- bootstrap js -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <!-- bootstrap toggle -->
        <script src="<?php echo base_url('assets/js/bootstrap-toggle.min.js') ?>" type="text/javascript"></script>  
        <!-- pace js -->
        <script src="<?php echo base_url('assets/js/pace.min.js') ?>" type="text/javascript"></script>  
        <!-- SlimScroll -->
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js') ?>" type="text/javascript"></script>  

        <!-- bootstrap timepicker -->
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-sliderAccess.js" type="text/javascript"></script> 
        <script src="<?php echo base_url() ?>assets/js/jquery-ui-timepicker-addon.min.js" type="text/javascript"></script> 
        <!-- select2 js -->
        <script src="<?php echo base_url() ?>assets/js/select2.min.js" type="text/javascript"></script>

        <script src="<?php echo base_url('assets/js/sparkline.min.js') ?>" type="text/javascript"></script> 
        <!-- Counter js -->
        <script src="<?php echo base_url('assets/js/waypoints.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/js/jquery.counterup.min.js') ?>" type="text/javascript"></script>

        <!-- ChartJs JavaScript -->
        <script src="<?php echo base_url('assets/js/Chart.min.js') ?>" type="text/javascript"></script>
        
        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url("assets/datatables/js/dataTables.min.js") ?>"></script>

        <!-- Table Head Fixer -->
        <script src="<?php echo base_url() ?>assets/js/tableHeadFixer.js" type="text/javascript"></script> 

        <!-- Admin Script -->
        <script src="<?php echo base_url('assets/js/frame.js') ?>" type="text/javascript"></script> 

        <!-- Custom Theme JavaScript -->
        <script src="<?php echo base_url() ?>assets/js/custom.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/custom-new.js" type="text/javascript"></script>

    </body>
</html>