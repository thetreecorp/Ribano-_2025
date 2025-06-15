<div class="row">
    <div class="col-sm-12">
        <div class="mailbox">
            <div class="mailbox-header">
                <div class="row">
                    <div class="col-xs-4">
                        <?php $image = $this->session->userdata('image'); ?>
                        
                        <div class="inbox-avatar"><img src="<?php echo base_url(!empty($image)?html_escape($image):"assets/images/icons/user.png") ?>" class="img-circle border-green" alt="">
                            <div class="inbox-avatar-text hidden-xs hidden-sm">
                                <div class="avatar-name"><?php echo display('admin'); ?></div>
                                <div><small><?php echo display('help_line'); ?></small></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="mailbox-body">
                <div class="row m-0">
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 p-0 inbox-mail">
                        <div class="mailbox-content">
                            <?php foreach($message as $val){?>
                                <?php $read_unread = $val->status==1?"new-message":"";?>
                                <?php if(!empty(@$val->user_id)){ ?>
                                        <a href="<?php echo base_url("backend/helpline/subject/$val->id")?>" class="inbox_item unread">
                                            <div class="inbox-avatar"><img src="<?php echo base_url(!empty($val->user_img)?html_escape($val->user_img):"assets/images/icons/user.png") ?>" class="border-green hidden-xs hidden-sm" alt="">
                                                <div class="inbox-avatar-text">
                                                    <div class="avatar-name <?php echo html_escape($read_unread);?>"><?php echo html_escape($val->subject);?></div>
                                                    <div><small><?php echo html_escape($val->first_name)." ".html_escape($val->last_name);?></small></div>
                                                </div>
                                                <div class="inbox-date hidden-sm hidden-xs hidden-md">
                                                    <div class="date <?php echo html_escape($read_unread);?>"><?php echo html_escape($val->date_time);?></div>
                                                </div>
                                            </div>
                                        </a>
                                <?php }else{

                                            $data = json_decode($val->messege,true);

                                            if(!empty($data)){
                                                $name    = $data['name'];
                                                $comment = $data['comment'];
                                            }

                                ?>

                                        <a href="<?php echo base_url("backend/helpline/subject/$val->id")?>" class="inbox_item unread">
                                            <div class="inbox-avatar"><img src="<?php echo base_url("assets/images/icons/viewer.png"); ?>" class="border-green hidden-xs hidden-sm" alt="">
                                                <div class="inbox-avatar-text">
                                                    <div class="avatar-name <?php echo html_escape($read_unread);?>"><?php echo html_escape($val->subject);?></div>
                                                    <div><small><?php echo html_escape($name); ?></small></div>
                                                </div>
                                                <div class="inbox-date hidden-sm hidden-xs hidden-md">
                                                    <div class="date <?php echo html_escape($read_unread);?>"><?php echo html_escape($val->date_time);?></div>
                                                </div>
                                            </div>
                                        </a>  
                                <?php }?>
                            <?php }?>
                            <?php echo html_escape($links); ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>