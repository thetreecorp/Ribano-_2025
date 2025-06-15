<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo display('deposit'); ?></h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="border_preview">
                        <table class="table table-bordered">
                                <tr>
                                    <th><?php echo display("user_id") ?></th>
                                    <td class="text-right"><?php echo html_escape($user_id); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo display("usd_amount") ?></th>
                                    <td class="text-right">$<?php echo html_escape($deposit_amount) ?></td>
                                </tr>
                            </table>

<?php echo form_open('shareholder/home/stripe_confirm', 'method="post" '); ?>
<input type="hidden" value="<?php echo html_escape($deposit_id) ?>" name="asdfasd">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo html_escape($stripe['publishable_key']); ?>"
          data-description="<?php echo html_escape($description) ?>"
          data-amount="<?php echo round(html_escape($deposit_amount)*100) ?>"
          data-locale="auto"></script>
<?php echo form_close();?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
