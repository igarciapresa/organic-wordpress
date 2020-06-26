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
            <h2 class="breadcrumbs-custom-title">PRIVATE ZONE</h2>
            <h5><?php if(is_user_logged_in()) echo 'Welcome ' . wp_get_current_user()->user_login; else echo 'You are not logged in'; ?></h5>
            <div class="box-position" style="background-image: url(<?php echo get_template_directory_uri(); ?>/assets/images/flor.jpg)"></div>
        </div>
        </header>
        
        <section class="section section-md bg-default section-top-image blog-container">
            <div class="container">
                <div class="row">
                    <?php if(!is_user_logged_in()): ?>
                    <div class="private-container">
                        <div class="box-contacts login-box">
                            <div class="rd-navbar-brand"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/organic.png" alt="" width="300"/></div>
                            <?php wp_login_form();
                            wp_register();?>
                        </div>
                    </div>
                    <?php else : echo "<div class='login-container'><a class='button button-primary button-ujarak' href=" . admin_url() .">Admin Area</a><a class='button button-primary button-ujarak' href=" . wp_logout_url(get_permalink()) .">Logout</a></div>"; endif;?>
                </div>
            </div>
        </section>
    </div>
<?php
get_footer();
?>