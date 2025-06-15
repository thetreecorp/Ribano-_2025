<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h2><?php echo (!empty($title)?html_escape($title):null) ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                       
                            <table width="100%" class="datatable2 table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class=""><?php echo display('receiver_email'); ?></th>
                                        <th class=""><?php echo display('date_time'); ?></th>
                                        <th class="all"><?php echo display('message'); ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                <?php foreach($email_list as $value){?>
                                    <tr>
                                        <td><?php echo html_escape($value->reciver_email);?></td>
                                        <td><?php echo html_escape($value->delivery_date_time) ?></td>
                                        <td><?php echo html_escape($value->message);?></td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                            <?php echo htmlspecialchars_decode($links); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>