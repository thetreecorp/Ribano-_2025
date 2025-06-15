<?php $deposit_fees = (float)@$deposit->fees_amount ? number_format((float)@$deposit->fees_amount, 2, '.', '') : number_format(0, 2, '.', ''); ?>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display("deposit"); ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="border_preview">

                        <?php if ($deposit->method == 'bitcoin') { ?>



                        <!-- JS -->

                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
                            crossorigin="anonymous"></script>
                        <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js"
                            crossorigin="anonymous"></script>
                        <script src="<?php //echo CRYPTOBOX_JS_FILES_PATH; 
                                            ?><?php echo base_url("gourl/js/support.min.js"); ?>"
                            crossorigin="anonymous"></script>

                        <?php

                            // Display payment box  
                            echo $deposit_data['box']->display_cryptobox_bootstrap(html_escape($deposit_data['coins']), html_escape($deposit_data['def_coin']), html_escape($deposit_data['def_language']), html_escape($deposit_data['custom_text']), html_escape($deposit_data['coinImageSize']), html_escape($deposit_data['qrcodeSize']), html_escape($deposit_data['show_languages']), html_escape($deposit_data['logoimg_path']), html_escape($deposit_data['resultimg_path']), html_escape($deposit_data['resultimgSize']), html_escape($deposit_data['redirect']), html_escape($deposit_data['method']), html_escape($deposit_data['debug']));


                            ?>




                        <?php } elseif ($deposit->method == 'ccavenue') { ?>

                        <iframe src="<?php echo html_escape($deposit_data); ?>" id="paymentFrame" width="500"
                            height="450" frameborder="0" scrolling="No"></iframe>

                        <?php } elseif ($deposit->method == 'payeer') { ?>
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo display("user_id") ?></th>
                                <td class="text-right"><?php echo html_escape($deposit->user_id) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("payment_gateway") ?></th>
                                <td class="text-right"><?php echo html_escape($deposit->method) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("amount") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit->amount) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("fees") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit_fees) ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">
                                    <?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape((float)@$deposit->amount) + html_escape($deposit_fees) ?>
                                </td>
                            </tr>
                        </table>
                        <form method="post" action="https://payeer.com/merchant/">
                            <input type="hidden" name="m_shop"
                                value="<?php echo html_escape($deposit_data['m_shop']) ?>">
                            <input type="hidden" name="m_orderid"
                                value="<?php echo html_escape($deposit_data['m_orderid']) ?>">
                            <input type="hidden" name="m_amount"
                                value="<?php echo html_escape($deposit_data['m_amount']) ?>">
                            <input type="hidden" name="m_curr"
                                value="<?php echo html_escape($deposit_data['m_curr']) ?>">
                            <input type="hidden" name="m_desc"
                                value="<?php echo html_escape($deposit_data['m_desc']) ?>">
                            <input type="hidden" name="m_sign" value="<?php echo html_escape($deposit_data['sign']) ?>">

                            <input type="submit" name="m_process" value="Payment Process"
                                class="btn btn-success w-md m-b-5" />

                            <a href="<?php echo base_url('shareholder/deposit'); ?>"
                                class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>

                            <br>
                            <br>
                            <br>
                        </form>

                        <?php } elseif ($deposit->method == 'paypal') { ?>

                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo display("user_id") ?></th>
                                <td class="text-right"><?php echo html_escape($deposit->user_id) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("payment_gateway") ?></th>
                                <td class="text-right"><?php echo html_escape($deposit->method) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("amount") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit->amount) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("fees") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit_fees) ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">
                                    <?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape((float)$deposit->amount) + html_escape($deposit_fees) ?></td>
                            </tr>
                        </table>

                        <a class="btn btn-success w-md m-b-5 text-right"
                            href="<?php echo html_escape($deposit_data['approval_url']) ?>">Payment Process</a>
                        <?php } elseif ($deposit->method == 'coinpayment') { ?>

                        <strong>Important</strong></br>
                        <ul>
                            <li>
                                Send Only <strong><?php echo html_escape($deposit->currency_symbol); ?></strong>
                                deposit address. Sending any other coin or token to this address may result in the loss
                                of your deposit.</li>
                        </ul>
                        <br>
                        <center>
                            <div class="diposit-address margin-top-25">
                                <div class="label">
                                    <?php echo html_escape($deposit->currency_symbol); ?> Diposit Address.
                                </div>
                                <div class="dip_address">
                                    <strong><input type="text" class="form-control" id="copyed"
                                            value="<?php echo html_escape($deposit_data['result']['address']) ?>"
                                            readonly="readonly" /></strong>
                                </div>
                                <div class="copy_address margin-top-10">
                                    <button class="btn btn-primary copy">Copy Address</button>
                                </div>
                                <div class="diposit-qrcode margin-top-25">
                                    <div class="qrcode">
                                        <img src="<?php echo html_escape($deposit_data['result']['qrcode_url']) ?>" />
                                    </div>
                                </div>
                                <div class="deposit-balance margin-top">
                                    <h2 class="font-family-inherit">
                                        <?php echo number_format(html_escape($deposit->amount), 8) . " <span class='font-weight-normal'>" . html_escape($deposit->currency_symbol); ?></span>
                                    </h2>
                                </div>
                            </div>
                        </center>

                        <div class="please-note margin-top-10">
                            <div class="label_note">
                                Please Note
                            </div>
                            <div class="textnote">
                                <ul>
                                    <li>Coins will be deposited immediately after <font color="#03a9f4">
                                            <?php echo html_escape($deposit_data['result']['confirms_needed']); ?>
                                        </font> network confirmations</li>
                                    <li>You can track its progress on the <a target="_blank"
                                            href="<?php echo html_escape($deposit_data['result']['status_url']); ?>">history</a>
                                        page</li>
                                </ul>
                            </div>
                        </div>
                        <div class="please-note margin-top-10">
                            <div class="label_note">
                                <a href="<?php echo base_url() ?>"><button type="button"
                                        class="btn btn-success">Back</button></a>
                            </div>
                        </div>

                        <?php } elseif ($deposit->method == 'stripe') { ?>
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo display("user_id") ?></th>
                                <td class="text-right"><?php echo html_escape($deposit->user_id) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("payment_gateway") ?></th>
                                <td class="text-right"><?php echo html_escape($deposit->method) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("amount") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit->amount) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("fees") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit_fees) ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">
                                    <?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape((float)@$deposit->amount) + html_escape($deposit_fees) ?>
                                </td>
                            </tr>
                        </table>

                        <?php echo form_open('payment_callback/stripe_confirm', 'method="post" '); ?>
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="<?php echo html_escape($deposit_data['stripe']['publishable_key']); ?>"
                            data-description="<?php echo html_escape($deposit_data['description']) ?>"
                            data-amount="<?php $total = $deposit->amount + $deposit->fees_amount;
                                                                                                                                                                                                                                                                                    echo round(html_escape($total) * 100) ?>"
                            data-locale="auto">
                        </script>
                        <?php echo form_close(); ?>


                        <?php } elseif ($deposit->method == 'phone') { ?>
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo display("user_id") ?></th>
                                <td class="text-right"><?php echo html_escape(@$deposit->user_id) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("payment_gateway") ?></th>
                                <td class="text-right"><?php echo html_escape(@$deposit->method) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("amount") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape(@$deposit->amount) ?></td>
                            </tr>
                            <tr>
                                <th><?php echo display("fees") ?></th>
                                <td class="text-right"><?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape($deposit_fees) ?></td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-right">
                                    <?php echo html_escape($coininfo->pair_with) . " ";
                                                            echo html_escape((float)@$deposit->amount) + html_escape($deposit_fees) ?>
                                </td>
                            </tr>
                        </table>

                        <a class="btn btn-success w-md m-b-5 text-right"
                            href="<?php echo htmlspecialchars_decode($deposit_data['approval_url']) ?>">Payment
                            Process</a>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>