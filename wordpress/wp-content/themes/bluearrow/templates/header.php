<header class="banner">
  <div class="container">
    <nav class="nav-primary navbar navbar-default navbar-fixed-top">
      <!--<a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>-->
      <div class="navbar-header">
        <a class="navbar-brand" href="#">
          <h4>blue arrow</h4>
          <img alt="Blue Arrow" src="wp-content/themes/bluearrow/dist/images/ba-logo.svg">
        </a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right mainnav ">
          <li><a href="/"><img alt="Frontpage" src="wp-content/themes/bluearrow/dist/images/ba-logo.svg">Frontpage</a></li>
          <li><a href="/categories/"><img alt="Categories" src="wp-content/themes/bluearrow/dist/images/categories.svg">Categories</a></li>
          <li><a href="/category/news"><img alt="News" src="wp-content/themes/bluearrow/dist/images/beawesome.svg">News</a></li>
          <li><a href="/manifesto/"><img alt="Categories" src="wp-content/themes/bluearrow/dist/images/whoarewe.svg">Manifesto</a></li>
          <!--
          <li class="dropdown">
              <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img alt="Categories" src="wp-content/themes/bluearrow/dist/images/categories.svg">Categories</a>
              <ul class="dropdown-menu">
                  <li><a href="/">Disruption award</li></li>
                  <li><a href="/">Another</li></li>
              </ul>
          </li>
          <li><a href="#schedule"><img alt="Schedule" src="wp-content/themes/bluearrow/dist/images/schedule.svg">Schedule</a></li>
          <li><a href="#gala"><img alt="Gala" src="wp-content/themes/bluearrow/dist/images/gala.svg">Gala</a></li>
          <li><a href="#jury"><img alt="Jury" src="wp-content/themes/bluearrow/dist/images/jury.svg">Jury</a></li>
          <li><a href="#contact"><img alt="contact" src="wp-content/themes/bluearrow/dist/images/contact.svg">Contact</a></li>
            -->
          <li class="bluenav"><a href="/categories/" aria-hidden="false">Entries open<br>25.1.2016</a></li>
        </ul>
      </div>

      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>
