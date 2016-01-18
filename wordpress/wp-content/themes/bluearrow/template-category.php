<?php use Roots\Sage\Titles; ?>
<?php
/**
 * Template Name: Category page template
 */
?>
<?php while (have_posts()) : the_post(); ?>
    <div id="page-category">
        <?php get_template_part('templates/content', 'page'); ?>
    </div>
<?php endwhile; ?>
