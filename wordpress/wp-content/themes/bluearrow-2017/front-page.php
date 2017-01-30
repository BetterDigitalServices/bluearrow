<div class="rotated">
  <span class="rotated-bold">Awards ceremony</span><br>
  April 2017<br>
  <span class="rotated-bold">Helsinki/Finland</span>
</div>
<h1 class="front-page-title">Blue Arrow. An award for <u>impact</u>.</h1>
<div class="front-page-top-section">
  <div class="row">
    <div class="col-xs-12">
      <?php echo wpautop($post->post_content); ?>
    </div>
  </div>
</div>

<?php
// ACF returns associative arrays instead of objects, let's convert the array to objects for the sake of consistency
?>
<?php $sections = json_decode(json_encode(get_field('front_page_sections', $post->ID))); ?>
<?php foreach ($sections as $section): ?>
  <?php if ($section->acf_fc_layout === 'text_section'): ?>
    <div class="row">
      <div class="front-page-section col-sm-12">
        <?php if ($section->icon): ?>
          <div class="front-page-section-icon util-background-icon" style="background-image: url('<?php echo $section->icon ?>')"></div>
        <?php else: ?>
          <div class="front-page-section-no-icon-spacer"></div>
        <?php endif; ?>
        <h2><?php echo $section->title ?></h2>
        <?php echo $section->body ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if ($section->acf_fc_layout === 'categories_section'): ?>
    <div class="row">
      <div class="front-page-section col-sm-12">
        <?php if ($section->icon): ?>
          <div class="front-page-section-icon util-background-icon" style="background-image: url('<?php echo $section->icon ?>')"></div>
        <?php else: ?>
          <div class="front-page-section-no-icon-spacer"></div>
        <?php endif; ?>
        <h2><?php echo $section->title ?></h2>
        <div class="categories-container clearfix">
          <?php foreach ($section->categories as $category): ?>
            <a class="category-box" href="/competition/#<?php echo $category->post_name ?>">
              <div class="category-box-corner"></div>
              <div class="category-box-title"><?php echo $category->post_title ?></div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endforeach; ?>

<div class="row">
  <div class="col-xs-12">
    <div class="clearfix social-media-icons-container">
      <a href="https://www.facebook.com/bluearrowawards/" class="social-media-icon" target="_blank"style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-social-media-facebook.svg' ?>')"></a>
      <a href="https://twitter.com/bluearrowawards" class="social-media-icon" target="_blank" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-social-media-twitter.svg' ?>')"></a>
      <a href="https://www.linkedin.com/groups/8465932/profileacti" class="social-media-icon" target="_blank"style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/icon-social-media-linkedin.svg' ?>')"></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="front-page-twitter-widget">
      <a class="twitter-timeline" data-height="400" data-theme="light" href="https://twitter.com/bluearrowawards">Tweets by bluearrowawards</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
  </div>
</div>
