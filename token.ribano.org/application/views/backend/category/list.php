<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                    <div class="col-sm-3 col-md-3 pull-right">
                        <a class="btn btn-success w-md m-b-5 pull-right" href="<?php echo base_url("backend/cms/category/form") ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo display('add_cat') ?></a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-bordered table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('cat_name_en') ?></th>
                            <th><?php echo display('parent_name'); ?></th>
                            <th><?php echo display('action') ?></th> 
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty(@$category)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($category as $value) { ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td> 
                            <td><?php echo html_escape($value->slug); ?></td>
                            <td><?php echo html_escape($value->parent_name); ?></td>
                            <td>
                                <a href="<?php echo base_url("backend/cms/category/form/$value->cat_id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php if($blog_info->cat_id==$value->parent_id){ ?>
                                    <a href="<?php echo base_url("backend/cms/category/delete/$value->cat_id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($links); ?>
            </div> 
        </div>
    </div>
</div>

 