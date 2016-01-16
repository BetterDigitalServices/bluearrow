<?php use Roots\Sage\Titles; ?>
<?php
/**
 * Template Name: Category page template
 */
?>
<?php while (have_posts()) : the_post(); ?>
    <div id="page-category">
        <div class="row">
            <div class="col-md-2 col-md-offset-1">
                <div class="rotate">
                    <h4><?= Titles\title(); ?></h4>
                </div>
            </div>
            <div class="col-md-8">
                <?php get_template_part('templates/content', 'page'); ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>
