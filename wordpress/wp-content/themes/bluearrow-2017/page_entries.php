<?php /* Template Name: Entries page */ ?>
<div class="row category-page">
  <div class="col-xs-12">
    <h1><?php the_title(); ?></h1>
    <?php $categories = get_field('categories', $post->ID); ?>
    <div class="category-links">
      <?php foreach ($categories as $index => $category): ?>
        <a href="#<?php echo $category->post_name; ?>" class="category-anchor-link">
          <?php echo $category->post_title; ?>
        </a>
        <?php if (($index + 1) < count($categories)): ?>
          |
        <?php endif; ?>
      <?php endforeach; ?>
      <div class="category-spacer category-links-spacer"></div>
    </div>
    <?php echo wpautop(get_post_field('post_content', $post->ID)); ?>
    <?php foreach ($categories as $category): ?>
      <article class="category">
        <div class="category-anchor" id="<?php echo $category->post_name; ?>"></div>
        <div class="category-spacer"></div>
        <p class="category-subtitle"><?php echo get_field('subtitle', $category->ID) ?></p>
        <h2 class="category-title">
          <?php echo $category->post_title; ?>
        </h2>
        <?php
          $entries = get_field('entries', $category->ID);
        ?>
        <?php if ($entries): ?>
          <?php
            $groups = array(
              'finalists' => array(),
              'entries'   => array()
            );

            foreach( $entries as $entry ) {
              if( get_field('finalist', $entry->ID) ) {
                $groups['finalists'][] = $entry;
              } else {
                $groups['entries'][] = $entry;
              }
            }
          ?>

          <?php if (!empty($groups['finalists'])): ?>
            <h3>Finalists</h3>
            <div class="row flex-items-xs-center">
              <?php foreach ( $groups['finalists'] as $entry): ?>
                <div class="col-md-6 category-entry">
                  <img src="<?php echo get_the_post_thumbnail_url($entry) ?>" class="img-fluid category-entry-image" alt="<?php echo $entry->post_title ?>">
                  <h3 class="category-entry-name"><?php echo $entry->post_title ?></h3>
                  <div class="category-entry-short-description"><?php echo get_post_field('post_content', $entry->ID) ?></div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <h3>Entries</h3>
          <div class="row flex-items-xs-center">
            <?php foreach( $groups['entries'] as $entry ): ?>
              <div class="col-md-6 category-entry">
                <img src="<?php echo get_the_post_thumbnail_url($entry) ?>"
                     class="img-fluid category-entry-image"
                     alt="<?php echo $entry->post_title ?>">
                <h3 class="category-entry-name"><?php echo $entry->post_title ?></h3>
                <div class="category-entry-short-description"><?php echo get_post_field('post_content', $entry->ID) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
  </div>
</div>
