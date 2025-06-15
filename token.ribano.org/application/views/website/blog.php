        <div class="news-masonry">
            <div class="container">
                    <br>
                    <br>
                    <br>
            </div>
        </div>
        <!-- /.End of news masonry -->
        <div class="blog-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row">
<?php  
    foreach ($blog as $news_key => $news_value) {
        $article_id         = $news_value->article_id;
        $cat_id             = $news_value->cat_id;
        $slug               = $news_value->custom_data;
        $news_headline      = $news_value->data_headline;
        $news_article1      = $news_value->article_1;
        $news_article_image = $news_value->article_image;
        $publish_date       = $news_value->publish_date;
        $cat_slug           = strtolower($news_value->slug);
        $cat_name           = strtoupper($news_value->slug);
?>

            <div class="col-md-4">
                <article class="post-grid">
                    <figure>
                        <a href="<?php echo base_url('blog/'.html_escape($cat_slug)."/$slug"); ?>">
                            <img src="<?php echo base_url(html_escape($news_article_image)); ?>" class="img-fluid" alt="">
                        </a>
                    </figure>
                    <span><a href="<?php echo base_url('blog/'.html_escape($cat_slug)); ?>"><?php echo html_escape($cat_name); ?></a></span>
                    <h4 class="post-title"><a href="<?php echo base_url('blog/'.html_escape($cat_slug)."/$slug"); ?>"><?php echo strip_tags(html_escape($news_headline)); ?></a></h4>
                    <p class="post-des"><?php echo substr(strip_tags(htmlspecialchars_decode($news_article1)), 0, 110); ?></p>
                    <div class="information">admin, <?php
                                $date=date_create($publish_date);
                                echo date_format($date,"jS, F Y");
                            ?></div>
                </article>
                <!-- /.End of post grid -->
            </div>


<?php

    }

?>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <?php echo htmlspecialchars_decode($links); ?>                                    
                        </nav>
                    </div>
                </div>
            </div>
            <?php echo (!empty($content)?htmlspecialchars_decode($content):null) ?>
        </div>
    </div>
</div>
<!-- /.End of blog content -->

                        


                            


