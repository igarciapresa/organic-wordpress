<?php
    get_header();
    the_post();
    $mypost_id = $post->ID;
    $cats = get_the_category();
    $catid = array();
    foreach($cats as $cat){
        $catid[]=$cat->term_id;
    }
?>

        <!-- Navigation Area
        ===================================== -->
        <?php get_template_part('nav'); ?>
        <div class="breadcrumbs-custom context-dark bg-overlay-46 single-thumbnail">
            <h2 class="breadcrumbs-custom-title"><?php the_title(); ?></h2>
            <ul class="breadcrumbs-custom-path">
                <li><i class="fa fa-calendar"></i> <?php the_time('j-M-Y'); ?></li>
                <li><i class="fa fa-pencil"></i> <a href="#"><?php the_author(); ?></a></li>
                <li><i class="fa fa-comment-o"></i> <a href="#"><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></a></li>
                <li><i class="fa fa-eye"></i> <a href="#"><?php setPostViews($post->ID); echo getPostViews($post->ID) . ' Views'; ?></a></li>
                <li>
                    <span class="fa fa-star <?php echo get_diet_star1(); ?>"></span>
                    <span class="fa fa-star <?php echo get_diet_star2(); ?>"></span>
                    <span class="fa fa-star <?php echo get_diet_star3(); ?>"></span>
                    <span class="fa fa-star <?php echo get_diet_star4(); ?>"></span>
                    <span class="fa fa-star <?php echo get_diet_star5(); ?>"></span>
                </li>
            </ul>
            <div class="box-position" style="background-image: url(<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url();} ?>);"></div>
        </div>
        
        <section id="blog" class="section section-md section-first bg-default text-md-left">
            <div class="container">
                
                <div class="row">
                    <!-- Blog Sidebar
                    ===================================== --> 
                    <?php get_sidebar(); ?>
                    <div class="col-md-8 mt25">
                        <div class="card diet-data">
                            <div class="card-header">Diet Data</div>
                            <div class="custom-fields">
                                <div class="card-content">
                                    <strong><i class="fas fa-bullseye"></i> Goal</strong>
                                    <p><?php echo get_diet_goal(); ?></p>
                                </div>
                                <div class="card-content">
                                    <strong><i class="fas fa-drumstick-bite"></i> Type</strong>
                                    <p><?php echo get_diet_type(); ?></p>
                                </div>
                                <div class="card-content">
                                    <strong><i class="fas fa-clipboard-list"></i> Intolerances</strong>
                                    <p><?php echo get_diet_intolerances(); ?></p>
                                </div>
                                <div class="card-content">
                                    <strong><i class="fas fa-clock"></i> Duration</strong>
                                    <p><?php echo get_diet_duration(); ?></p>
                                </div>
                                <div class="card-content">
                                    <strong><i class="fas fa-utensils"></i> Meals</strong>
                                    <p><?php echo get_post_meta(get_the_ID(),'meals',true); ?></p>
                                </div>
                                <div class="card-content">
                                    <strong><i class="fas fa-weight"></i> Weight</strong>
                                    <p><?php echo get_diet_weight(); ?> kg</p>
                                </div>
                                <div class="card-content">
                                    <strong><i class="fas fa-dollar-sign"></i></i> Price</strong>
                                    <p><?php echo get_post_meta(get_the_ID(),'price',true); ?> €</p>
                                </div>
                            </div>
                        </div>
                        <div class="blog-three-mini">
                            <?php the_content(); ?>
                        </div>
                        <?php comments_template(); ?>
                    </div>
                    <div class="row">
                      <h3>Other Diets</h3>
                      <div class="row row-30 justify-content-center">
                      <?php
                      $args=array(
                          'posts_per_page'  => 3,
                          'post_type'       => ['my_diet'],
                          'post__not_in'    => array(get_the_ID())
                          );
                      $myquery = new WP_Query($args);
                      if($myquery->have_posts()):
                      while($myquery->have_posts()): 
                        $myquery->the_post();?>
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInRight" data-wow-delay="0s">
                          <!-- Team Classic-->
                          <article class="team-classic"><a href="<?php the_permalink(); ?>"><img src="<?php if ( has_post_thumbnail() ) { echo get_the_post_thumbnail_url();} ?>" alt="image"></a>
                            <div class="posts-classic-caption">
                              <h4 class="team-classic-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                              <p class="team-classic-status"><?php the_author(); ?></p>
                            </div>
                          </article>
                          <p class="mt25">
                              <?php the_excerpt(); ?>                            
                          </p>
                          <a href="<?php the_permalink(); ?>" class="more-btn">Read More</a>
                          <span class="blog-date"><?php the_time('M j, Y'); ?></span>
                        </div>
                      <?php endwhile; ?>
                      </div>
                      <?php
                        endif;
                        wp_reset_postdata();
                      ?>
                    </div>
                </div>
            </div>
            
            <?php
            $args = array(
              'nopaging' => false,
              'post_type' => array('post'),
              'posts_per_page' => 3,
              'category__in' => wp_get_post_categories($mypost_id),
              'post__not_in' => array($mypost_id),
              'tax_query' => array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array(
                            'post-format-gallery',
                            'post-format-video',
                            'post-format-audio',
                            'post-format-image'
                        ),
                        'operator' => 'NOT IN'
                    )
                )
            );
            ?>
            
        </section>

<?php
    get_footer();
?>