<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading d-flex justify-content-between align-items-center">
                <div class="panel-title">
                    <h3><?php echo display('deposit');?></h3>
                </div>
                <a class="btn btn-success w-md m-r-15 pull-right" href="<?php echo base_url("shareholder/deposit/show") ?>"><i class="fa fa-list" aria-hidden="true"></i> <?php echo display('deposit_list') ?></a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">

        
                        <div class="border_preview">
                            <?php echo form_open('shareholder/deposit', array('name'=>'deposit_form', 'id'=>'deposit_form'));?>

                                <div class="form-group row">
                                    <label for="p_name" class="col-sm-5 col-form-label"><?php echo display('deposit_amount');?>(<?php echo html_escape($coin_setup->pair_with); ?>)<i class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <input class="form-control" name="deposit_amount" type="text" id="deposit_amount" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="method" class="col-sm-5 col-form-label"><?php echo display('deposit_method');?><i class="text-danger">*</i></label>
                                    <div class="col-sm-7">
                                        <select class="form-control basic-single" name="method" id="method" required disabled>
                                            <option><?php echo display('deposit_method');?></option>
                                            <?php foreach ($payment_gateway as $key => $value) { ?>
                                            <option value="<?php echo html_escape($value->identity); ?>"><?php echo html_escape($value->agent); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="changed" class="col-sm-5 col-form-label"></label>
                                    <div class="col-sm-7">
                                        <span id="fee" class="text-success"></span>
                                    </div>
                                </div>

                                <span class="payment_info">
                                <div class="form-group row">
                                    <label for="comment" class="col-sm-5 col-form-label"><?php echo display('comments');?></label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control" name="comment" id="comment" rows="3"></textarea>
                                    </div>
                                </div>
                                </span>

                                <div class="row m-b-15">
                                    <div class="col-sm-7 col-sm-offset-5">
                                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('deposit');?></button>
                                        <a href="<?php echo base_url('shareholder/home');?>" class="btn btn-danger w-md m-b-5"><?php echo display('cancel')?></a>
                                    </div>
                                </div>

                                <input type="hidden" name="level" value="deposit">
                                <input type="hidden" name="fees" value="">

                                <?php echo form_close();?>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- /.row -->