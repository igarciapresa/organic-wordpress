<?php
    global $count;
    $count++;
?>

<tr>
    <td><a href="<?php echo the_permalink(); ?>"><?php  the_title(); ?></a></td>
    <td><?php echo get_diet_goal(); ?></td>
    <td><?php echo get_diet_type(); ?></td>
    <td><?php echo get_diet_duration(); ?></td>
    <td><?php echo get_diet_weight(); ?> kg</td>
    <td><?php echo get_post_meta(get_the_ID(),'price',true);?> €</td>
    <td>
        <span class="fa fa-star <?php echo get_diet_star1(); ?>"></span>
        <span class="fa fa-star <?php echo get_diet_star2(); ?>"></span>
        <span class="fa fa-star <?php echo get_diet_star3(); ?>"></span>
        <span class="fa fa-star <?php echo get_diet_star4(); ?>"></span>
        <span class="fa fa-star <?php echo get_diet_star5(); ?>"></span>
    </td>
</tr>