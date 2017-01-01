<?php
$menu = [];
$menu_locations = get_nav_menu_locations();
if (isset($menu_locations['primary_navigation'])) {
  $menu = wp_get_nav_menu_items($menu_locations['primary_navigation']);
}
?>

<header class="header">
    <nav class="main-nav">
      <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>"></a>
      <ul class="main-nav-links">
        <?php foreach ($menu as $item): ?>
        <li class="main-nav-links-item">
          <a class="main-nav-links-item-link" href="<?php echo esc_url($item->url); ?>">
            <?php $icon = get_post_meta( $item->ID, 'menu-item-icon', true ); ?>
            <?php if($icon): ?>
              <div class="main-nav-links-item-icon" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $icon ?>')"></div>
            <?php else: ?>
              <div class="main-nav-links-item-icon" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/header-icon-news.svg' ?>')"></div>
            <?php endif; ?>
            <div class="main-nav-links-item-title"><?php echo $item->title ?></div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
      <div class="header-mobile-nav-button util-background-icon"></div>
    </nav>
</header>
<div class="mobile-nav-menu">
    <ul class="mobile-nav-menu-list">
        <?php foreach ($menu as $item): ?>
            <li class="mobile-nav-menu-item">
                <a class="mobile-nav-menu-item-link" href="<?php echo esc_url($item->url); ?>">
                    <?php $icon = get_post_meta( $item->ID, 'menu-item-icon', true ); ?>
                    <?php if($icon): ?>
                        <div class="mobile-nav-menu-item-icon util-background-icon" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $icon ?>')"></div>
                    <?php else: ?>
                        <div class="mobile-nav-menu-item-icon util-background-icon" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/header-icon-news.svg' ?>')"></div>
                    <?php endif; ?>
                    <div class="mobile-nav-menu-item-title"><?php echo $item->title ?></div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
