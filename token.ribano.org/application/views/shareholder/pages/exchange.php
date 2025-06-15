<div class="row">
    <div class="col-sm-6 col-md-4">
        <div class="count_panel panel-one">
            <div class="stats-title">
                <h4><?php echo display('sell_available'); ?></h4>
                <i class="fa fa-university"></i>
            </div>
            <h1 class="sell_avaiable"><?php echo html_escape($stoinfo->symbol); ?> 0.00</h1>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_available_sell_in_system'); ?>."></i>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="count_panel panel-two">
            <div class="stats-title ">
                <h4><?php echo display('price'); ?></h4>
                <i class="fa fa-universal-access"></i>
            </div>
            <h1 class="present_price"><span class="price_updown "><?php echo html_escape($stoinfo->pair_with); ?> 0.00</span></h1>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('presents_exchange_crypto_rate'); ?>"></i>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="count_panel panel-three">
            <div class="stats-title ">
                <h4><?php echo display('crypto_balance'); ?></h4>
                <i class="fa fa-balance-scale"></i>
            </div>
            <h1 class="crypto_balance"><?php echo html_escape($stoinfo->symbol); ?> 0.00</h1>
            <i class="fa fa-info-circle" data-toggle="tooltip" data-original-title="<?php echo display('total_your_crypto_balance'); ?>"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('exchange_history'); ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div id="exchangesChart" class="height-450"></div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('buy_coin'); ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open('#',array('name'=>'exchange_buy','id'=>'exchange_buy')); ?>
                <?php echo form_hidden('exchange', 'BUY') ?>

                <div class="form-group row">
                    <label for="changed" class="col-sm-1 col-form-label"></label>
                    <div class="col-sm-11">
                        <center><span id="exceptionorbuy" class="text-success"></span></center>
                    </div>
                </div>
                <div id="buy_coin_mainloader">
                    <div id="buy_coin_subloader">
                        <div class="form-group row">
                            <label for="buyqty" class="col-sm-4 col-form-label"><?php echo display('quantity'); ?><i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="qty" type="text" id="buyqty" value="1" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="buyrate" class="col-sm-4 col-form-label"><?php echo display('rate'); ?> (<?php echo html_escape($stoinfo->pair_with); ?>)<i class="text-danger">*</i></label>
                            <div class="col-sm-8">
                                <input class="form-control" name="rate" type="text" id="buyrate" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="changed" class="col-sm-4 col-form-label"><?php echo display('fees'); ?></label>
                            <div class="col-sm-8">
                                <?php echo html_escape($stoinfo->pair_with); ?> <span id="buyfee" class="text-success">0.0</span> (<?php echo @$buyfees->fees?html_escape(@$buyfees->fees):0; ?>%)
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="buytotal" class="col-sm-4 col-form-label"><?php echo display('total'); ?></label>
                            <div class="col-sm-8">
                                <span id="buytotal">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row m-b-15">
                    <div class="col-sm-8 col-sm-offset-4">
                        <button type="button" class="btn btn-success w-md m-b-5 col-sm-12" id="exchang_buy_app"><?php echo display('buy')?></button>
                    </div>
                </div>
                        <input type="hidden" name="level" value="buy">

                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('sell_coin'); ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open('#',array('name'=>'exchange_sell','id'=>'exchange_sell')); ?>
                <?php echo form_hidden('exchange', 'SELL') ?>

                <div class="form-group row">
                    <label for="changed" class="col-sm-1 col-form-label"></label>
                    <div class="col-sm-11">
                        <center><span id="exceptionorsell" class="text-success"></span></center>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sellqty" class="col-sm-4 col-form-label"><?php echo display('quantity'); ?><i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                        <input class="form-control" name="qty" type="text" id="sellqty" value="1" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sellrate" class="col-sm-4 col-form-label"><?php echo display('rate'); ?> (<?php echo html_escape($stoinfo->pair_with); ?>)<i class="text-danger">*</i></label>
                    <div class="col-sm-8">
                        <input class="form-control" name="rate" type="text" id="sellrate" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="changed" class="col-sm-4 col-form-label">Fees</label>
                    <div class="col-sm-8">
                        <?php echo html_escape($stoinfo->pair_with); ?> <span id="sellfee" class="text-success">0.0</span> (<?php echo @$sellfees->fees?html_escape(@$sellfees->fees):0; ?>%)
                    </div>
                </div>
                <div class="form-group row">
                    <label for="selltotal" class="col-sm-4 col-form-label"><?php echo display('total'); ?></label>
                    <div class="col-sm-8">
                        <span id="selltotal">0.00</span>
                    </div>
                </div>

                <div class="row m-b-15">
                    <div class="col-sm-8 col-sm-offset-4">
                        <button type="button" class="btn btn-danger w-md m-b-5 col-sm-12" id="exchang_sell_app"><?php echo display('sell')?></button>
                    </div>
                </div>
                <input type="hidden" name="level" value="sell">
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('market_depth'); ?></h2>
                </div>
            </div>
            <div class="panel-body">
               <div id="marketDepth" class="height-450"></div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
    <!-- Chart -->
    <link href="<?php echo base_url('assets/amcharts/export.css'); ?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/amcharts/amcharts.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/amcharts/serial.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/amcharts/amstock.js'); ?>" type="text/javascript"></script>

    <!-- Amchats js -->
    <script src="<?php echo base_url('assets/amcharts/plugins/dataloader/dataloader.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/amcharts/plugins/export/export.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/amcharts/patterns.js') ?>"></script>
    <script src="<?php echo base_url('assets/amcharts/dark.js') ?>"></script>
