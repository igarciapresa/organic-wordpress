<?php
/*
Plugin Name: Diets
Plugin URI:
Description:
Version:
Author:
Author URI:
License:
License URI:
*/

function my_diet_custom_post_type(){
    $supports = array(
        'title',
        'editor',
        'excerpt',
        'author',
        'comments',
        'revisions',
        'thumbnail',
    );

    $labels = array(
        'name' => _x('Diets', 'plural'),
        'singular_name' => _x('Diet', 'singular'),
        'menu_name' => _x('Diets', 'admin_menu'),
        'name_admin_bar' => _x('Diets', 'admin_bar'),
        'add_new' => _x('Add New', 'add new'),
        'new_item' => __('Add New Diet'),
        'edit_item' => __('Edit Diet'),
        'view_item' => __('View Diet'),
        'all_items' => __('All Diets'),
        'search_items' => __('Search Diet'),
        'not_found' => __('No diets found...'),
    );

    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_bar' => true,
        'rewrite' => array('slug' => 'my_diet'),
        'has_archive' => true,
        'hierarchical' => false,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-carrot',
    );

    register_post_type('my_diet', $args);
}

add_action('init', 'my_diet_custom_post_type');

function add_tagscats(){
    register_taxonomy_for_object_type('category', 'my_diet');
    register_taxonomy_for_object_type('post_tag', 'my_diet');
}

add_action('init', 'add_tagscats');

function my_diet_add_meta_box(){
    $screens = array('my_diet');
    foreach($screens as $screen){
        add_meta_box(
            'my_diet_sectionid',
            __('Diet Details', 'organic'),
            'my_diet_meta_box_callback',
            $screen,
            'normal'
        );
    }
}

add_action('add_meta_boxes', 'my_diet_add_meta_box');

function my_diet_meta_box_callback($post){
    /*Crear el campo de validacion*/
    wp_nonce_field(basename(__FILE__), 'my_diet_metabox_nonce');

    //Cosecha de los datos previos
    $goal = get_post_meta($post->ID, 'goal', true);
    $type = get_post_meta($post->ID, 'type', true);
    $lactose = get_post_meta($post->ID, 'lactose', true);
    $gluten = get_post_meta($post->ID, 'gluten', true);
    $duration = get_post_meta($post->ID, 'duration', true);
    $weekmonth = get_post_meta($post->ID, 'weekmonth', true);
    $meals = get_post_meta($post->ID, 'meals', true);
    $weight = get_post_meta($post->ID, 'weight', true);
    $updown = get_post_meta($post->ID, 'updown', true);
    $price = get_post_meta($post->ID, 'price', true);
    $assessment = get_post_meta($post->ID, 'assessment', true);

    //Codigo html de la metabox
    ?>
    <table class="form-table">
        <tr>
            <th><label for="goal">Goal</label></th>
            <td>
                <select name="goal" id="goal" value="<?php $goal ?>">
                    <option value="weight" <?php if($goal=='weight') echo 'selected'; ?>>Weight Loss</option>
                    <option value="muscle" <?php if($goal=='muscle') echo 'selected'; ?>>Muscle Gain</option>
                    <option value="health" <?php if($goal=='health') echo 'selected'; ?>>Health Improve</option>
                    <option value="organic" <?php if($goal=='organic') echo 'selected'; ?>>Only Organic</option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="type">Type</label></th>
            <td>
                <select name="type" id="type" value="<?php $type ?>">
                    <option value="omnivore" <?php if($type=='omnivore') echo 'selected'; ?>>Omnivore</option>
                    <option value="vegetarian" <?php if($type=='vegetarian') echo 'selected'; ?>>Vegetarian</option>
                    <option value="vegan" <?php if($type=='vegan') echo 'selected'; ?>>Vegan</option>
                    <option value="raw" <?php if($type=='raw') echo 'selected'; ?>>Raw Vegan</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <th><label for="intolerance">Intolerance</label></th>
            <td>
                <input type="checkbox" id="lactose" name="lactose" <?php if($lactose) echo "checked" ?>>
                <label for="vehicle1"> Lactose</label><br>
            </td>
            <td>
                <input type="checkbox" id="gluten" name="gluten" <?php if($gluten) echo "checked" ?>>
                <label for="vehicle1"> Gluten</label><br>
            </td>
        </tr>

        <tr>
            <th><label for="duration">Duration</label></th>
            <td>
                <input type="number" name="duration" id="duration" value="<?php echo $duration ?>" min="1" max="15" step="1">
                <select name="weekmonth" id="weekmonth"  value="<?php $weekmonth ?>">
                    <option value="weeks" <?php if($weekmonth=='weeks') echo 'selected'; ?>>Weeks</option>
                    <option value="months" <?php if($weekmonth=='months') echo 'selected'; ?>>Months</option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="meals">Meals</label></th>
            <td>
                <input type="number" name="meals" id="meals" value="<?php echo $meals ?>" min="2" max="6" step="1">
            </td>
        </tr>

        <tr>
            <th><label for="weight">Weight</label></th>
            <td>
                <input type="number" name="weight" id="weight" value="<?php echo $weight ?>" min="0" max="20"> kg
                <select name="updown" id="updown"  value="<?php $updown ?>">
                    <option value="up" <?php if($updown=='up') echo 'selected'; ?>>Up</option>
                    <option value="down" <?php if($updown=='down') echo 'selected'; ?>>Down</option>
                </select>
            </td>
        </tr>

        <tr>
            <th><label for="price">Price</label></th>
            <td>
                <input type="number" name="price" id="price" value="<?php echo $price ?>" min="0"> €
            </td>
        </tr>
        
        <tr>
            <th><label for="assessment">Assessment</label></th>
            <td>
                <input type="number" name="assessment" id="assessment" value="<?php echo $assessment ?>" min="0" max="5">
            </td>
        </tr>
    </table>
    <?php
}

function save_my_diet($post_id){
    if(!wp_verify_nonce($_POST['my_diet_metabox_nonce'], basename(__FILE__))){
        return;
    }

    $goal = sanitize_text_field($_POST['goal']); //name en el formulario
    $type = sanitize_text_field($_POST['type']);
    $lactose = sanitize_text_field($_POST['lactose']);
    $gluten = sanitize_text_field($_POST['gluten']);
    $duration = sanitize_text_field($_POST['duration']);
    $weekmonth = sanitize_text_field($_POST['weekmonth']);
    $meals = sanitize_text_field($_POST['meals']);
    $weight = sanitize_text_field($_POST['weight']);
    $updown = sanitize_text_field($_POST['updown']);
    $price = sanitize_text_field($_POST['price']);
    $assessment = sanitize_text_field($_POST['assessment']);

    update_post_meta($post_id, 'goal', $goal); //del get_post_meta
    update_post_meta($post_id, 'type', $type);
    update_post_meta($post_id, 'lactose', $lactose);
    update_post_meta($post_id, 'gluten', $gluten);
    update_post_meta($post_id, 'duration', $duration);
    update_post_meta($post_id, 'weekmonth', $weekmonth);
    update_post_meta($post_id, 'meals', $meals);
    update_post_meta($post_id, 'weight', $weight);
    update_post_meta($post_id, 'updown', $updown);
    update_post_meta($post_id, 'price', $price);
    update_post_meta($post_id, 'assessment', $assessment);
}

add_action('save_post', 'save_my_diet');