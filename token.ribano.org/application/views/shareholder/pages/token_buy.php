<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading d-flex justify-content-between align-items-center">
                <div class="panel-title">
                    <h3><?php echo display('sto_buy'); ?></h3>
                </div>
                <a class="btn btn-success w-md m-r-15 pull-right" href="<?php echo base_url("shareholder/token/token_list") ?>"><i class="fa fa-list" aria-hidden="true"></i> <?php echo display('sto_list'); ?></a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">

        
                        <div class="border_preview">
                            <?php echo form_open('shareholder/token/token_buy', array('name'=>'token_buy'));?>
                            <div class="form-group row">
                                <label for="sto_qty" class="col-sm-4 col-form-label"><?php echo display('buy_qty'); ?><i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="sto_qty" type="text" id="sto_qty" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rate" class="col-sm-4 col-form-label"><?php echo display('rate'); ?></label>
                                <div class="col-sm-8">
                                    <span id="rate"><?php echo @$stoprice->rate==''?(html_escape(@$stoinfo->pair_with).' 0.00'):html_escape(@$stoinfo->pair_with).'&nbsp;'.html_escape(@$stoprice->rate) ?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="total" class="col-sm-4 col-form-label"><?php echo display('total'); ?></label>
                                <div class="col-sm-8" id="total">
                                    <span id="total"><?php echo html_escape(@$stoinfo->pair_with);?> 0.00</span>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('buy_sto'); ?></button>
                                    <a href="<?php echo base_url('shareholder/home');?>" class="btn btn-danger w-md m-b-5"><?php echo display('cancel')?></a>
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