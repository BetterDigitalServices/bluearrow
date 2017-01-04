<?php /* Template Name: Categories page */ ?>
<div class="row category-page">
  <div class="col-xs-12">
    <h1><?php the_title(); ?></h1>
    <?php $categories = get_field('categories', $post->ID); ?>
    <div class="category-links">
      <?php foreach ($categories as $index => $category): ?>
        <a href="#<?php echo $category->post_name; ?>">
          <?php echo $category->post_title; ?>
        </a>
        <?php if (($index + 1) < count($categories)): ?>
          |
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <?php echo wpautop(get_post_field('post_content', $post->ID)); ?>
    <?php foreach ($categories as $category): ?>
      <div class="category-spacer"></div>
      <p class="category-subtitle"><?php echo get_field('subtitle', $category->ID) ?></p>
      <h2 class="category-title" id="<?php echo $category->post_name; ?>">
        <?php echo $category->post_title; ?>
      </h2>
      <?php echo wpautop(get_post_field('post_content', $category->ID)); ?>
      <?php $judge = get_field('main_judge', $category->ID)[0] ?>
      <?php if ($judge): ?>
      <div class="category-main-judge">
        <div class="category-main-judge-icon util-background-icon" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-large-judge.svg' ?>')"></div>
        <div class="category-main-judge-title">Main Judge</div>
        <div class="category-main-judge-name"><?php echo $judge->post_title ?></div>
        <img src="<?php echo get_the_post_thumbnail_url($judge) ?>" class="img-circle img-fluid category-main-judge-image" alt="<?php echo $judge->post_title ?>">
        <div class="category-main-judge-short-description"><?php echo get_post_field('short_description', $judge->ID); ?></div>
        <div class="category-main-judge-long-description"><?php echo get_post_field('long_description', $judge->ID); ?></div>
      </div>
      <?php endif; ?>
      <?php $assisting_jury = get_field('judges', $category->ID) ?>
      <?php if ($assisting_jury): ?>
        <h3 class="category-assisting-jury-title">Assisting jury</h3>
        <div class="row flex-items-xs-center">
          <?php foreach ($assisting_jury as $judge): ?>
            <div class="col-md-4 category-assisting-judge">
              <img src="<?php echo get_the_post_thumbnail_url($judge) ?>" class="img-circle img-fluid category-assisting-judge-image" alt="<?php echo $judge->post_title ?>">
              <div class="category-assisting-judge-name"><?php echo $judge->post_title ?></div>
              <div class="category-assisting-judge-short-description"><?php echo get_post_field('short_description', $judge->ID) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <h3 class="category-evaluation-criteria-title">Evaluation criteria</h3>
      <?php echo get_field('evaluation_criteria', $category->ID) ?>
    <?php endforeach; ?>
  </div>
</div>
