<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-bd ">
            <div class="panel-heading d-flex justify-content-between align-items-center">
                <div class="panel-title">
                    <h4 class="font-size-19"><?php echo display('transfer');?></h4>
                </div>
                <a class="btn btn-success w-md m-r-15 pull-right" href="<?php echo base_url("shareholder/transfer/transfer_list") ?>"><i class="fa fa-list" aria-hidden="true"></i><?php echo display('transfer_list'); ?></a>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <?php echo form_open('shareholder/transfer/store',array('name'=>'transfer_form', 'id'=>'transfer_form'));?>
                        <div class="border_preview">
                            <div class="form-group row">
                                <label for="receiver_id" class="col-sm-4 col-form-label"><?php echo display('reciver_account')?><i class="text-danger">*</i></label>
                                <div class="col-sm-7">
                                    <input class="form-control" name="receiver_id" type="text" required id="receiver_id" placeholder="<?php echo display('user_id')?>">
                                </div>

                                <div class="col-sm-1">
                                    <img src="<?php echo base_url()?>assets/images/Group.svg" class="suc">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="transfer_amount" class="col-sm-4 col-form-label"><?php echo display('amount')?>(<?php echo html_escape($coininfo->pair_with);?>)<i class="text-danger">*</i></label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="amount" type="text" required id="transfer_amount">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="changed" class="col-sm-4 col-form-label"></label>
                                <div class="col-sm-8">
                                    <span id="fee" class="text-success"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="comments" class="col-sm-4 col-form-label"><?php echo display('comment')?></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="comments" id="comments" rows="3"></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><?php echo display('otp_send_to')?></label>
                                <div class="col-sm-8">
                                    <div class="radio radio-info radio-inline">
                                        <input type="radio" id="inlineRadio1" value="1" name="varify_media" checked="">
                                        <label for="inlineRadio1"> <?php echo display('sms')?> </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="inlineRadio2" value="2" name="varify_media">
                                        <label for="inlineRadio2"> <?php echo display('email')?> </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-15">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('transfer')?></button>
                                    <a href="<?php echo base_url('shareholder/home');?>" class="btn btn-danger w-md m-b-5"><?php echo display('cancel')?></a>
                                </div>
                            </div>
                        </div>
                                <input type="hidden" name="level" value="transfer">

                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>