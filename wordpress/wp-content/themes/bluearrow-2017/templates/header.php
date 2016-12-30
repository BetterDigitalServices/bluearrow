<?php

$menuItems = [
  [
    'title' => 'News',
    'url' => 'news',
    'icon' => 'header-icon-news.svg'
  ],
  [
    'title' => 'Blog',
    'url' => 'blog',
    'icon' => 'header-icon-blog.svg'
  ]
]

?>

<header class="header">
    <nav class="main-nav">
      <a class="header-logo" href="<?php echo esc_url(home_url('/')); ?>"></a>
      <ul class="main-nav-links">
        <?php foreach ($menuItems as $item): ?>
        <li class="main-nav-links-item">
          <a class="main-nav-links-item-link" href="<?php echo esc_url(home_url($item['url'])); ?>">
            <div class="main-nav-links-item-icon" style="background-image: url('<?php echo get_stylesheet_directory_uri() . '/assets/images/' . $item['icon'] ?>')"></div>
            <div class="main-nav-links-item-title"><?php echo $item['title'] ?></div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>
</header>
