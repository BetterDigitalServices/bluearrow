<?php /* Template Name: Categories page */ ?>
<div class="row">
  <div class="col-lg-8 offset-lg-2">
    <h1><?php the_title(); ?></h1>
    <?php echo wpautop(get_post_field('post_content', $post->ID)); ?>
    <?php $categories = get_field('categories', $post->ID); ?>
    <?php foreach ($categories as $category): ?>
      <h2><?php echo $category->post_title ?></h2>
      <?php echo wpautop(get_post_field('post_content', $category->ID)); ?>
      <h3>Judges</h3>
      <?php $judges = get_field('judges', $category->ID) ?>
      <div class="row">
        <?php foreach ($judges as $judge): ?>
          <div class="col-md-4">
            <img src="<?php echo get_the_post_thumbnail_url($judge) ?>" class="img-circle img-fluid" alt="<?php echo $judge->post_title ?>">
            <p><?php echo $judge->post_title ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <h3>Evaluation criteria</h3>
      <?php echo get_field('evaluation_criteria', $category->ID) ?>
    <?php endforeach; ?>
  </div>
</div>
