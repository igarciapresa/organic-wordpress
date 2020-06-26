<?php
/*
Template Name: Diets
*/
get_header();
?>
    <div class="page">
      <!-- Page Header-->
        <header class="section page-header">
        <!-- RD Navbar-->
        <?php get_template_part('nav'); ?>
        <div class="breadcrumbs-custom context-dark bg-overlay-46 single-thumbnail small-header">
            <h2 class="breadcrumbs-custom-title">DIETS</h2>
            <div class="box-position" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/diets.jpg)"></div>
        </div>
        </header>
        
        <section class="section section-md bg-default section-top-image blog-container">
          <div class="container">
              <div class="row">
                <h3>Choose the one that fits you</h3>
                <?php
                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                global $wp_query;
                $original_query = $wp_query;
                
                $args = array(
                    "posts_per_page" =>3,
                    "post_type"      => ['my_diet'],
                    'paged'          => $paged,
                );
                
                $loop = new WP_Query($args);
                $wp_query = $loop;

                if ($loop->have_posts()):
                ?>
                <table class="col-lg-12 table diets-table">
                    <thead class="thead">
                        <tr >
                            <th scope="col">Title</th>
                            <th scope="col">Goal</th>
                            <th scope="col">Type</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Price</th>
                            <th scope="col">Assessment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while(have_posts()):
                            the_post();
                            get_template_part('templates/diet','list');
                            endwhile;
                        ?>
                    </tbody>
                </table>
                <ul class="col-md-12 mb-5 pagination pagination-lg"> <?php 
                            the_posts_pagination(array(
                                 'mid_size' => 2,
                                 'prev_text' => 'Previous',
                                 'next_text' => 'Next',
                                 'screen_reader_text' => ' ',
                                )
                            );
                     ?>
                </ul>
                <?php
                    endif;
                    
                    ?>
                  <article class="box-contacts diets-content">
                    <img id="sandwich" src="<?php echo get_template_directory_uri(); ?>/assets/images/sandwich.jpg" alt="image">
                    <img id="sandwich2" src="<?php echo get_template_directory_uri(); ?>/assets/images/sandwich2.jpg" alt="image">
                    <div>
                      <h3>The Impact of Nutrition on Your Health</h3>
                      <p>Unhealthy eating habits have contributed to the obesity epidemic in the United States: about one-third of U.S. adults (33.8%) are obese and approximately 17% (or 12.5 million) of children and adolescents aged 2—19 years are obese.1 Even for people at a healthy weight, a poor diet is associated with major health risks that can cause illness and even death. These include heart disease, hypertension (high blood pressure), type 2 diabetes, osteoporosis, and certain types of cancer. By making smart food choices, you can help protect yourself from these health problems.

                        The risk factors for adult chronic diseases, like hypertension and type 2 diabetes, are increasingly seen in younger ages, often a result of unhealthy eating habits and increased weight gain. Dietary habits established in childhood often carry into adulthood, so teaching children how to eat healthy at a young age will help them stay healthy throughout their life.
                        
                        The link between good nutrition and healthy weight, reduced chronic disease risk, and overall health is too important to ignore. By taking steps to eat healthy, you'll be on your way to getting the nutrients your body needs to stay healthy, active, and strong. As with physical activity, making small changes in your diet can go a long way, and it's easier than you think!</p>
                    </div>
                  </article>
              </div>
              <div class="row">
                  <h3>Read our Latest Posts</h3>
                  <div class="row row-30 justify-content-center">
                  <?php
                  $args=array('posts_per_page' => 3,);
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
        </section>
    </div>
<?php
get_footer();
?>