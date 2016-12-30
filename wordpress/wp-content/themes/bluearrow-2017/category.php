<h1><?php single_cat_title() ?></h1>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <article class="list-article">
    <a class="list-article-title" href="<?php the_permalink(); ?>"><h2><?php the_title() ?></h2></a>
    <p class="list-article-date"><?php the_date() ?></p>
    <div class="list-article-excerpt">
    <?php the_excerpt(); ?>
    </div>
    <a class="list-article-read-more" href="<?php the_permalink(); ?>">▸ Read more</a>
  </article>
<?php endwhile; else : ?>
  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
