<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">                
                <?php if (!empty($transaction)) { ?>
                <?php $data = json_decode($transaction->data);  ?>
                <?php if (!empty($data)) { ?>

                <?php foreach ($data as $key => $value) { ?> 
                    <h3 class="text-center"><?php echo display('address'); ?>:- &nbsp; &nbsp; <?php echo html_escape($key); ?></h3>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('transaction_id'); ?></th>
                            <th><?php echo display('source_address'); ?></th>
                            <th><?php echo display('quantity'); ?></th>
                            <th><?php echo display('rate'); ?></th>
                            <th><?php echo display('price_in'); ?></th>
                            <th><?php echo display('total') ?></th>
                            <th><?php echo display('balance'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sl = 1;
                            $total_balance = 0;
                            
                            foreach ($value as $keys => $values) { 
                                if (!empty($values)) {
                        ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td>                            
                            <td><?php echo html_escape($values->id); ?></td>
                            <td><?php echo html_escape(@$values->source_wallet); ?></td>
                            <td><?php echo html_escape(@$values->crypto_qty); ?></td>
                            <td><?php echo html_escape(@$values->crypto_rate); ?></td>
                            <td><?php echo html_escape(@$values->exchange_currency); ?></td>
                            <td><?php echo html_escape(@$values->total); ?></td>
                            <td><?php echo html_escape(@$values->crypto_balance); ?></td>
                        </tr>
                        <?php $total_balance =  @$values->crypto_balance; ?>                        
                        <?php } } ?>
                        <tr>
                            <td colspan="7" class="text-right"><b>Total <?php echo html_escape($stoinfo->symbol); ?></b></td>
                            <td><b><?php echo html_escape($total_balance); ?></b></td>
                        </tr>                     
                    </tbody>
                </table>
                <?php  } } } ?>

            </div> 
        </div>
    </div>
</div>

 