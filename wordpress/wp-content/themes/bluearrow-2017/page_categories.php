<?php /* Template Name: Categories page */ ?>
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
        <?php echo wpautop(get_post_field('post_content', $category->ID)); ?>
        <?php $judge = get_field('main_judge', $category->ID)[0] ?>
        <?php if ($judge): ?>
        <div class="category-main-judge">
          <div class="row category-main-judge-header">
            <div class="col-md-3">
              <img src="<?php echo get_the_post_thumbnail_url($judge) ?>" class="img-circle img-fluid category-main-judge-image" alt="<?php echo $judge->post_title ?>">
            </div>
            <div class="col-md-9 category-main-judge-details-wrapper">
              <div class="category-main-judge-details">
                <div class="category-main-judge-title">Main Judge</div>
                <div class="category-main-judge-name"><?php echo $judge->post_title ?></div>
                <div class="category-main-judge-short-description"><?php echo get_post_field('short_description', $judge->ID); ?></div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <?php $assisting_jury = get_field('judges', $category->ID) ?>
        <?php if ($assisting_jury): ?>
          <h3 class="category-assisting-jury-title">Jury</h3>
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
        <div class="row flex-items-xs-center">
          <div class="col-md-12 category-actions">
            <a class="btn btn-primary" href="<?php echo $category->submission_link; ?>">Submit your entry</a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</div>
