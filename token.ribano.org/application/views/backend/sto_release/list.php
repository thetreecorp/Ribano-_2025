<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading  d-flex justify-content-between align-items-center">
                <div class="panel-title">
                    <h2><?php echo (!empty($title) ? html_escape($title) : null) ?></h2>
                </div>
                <a class="btn btn-success w-md m-b-5 pull-right"
                    href="<?php echo base_url("backend/sto_settings/sto_release/form") ?>"><i class="fa fa-plus"
                        aria-hidden="true"></i> <?php echo display('coin_release'); ?></a>
            </div>
            <div class="panel-body">
                <table class="datatable2 table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('round_name'); ?></th>
                            <th><?php echo display('day'); ?></th>
                            <th><?php echo display('target'); ?></th>
                            <th><?php echo display('fillup_target'); ?></th>
                            <th class="hide"><?php echo display('exchange_currency'); ?></th>
                            <th><?php echo display('date'); ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sto_release)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($sto_release as $value) {

                            $percent  = ($value->fillup_target * 100) / $value->target;
                        ?>
                        <tr>
                            <td><?php echo html_escape($sl++); ?></td>
                            <td><?php echo html_escape($value->round_name); ?></td>
                            <td><?php echo html_escape($value->day); ?></td>
                            <td><?php echo html_escape($value->target); ?></td>
                            <td>
                                <div class="progress progress-lg background-darkgray">
                                    <div class="progress-bar progress-bar-warning progress-bar-striped active"
                                        role="progressbar" aria-valuenow="<?php echo html_escape($percent) ?>"
                                        aria-valuemin="0" aria-valuemax="100"
                                        style="width: <?php echo html_escape($percent) ?>%">
                                        <?php echo html_escape($percent) ?>%
                                    </div>
                                </div>
                            </td>
                            <td class="hide"><?php echo html_escape($value->exchange_currency); ?></td>
                            <td><?php echo html_escape($value->start_date); ?></td>
                            <td><?php echo (($value->status == 1) ? display('active') : display('inactive')); ?></td>
                            <td>
                                <?php if (!empty($userrole)) {
                                        if ($userrole->edit_permission == 1) { ?>
                                <a href="<?php echo base_url("backend/sto_settings/sto_release/form/$value->id") ?>"
                                    class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left"
                                    title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php }
                                    } else { ?>
                                <a href="<?php echo base_url("backend/sto_settings/sto_release/form/$value->id") ?>"
                                    class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left"
                                    title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php } ?>
                                <?php if (!empty($userrole)) {
                                        if ($userrole->delete_permission == 1) { ?>
                                <a href="<?php echo base_url("backend/sto_settings/sto_release/delete/$value->id") ?>"
                                    class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left"
                                    title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></a>
                                <?php }
                                    } else { ?>
                                <a href="<?php echo base_url("backend/sto_settings/sto_release/delete/$value->id") ?>"
                                    class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left"
                                    title="Delete"><i class="fa fa-remove" aria-hidden="true"></i></a>
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