<?php
/*
Template Name: All Posts
*/
get_header();
?>
<div class="page">
    <!-- Page Header-->
    <header class="section page-header">
        <!-- RD Navbar-->
        <?php get_template_part('nav'); ?>
    </header>
    <div class="breadcrumbs-custom context-dark bg-overlay-46 single-thumbnail small-header">
        <h2 class="breadcrumbs-custom-title">ALL POSTS</h2>
        <h4><?php echo $title_archives; ?></h4>
        <div class="box-position" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/all.jpg)"></div>
    </div>
    <section class="section section-md section-first bg-default">
        <div class="container">
            <div class="row">
            <?php get_sidebar(); ?>
            <div class="col-md-8">
                <ul class="categories-list">
                    <?php wp_list_categories('title_li&orderby=count&number=5&order=desc'); ?>
                    <li class="cat-item">
                        <a href="<?php echo get_page_link(get_page_by_title('All Posts')->ID)?>">All posts</a>
                    </li>
                </ul>
                <?php
                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                global $wp_query;
                $original_query = $wp_query;
                
                $args = array(
                    "posts_per_page"=>10,
                    'paged'    => $paged,
                );
                
                $loop = new WP_Query($args);
                $wp_query = $loop;

                if ($loop->have_posts()):
                ?>
                <table class="col-lg-12 table">
                    <thead class="thead">
                        <tr >
                            <th scope="col">#</th>
                            <th scope="col">Post Date</th>
                            <th scope="col">Post Author</th>
                            <th scope="col">Post Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while(have_posts()):
                            the_post();  
                            get_template_part('templates/content','list');
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
            </div>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
?>