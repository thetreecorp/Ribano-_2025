<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php if(!empty($documents)){?>
                    <div class="border_preview">
                        <div class="row">
                            
                            <?php foreach($documents as $key => $doc){?>
                            
                                <div class='form-group col-xs-12 col-sm-12 col-md-6'>
                                    <label for='title' class='col-form-label l-h-30'> <a href="<?php echo base_url(html_escape($doc->upload_file)); ?>" target="_blank" class="wraplink"><?php echo html_escape($doc->title); ?>(<?php echo html_escape($doc->year); ?>)</a> </label>
                                        <iframe width="100%" height="400" src="<?php echo base_url(html_escape($doc->upload_file)); ?>"></iframe>
                                </div>
                            
                            <?php } ?>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <center><h3 class="text-danger">No Data Available</h3></center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>