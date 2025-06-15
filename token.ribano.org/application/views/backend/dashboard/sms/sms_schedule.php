<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="portlet-body form">
                    <?php 
                        $attributes = array('class' => 'form-horizontal','method'=>'post','role'=>'form');
                        echo form_open_multipart('backend/sms/sms/save_schedule', html_escape($attributes));  
                    ?>
                        
                    <div class="form-body">

                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo display('schedule_name');?> : </label>
                                <div class="col-md-5">
                                    <input type="text" name="schedule_name" required="1" class="form-control" placeholder="<?php echo display('schedule_name');?>"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo display('template_name');?> : </label>
                                <div class="col-md-5">
                                   <select class="form-control" name="template_id" required="1" >
                                        <option value="">--Select--</option>
                                        <?php foreach($template as $value1){?>
                                        <option value="<?php echo html_escape($value1->teamplate_id) ?>"><?php echo html_escape($value1->teamplate_name);?></option>
                                        <?php }?>
                                    </select>
                               </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"> <?php echo display('time');?> : </label>
                                <div class="col-md-5">
                                    <input type="text" autocomplete="off" class="form-control" id="schedule_date" name="shedule_time" required>
                                </div>
                            </div>
                    </div>

                    <div class="form-group row">
                            <div class="col-sm-offset-3 col-sm-6">
                                 <button type="reset" class="btn btn-danger"><?php echo display('reset')?></button>
                                <button type="submit" class="btn btn-success"><?php echo display('submit')?></button>
                            </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="email_sender_cronjob_view">
            <p>curl --request GET <?php echo base_url('backend/sms/Sms_sender');?> 
            <br> You can use above link for cron job. Copy and paste at cron job Command box.</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('sms_schedule_setup_list'); ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr class="center">
                            <th class="all"><?php echo display('schedule_name');?></th>
                            <th class="all"><?php echo display('template_name');?></th>
                            <th class="all"><?php echo display('customer_type'); ?></th>
                            <th class="all"><?php echo display('time');?> </th>
                            <th class="all"><?php echo display('action');?> </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($schedule_list as $value){?>
                        <tr>
                            <td><?php echo html_escape($value->ss_name);?></td>
                            <td><?php echo html_escape($value->teamplate_name);?></td>
                            <td>All</td>
                            <td><?php echo html_escape($value->hit_time);?></td>
                            <td class="text-right">
                                <a href="<?php echo base_url('backend/sms/sms/delete_schedule/');?><?php echo html_escape($value->ss_id) ;?>" onclick="return confirm('Are you want to delelte?');" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i> </a>
                            </td>
                        </tr>
                        <?php }?>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>