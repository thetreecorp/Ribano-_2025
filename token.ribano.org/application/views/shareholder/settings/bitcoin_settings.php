<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-bd lobidrag">

            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('payment_method_setting');?></h4>
                </div>
            </div>

                        <div class="panel-body">
                <div class="row">
                    
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open('shareholder/settings/payment_method_update/bitcoin');?>

                                <div class="form-group row">
                                    <label  class="col-sm-12 col-form-label"><?php echo display('bitcoin_wallet_id');?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="wallet_id" value="<?php echo html_escape(@$bitcoin->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open('shareholder/settings/payment_method_update/payeer');?>

                                <div class="form-group row">
                                    <label  class="col-sm-12 col-form-label"><?php echo display('payeer_wallet_id');?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="wallet_id" value="<?php echo html_escape(@$payeer->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open('shareholder/settings/payment_method_update/paypal');?>

                                <div class="form-group row">
                                    <label  class="col-sm-12 col-form-label">Paypal <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="wallet_id" value="<?php echo html_escape(@$paypal->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open('shareholder/settings/payment_method_update/stripe');?>

                                <div class="form-group row">
                                    <label  class="col-sm-12 col-form-label">Stripe <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="wallet_id" value="<?php echo html_escape(@$stripe->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open('shareholder/settings/payment_method_update/phone');?>

                                <div class="form-group row">
                                    <label  class="col-sm-12 col-form-label"><?php echo display('mobile');?> <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="wallet_id" value="<?php echo html_escape(@$phone->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="border_preview">
                            <?php echo form_open('shareholder/settings/payment_method_update/ccavenue');?>

                                <div class="form-group row">
                                    <label  class="col-sm-12 col-form-label">CCAvenue <span class="text-danger">*</span></label>
                                    <div class="col-sm-12">
                                        <input class="form-control" name="wallet_id" value="<?php echo html_escape(@$ccavenue->wallet_id); ?>" required type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-8">
                                       <button type="submit" class="btn btn-success"><?php echo display("update") ?></button>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> <!-- /.row -->