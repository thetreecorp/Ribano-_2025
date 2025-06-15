<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="form-group col-lg-12">
                    	<div class="panel-body">
			                <table class="datatable2 table table-bordered table-hover">
			                    <thead>
			                        <tr> 
			                            <th><?php echo display('sl_no') ?></th>
			                            <th><?php echo display('reserve_key'); ?></th>
			                            <th><?php echo display('details'); ?></th>
			                        </tr>
			                    </thead>    
			                    <tbody>
			                        <?php if (!empty($reservekey)) ?>
			                        <?php $sl = 1; ?>
			                        <?php foreach ($reservekey as $value) { ?>
			                        <tr>
			                            <td><?php echo html_escape($sl++); ?></td> 
			                            <td><?php echo "{".html_escape($value['reserve_key'])."}"; ?></td>
			                            <td><?php echo html_escape($value['key_details']); ?></td>
			                        </tr>
			                        <?php } ?>  
			                    </tbody>
			                </table>
			                
			            </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>