<?php $author = get_field('blue_arrow_author', get_the_ID())[0] ?>
<?php if($author): ?>
  <div class="media m-b-2 m-t-2">
    <img class="list-article-author-image d-flex m-r-2" src="<?php echo get_the_post_thumbnail_url($author, [150, 150]) ?>" alt="<?php echo $author->post_title ?>">
    <div class="media-body">
      <p class="m-b-0"><?php echo $author->post_title ?></p>
      <p class="list-article-date list-article-date-with-author"><?php the_date() ?></p>
    </div>
  </div>
<?php else: ?>
  <p class="list-article-date"><?php echo get_the_date(); ?></p>
<?php endif; ?>
