        <footer>
            <div class="main_footer">
                <div class="container">
                    <div class="testimonial-content">
                        <div class="row">
                            <div class="col-md-8 col-lg-6 ">
                                <div class="testimonials">

                                <?php foreach($testimonial as $key => $value){ ?>
                                    <div class="testimonial">
                                        <blockquote>
                                            <p><?php echo htmlspecialchars_decode($value->article_data); ?></p>
                                        </blockquote>
                                        <div> <cite><?php echo html_escape($value->video); ?></cite> <span class="title"><?php echo htmlspecialchars_decode($value->custom_data);  ?></span> </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <div class="widget-contact">
                                <ul class="list-icon">
                                    <li><?php echo htmlspecialchars_decode($settings->description) ?></li>
                                    <li><?php echo htmlspecialchars_decode($settings->phone) ?></li>
                                    <li><a href="mailto:<?php echo html_escape($settings->email) ?>"><?php echo html_escape($settings->email) ?></a></li>
                                    <li> <br>
                                        <?php echo htmlspecialchars_decode($settings->office_time) ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-4">
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-12 col-lg-6">
                                    <div class="footer-box">
                                        <h3 class="footer-title">Our Company</h3>
                                        <ul class="footer-list">
                                            <?php
                                                foreach ($footercat as $key => $value) {
                                                    if($value->cat_id==2 || $value->cat_id==8 || $value->cat_id==9 || $value->cat_id==10 || $value->cat_id==12){
                                            ?>
                                                    <li><a href="<?php echo base_url("#$value->link") ?>"><?php echo html_escape($value->slug); ?></a></li>
                                            <?php
                                                } }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 d-sm-none d-md-none d-lg-block">
                                    <div class="footer-box">
                                        <h3 class="footer-title">Service</h3>
                                        <ul class="footer-list">
                                            <?php
                                                foreach ($footercat as $key => $value) {
                                                    if($value->cat_id==2 || $value->cat_id==8 || $value->cat_id==9 || $value->cat_id==10 || $value->cat_id==12){}
                                                    else{
                                                        if(!empty($value->link)){
                                            ?>
                                                    <li><a href="<?php echo base_url("#$value->link") ?>"><?php echo html_escape($value->slug); ?></a></li>
                                            <?php
                                                } } }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-5 col-lg-3 offset-lg-1">
                            <div class="newsletter-box">
                                <h3 class="footer-title"><?php echo display('email_newslatter'); ?></h3>
                                <p><?php echo display('subscribe_to_our_newsletter'); ?></p>
                                <?php echo form_open('#','class="newsletter-form" id="subscribeForm" name="subscribeForm"'); ?>
                                    <input name="subscribe_email" placeholder="<?php echo display('email'); ?>" type="text">
                                    <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    <div class="envelope"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.End of main footer -->
            <div class="sub-footer">
                <div class="container">
                    <p class="footer-copyright"><?php echo htmlspecialchars_decode($settings->footer_text); ?></p>
                </div>
            </div>
        </footer>
        <!-- /.End of footer --> 
        <!-- Optional JavaScript --> 
        <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
        <script src="<?php echo base_url('assets/website/js/jquery-3.5.1.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/popper.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/bootstrap.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/jquery.dd.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/metisMenu.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/jquery.easing.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/jquery.mCustomScrollbar.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/jquery.magnific-popup.min.js')?>"></script>
        <script src="<?php echo base_url('assets/website/js/flipclock.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/slick/slick.min.js')?>"></script> 
        <script src="<?php echo base_url('assets/website/js/echarts-en.min.js')?>"></script>
        <script src="<?php echo base_url('assets/website/js/echarts-liquidfill.min.js')?>"></script>
        <script src="<?php echo base_url('assets/website/js/classie.min.js')?>"></script>
        <script src="<?php echo base_url('assets/website/js/script.js')?>"></script>
        <script src="<?php echo base_url('assets/website/js/script-new.js')?>"></script>