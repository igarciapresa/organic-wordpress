<?php
add_theme_support('post-thumbnails');

function add_scripts(){
    wp_register_script('core', get_template_directory_uri() . '/assets/js/core.min.js', array(jquery), null, true);
    wp_enqueue_script('core');
    
    wp_register_script('html5shiv', get_template_directory_uri() . '/assets/js/html5shiv.min.js', array(jquery), null, true);
    wp_enqueue_script('html5shiv');
    
    wp_register_script('pointer', get_template_directory_uri() . '/assets/js/pointer-events.min.js', array(jquery), null, true);
    wp_enqueue_script('pointer');
    
    wp_register_script('script', get_template_directory_uri() . '/assets/js/script.js', array(jquery), null, true);
    wp_enqueue_script('script');
    
    wp_register_script('masonry', get_template_directory_uri() . 'assets/js/masonry.pkgd.min.js', array('jquery') ,null, false);
    wp_enqueue_script('masonry');
    
    wp_register_script('masonry', get_template_directory_uri() . 'assets/js/masonry.pkgd.min.js', array('jquery') ,null, false);
    wp_enqueue_script('masonry');
    
    wp_register_script('progressBar', get_template_directory_uri() . 'assets/js/progressBar.js', array('jquery') ,null, false);
    wp_enqueue_script('progressBar');
    
    wp_register_script('jquery', get_template_directory_uri() . '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', array('jquery') ,null, false);
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'add_scripts');

function add_styles(){
    
    wp_register_style('style', get_template_directory_uri() . 'assets/css/style.css');
    wp_enqueue_style('style');
    
    wp_register_style('fonts', get_template_directory_uri() . 'assets/css/fonts.css');
    wp_enqueue_style('fonts');
    
    wp_register_style('bootstrap', get_template_directory_uri() . 'assets/css/bootstrap.css');
    wp_enqueue_style('bootstrap');
    
    wp_register_style('poppins', get_template_directory_uri() . '//fonts.googleapis.com/css?family=Poppins:300,400,500');
    wp_enqueue_style('poppins');
}

add_action('wp_enqueue_scripts','add_styles');

function generaltheme_widgets_init(){
    register_sidebar(array(
        'name' => 'Sidebar Widgets',
        'id' => 'sidebar',
        'description' => 'Sidebar Widget Area',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
    ));
}

add_action('widgets_init', 'generaltheme_widgets_init');

add_filter( 'excerpt_length', function($length) {
    return 25;
} );

function get_post_tags(){
    if(is_page('Archives')){
        $args = ['orderby' => 'count',
                 'order' => 'desc',
                 'number'  => 10,    
                ];
        $tags = get_tags($args);
        if($tags !== null){
        echo '<ul>';
        foreach($tags as $tag){
            echo '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a><span class="tagcount">' . $tag->count . '</span>';
        }
        echo '</ul>';
        }else echo 'No tags found';
    }
}

function get_author_role($author_id){
    $user_info = get_userdata($author_id);
    return implode(',',$user_info->roles);
}

require_once('custom-fields.php');

function home_active(){
    if(is_front_page()){
        echo "active";
    }
     else echo "";
}

function blog_active(){
    if(is_home() || is_single()){
        echo "active";
    }
     else echo "";
}

function archives_active(){
    if (is_page('archives')){
        echo "active";
    }
     else echo "";
}

function diets_active(){
    if (is_page('diets')){
        echo "active";
    }
     else echo "";
}

function private_active(){
    if (is_page('private')){
        echo "active";
    }
     else echo "";
}

function edit_comment_form($fields){
    $aux = array();

    array_push($aux,$fields['author']);
    array_push($aux,$fields['email']);
    array_push($aux,$fields['comment']);
    array_push($aux,$fields['cookies']);

    $aux['checkbox'] = '<input type="checkbox" name="consent" value="consent"> Check this box to give us permission to publicly post your Review.';    
    if(is_user_logged_in()){
        echo $fields['comment'];
        echo $aux['checkbox'];
    }else
    return $aux;    
}

add_action('comment_form_fields','edit_comment_form');

function save_consent_field($comment_id){
    $consent_checkbox = $_POST['consent'];
    if($consent_checkbox == true){
        $result = "Checkbox checked.";
    } else {
        $result = "Checkbox not checked.";
    }
    add_comment_meta($comment_id,'consent',$result,true);
}

add_action('comment_post','save_consent_field');


function add_consent_column($columns){
        $columns = array(
            'cb'     => '<input type="checkbox"/>',
            'author' => 'Author',
            'comment'=> 'Comment',
            'consent_column' => 'Private Policy Consenting',
            'response' => 'In response to',
            'date'   => 'Date posted',
        );
        return $columns;
}
add_action('manage_edit-comments_columns','add_consent_column');

function show_private_policy_consent($col, $comment_id){
    if($col == 'consent_column'){
       echo get_comment_meta($comment_id,'consent',true);
    }
}

add_action('manage_comments_custom_column','show_private_policy_consent',10,2);

function getPostViews($post_id){
	session_start();
    $count_key = 'view_count';
    $count = get_post_meta($post_id, $count_key, true);
    if($count==''){
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return 0;
    }
    return $count;
}

function setPostViews($post_id) {
    $count_key = 'view_count';
    $count = get_post_meta($post_id, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    }else{
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function get_diet_goal(){
    $slug = get_post_meta(get_the_ID(),'goal',true);
    $result = '';
    if($slug == "weight"){
        $result = "Weight Loss";
    } else if($slug == "muscle"){
        $result = "Muscle Gain";
    } else if($slug == "health"){
        $result = "Health Improve";
    } else if($slug == "organic"){
        $result = "Only Organic";
    }
    
    return $result;
}

function get_diet_type(){
    $slug = get_post_meta(get_the_ID(),'type',true);
    $result = '';
    if($slug == "omnivore"){
        $result = "Omnivore";
    } else if($slug == "vegetarian"){
        $result = "Vegetarian";
    } else if($slug == "vegan"){
        $result = "Vegan";
    } else if($slug == "raw"){
        $result = "Raw Vegan";
    }
    
    return $result;
}

function get_diet_duration(){
    $weekmonth = get_post_meta(get_the_ID(),'weekmonth',true);
    $duration = get_post_meta(get_the_ID(),'duration',true);
    if($duration == 1){
        $weekmonth = substr($weekmonth, 0, -1);
    }
    $result = $duration . ' ' . $weekmonth;
    
    return $result;
}

function get_diet_weight(){
    $weight = get_post_meta(get_the_ID(),'weight',true);
    $updown = get_post_meta(get_the_ID(),'updown',true);
    if($updown == "up"){
        $updown = "+";
    } else if($updown == "down"){
        $updown = "-";
    }
    if($weight == 0){
        $updown = "&#177;";
    }
    $result = $updown . $weight;
    
    return $result;
}

function get_diet_star1(){
    $assessment = get_post_meta(get_the_ID(),'assessment',true);
    $result = "";
    if($assessment >= 1){
        $result = "checked";
    }
    return $result;
}

function get_diet_star2(){
    $assessment = get_post_meta(get_the_ID(),'assessment',true);
    $result = "";
    if($assessment >= 2){
        $result = "checked";
    }
    return $result;
}

function get_diet_star3(){
    $assessment = get_post_meta(get_the_ID(),'assessment',true);
    $result = "";
    if($assessment >= 3){
        $result = "checked";
    }
    return $result;
}

function get_diet_star4(){
    $assessment = get_post_meta(get_the_ID(),'assessment',true);
    $result = "";
    if($assessment >= 4){
        $result = "checked";
    }
    return $result;
}

function get_diet_star5(){
    $assessment = get_post_meta(get_the_ID(),'assessment',true);
    $result = "";
    if($assessment >= 5){
        $result = "checked";
    }
    return $result;
}

function get_diet_intolerances(){
    $gluten = get_post_meta(get_the_ID(),'gluten',true);
    $lactose = get_post_meta(get_the_ID(),'lactose',true);
    $result = '';
    
    if($gluten && $lactose){
        $result = 'Gluten and Lactose';
    } else if($lactose){
        $result = 'Lactose';
    } else if($gluten){
        $result = 'Gluten';
    } else $result = 'None';
    
    return $result;
}

function custom_login_logo(){?>
<style type="text/css">
    #login h1 a, .login h1 a{
        background-image: url("<?php echo get_stylesheet_directory_uri();?>/assets/images/organic2.png");
    }
</style> <?php
}
add_action('login_enqueue_scripts', 'custom_login_logo');