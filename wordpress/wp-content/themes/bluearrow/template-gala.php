<?php use Roots\Sage\Titles; ?>
<?php
/**
 * Template Name: Gala page template
 */
?>
<?php while (have_posts()) : the_post(); ?>
    <div id="page-gala">

        <?php get_template_part('templates/content', 'page'); ?>

    </div>
<?php endwhile; ?>
