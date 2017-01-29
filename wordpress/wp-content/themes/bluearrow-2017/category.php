<div class="row">
  <div class="col-xs-12">
    <h1><?php single_cat_title() ?></h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      <article class="list-article">
        <?php if ($post_image): ?>
          <div class="list-article-feature-image m-b-2" style="background-image: url('<?php echo $post_image ?>')"></div>
        <?php endif; ?>
        <a class="list-article-title" href="<?php the_permalink(); ?>"><h2><?php the_title() ?></h2></a>
        <?php get_template_part('templates/entry-meta'); ?>
        <div class="list-article-excerpt">
        <?php the_excerpt(); ?>
        </div>
        <a class="list-article-read-more" href="<?php the_permalink(); ?>">▸ Read more</a>
      </article>

      <div class="clearfix">
        <div class="squiggle util-background-icon pull-xs-left list-article-spacer"></div>
      </div>

    <?php endwhile; else : ?>
      <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>

    <?php echo paginate_links(); ?>
  </div>
</div>
