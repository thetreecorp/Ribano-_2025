<?php
$settings = $this->db->select("*")
    ->get('setting')
    ->row();

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="<?php echo base_url(!empty($settings->logo) ? html_escape($settings->logo) : "assets/images/icons/logo.png"); ?>"
                            class="img-responsive" alt="">
                        <br>
                        <address>
                            <strong><?php echo html_escape($settings->title) ?></strong><br>
                            <?php echo html_escape($settings->description); ?><br>

                        </address>

                    </div>
                    <div class="col-sm-6 text-right">
                        <h1 class="m-t-0"><?php echo display('purchase_order_no'); ?> :
                            <?php echo $this->uri->segment(4); ?></h1>
                        <div><?php echo date('d-M-Y'); ?></div>
                        <address>
                            <strong><?php echo html_escape($my_info->first_name) . ' ' . html_escape($my_info->last_name); ?></strong><br>
                            <?php echo html_escape($my_info->email); ?><br>
                            <?php echo html_escape($my_info->phone); ?><br>
                            <abbr title="Phone"><?php echo display('account'); ?> :</abbr>
                            <?php echo html_escape($my_info->user_id); ?>
                        </address>
                    </div>
                </div>
                <hr>
                <div class="table-responsive m-b-20">
                    <table class="table table-border table-bordered ">
                        <thead>
                            <tr>
                                <th><?php echo display('package_name') ?></th>
                                <th><?php echo display('details') ?></th>
                                <th><?php echo display('num_share') ?></th>
                                <th><?php echo display('package_price') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo html_escape($package->package_name); ?>
                                    (<?php echo html_escape($package->pack_type); ?>)</td>
                                <td>
                                    <div>
                                        <?php if ($package->facility_type == 1) { ?>

                                        <strong>ROI</strong>
                                        <?php } else { ?>

                                        <?php
                                            if (!empty($package->data)) {
                                                $jsondata = json_decode($package->data, true);
                                                $i = 1;
                                                foreach ($jsondata as $key => $value) {
                                            ?>
                                        <strong><?php echo html_escape($i) . ". " . html_escape($value); ?></strong></br>
                                        <?php
                                                    html_escape($i++);
                                                }
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>
                                <td><?php echo html_escape($stoinfo->symbol); ?>
                                    <?php echo html_escape($package->num_share); ?></td>
                                <td><?php echo html_escape($stoinfo->pair_with); ?>
                                    <?php echo html_escape($package->package_price); ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="package-trems">
                    <input type="checkbox" name="package_terms" id="package_terms">
                    <label class="package_terms_condition" data-toggle="modal"
                        data-target="#myModal"><?php echo display('i_agree_package_terms_and_condition'); ?></label>
                </div>
            </div>

            <div class="modal fade display-none" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h1 class="modal-title"><?php echo display('package_terms_and_condition'); ?></h1>
                        </div>
                        <div class="modal-body">
                            <p><?php echo html_escape($package->package_term); ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal"><?php echo display('close'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

            <div class="panel-footer text-right">
                <a href="<?php echo base_url('shareholder/package/buy/') . $package->package_id; ?>"><button
                        type="button" id="confirm_order"
                        class="btn btn-success"><?php echo display('confirm'); ?></button></a>
                <a href="<?php echo base_url('shareholder/home') ?>" class="btn btn-danger">
                    <?php echo display('cancel'); ?></a>
            </div>
        </div>
    </div>
</div>