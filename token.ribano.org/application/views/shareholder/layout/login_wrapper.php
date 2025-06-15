<?php
defined('BASEPATH') or exit('No direct script access allowed');
//get site_align setting
$settings = $this->db->select("title,site_align,logo,favicon")
    ->get('setting')
    ->row();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo  display('login') ?> -
        <?php echo (!empty($settings->title) ? htmlspecialchars_decode($settings->title) : null) ?></title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon"
        href="<?php echo (!empty($settings->favicon) ? html_escape($settings->favicon) : null) ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <?php if (!empty($settings->site_align) && $settings->site_align == "RTL") {  ?>
    <!-- THEME RTL -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/custom-rtl.css') ?>" rel="stylesheet" type="text/css" />
    <?php } ?>

    <!-- 7 stroke css -->
    <link href="<?php echo base_url(); ?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" type="text/css" />

    <!-- style css -->
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/custom-new.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <!-- Content Wrapper -->
    <div class="login-wrapper">
        <div class="container-center">
            <div class="panel panel-bd">
                <div class="panel-heading">
                    <div class="view-header">
                        <div class="header-icon">
                            <i class="pe-7s-unlock"></i>
                        </div>
                        <div class="header-title">
                            <h3 class="display-table-cell"><?php echo  display('please_login') ?></h3>
                            <small><strong><?php echo (!empty($settings->title) ? html_escape($settings->title) : null) ?></strong></small>
                        </div>
                    </div>
                    <div class="row">
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
                    </div>
                </div>


                <div class="panel-body">
                    <?php echo form_open('shareholder', 'id="loginForm" novalidate'); ?>
                    <div class="form-group">
                        <label class="control-label" for="email"><?php echo  display('email') ?></label>
                        <input type="text" placeholder="<?php echo  display('email') ?>" name="email" id="email"
                            class="form-control"
                            value="<?php echo (!empty($user->email) ? html_escape($user->email) : null) ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password"><?php echo  display('password') ?></label>
                        <input type="password" placeholder="<?php echo  display('password') ?>" name="password"
                            id="password" class="form-control"
                            value="<?php echo (!empty($user->email) ? html_escape($user->password) : null) ?>">
                    </div>

                    <?php
                    $security = $this->db->select('*')->from('dbt_security')->where('keyword', 'capture')->where('status', 1)->get()->row();
                    if ($security) {
                    ?>
                    <div class="form-group">
                        <?php echo htmlspecialchars_decode($widget); ?>
                        <?php echo htmlspecialchars_decode($script); ?>
                    </div>
                    <?php } else { ?>

                    <div class="form-group">
                        <label class="control-label"
                            for="captcha"><?php echo htmlspecialchars_decode($captcha_image) ?></label>

                        <input type="captcha" placeholder="<?php echo display('captcha') ?>" name="captcha" id="captcha"
                            class="form-control">
                    </div>

                    <?php } ?>

                    <div>
                        <button type="submit" class="btn btn-success"><?php echo  display('login') ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>

            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/js/jquery-3.5.1.min.js') ?>" type="text/javascript"></script>
    <!-- bootstrap js -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/custom-login-wrapper.js') ?>" type="text/javascript"></script>
</body>

</html>