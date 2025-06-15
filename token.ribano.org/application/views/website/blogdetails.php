<br>
<br>
<br>
<br>
<br>
        <div class="blog_wrapper">
            <div class="container">
                <div class="row">
                    <main class="col-md-9">
                        <?php
                            foreach ($advertisement as $add_key => $add_value) { 
                                $ad_position   = $add_value->serial_position;
                                $ad_link       = $add_value->url;
                                $ad_script     = $add_value->script;
                                $ad_image      = $add_value->image;
                                $ad_name       = $add_value->name;                            

                        ?>

                        <?php if (@$ad_position==8) { ?>
                        <div class="widget">
                            <div class="widget_banner">
                                <?php if ($ad_script=="") { ?>
                                <a target="_blank" href="<?php echo html_escape($ad_link) ?> "><img src="<?php echo base_url(html_escape($ad_image)) ?>" class="img-fluid" alt="<?php echo strip_tags(html_escape($ad_name)) ?>"></a>
                                <?php } else { echo html_escape($ad_script); } ?>
                            </div>
                        </div><!-- /.End of banner -->
                        <?php } } ?>
                        <div class="post_details">
                            <header class="details-header">
                                <div class="post-cat"><span class="cat-links"><a href="<?php echo base_url('blog') ?>">Blog</a></span></div>
                                <h2><?php echo html_escape($blog->data_headline); ?></h2>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-img">
                                        <img src="<?php echo base_url(html_escape($blog->article_image)); ?>" class="" alt="">
                                    </div>
                                    <div class="meta-info">
                                        <span class="avatar-name">admin</span>
                                        <span class="date"><?php 
                                                $date=date_create($blog->publish_date);
                                                echo date_format($date,"jS, F Y"); 
                                            ?></span>
                                    </div>
                                </div>
                            </header>
                            <figure>
                                <img src="<?php echo base_url(html_escape($blog->article_image)); ?>" alt="<?php echo strip_tags(html_escape($blog->data_headline)); ?>" class="aligncenter img-fluid">
                            </figure>
                            <?php echo html_escape($blog->article_1); ?>
                          
                        </div>
                        <!-- /.End of post details -->
                        <?php
                            foreach ($advertisement as $add_key => $add_value) { 
                                $ad_position   = $add_value->serial_position;
                                $ad_link       = $add_value->url;
                                $ad_script     = $add_value->script;
                                $ad_image      = $add_value->image;
                                $ad_name       = $add_value->name;                            

                        ?>

                        <?php if (@$ad_position==9) { ?>
                        <div class="widget">
                            <div class="widget_banner">
                                <?php if ($ad_script=="") { ?>
                                <a target="_blank" href="<?php echo html_escape($ad_link) ?> "><img src="<?php echo base_url(html_escape($ad_image)) ?>" class="img-fluid" alt="<?php echo strip_tags(html_escape($ad_name)) ?>"></a>
                                <?php } else { echo html_escape($ad_script); } ?>
                            </div>
                        </div><!-- /.End of banner -->
                        <?php } } ?>
                    </main>
                    <?php echo (!empty($content)?htmlspecialchars_decode($content):null) ?>
                </div>
            </div>
        </div>
        <!-- /.End of page content -->