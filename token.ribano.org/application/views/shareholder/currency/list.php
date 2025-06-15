<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-bordered table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('symbol') ?></th>
                            <th class="text-right">USD</th>
                            <th class="text-right"><?php echo html_escape($localcurrency->currency_name); ?></th>
                            <th class="text-right">BTC</th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($currency)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($currency as $value) { ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td> 
                            <td><?php echo html_escape($value->name); ?></td>
                            <td><?php echo html_escape($value->symbol); ?></td>
                            <td class="text-right">$<?php echo html_escape($value->price_usd); ?></td>
                            <td class="text-right">
                                <?php echo ($localcurrency->currency_position=='l')?$localcurrency->currency_symbol:html_escape($localcurrency->currency_symbol); ?>
                                <?php echo html_escape($value->price_usd)*html_escape($localcurrency->usd_exchange_rate); ?>
                            </td>
                            <td class="text-right"><?php echo html_escape($value->price_btc); ?></td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($links); ?>
            </div> 
        </div>
    </div>
</div>

 