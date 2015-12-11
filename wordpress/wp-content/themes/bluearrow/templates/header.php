<header class="banner">
  <div class="container">
    <nav class="nav-primary navbar navbar-default navbar-fixed-top"> 
      <!--<a class="brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>-->
       

        <div class="navbar-header">
          <a class="navbar-brand" href="#">
            <h4>blue arrow</h4>
            <img alt="Blue Arrow" src="wp-content/themes/bluearrow/dist/images/arrow.png">
          </a>
        </div>
      


      
         <div class="navbar-header">
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
            <li><a href="#"><img alt="who are we?"src="wp-content/themes/bluearrow/dist/images/whoarewe.svg">who are we?</a></li>
            <li><a href="#schedule"><img alt="schedule"src="wp-content/themes/bluearrow/dist/images/schedule.svg">schedule</a></li>
            <li><a href="#jury"><img alt="jury"src="wp-content/themes/bluearrow/dist/images/jury.svg">jury</a></li>
            <li><a href="#categories"><img alt="categories"src="wp-content/themes/bluearrow/dist/images/categories.svg">categories</a></li>
            <li><a href="#contact"><img alt="contact"src="wp-content/themes/bluearrow/dist/images/contact.svg">contact</a></li>
            <li class="bluenav"><a href="#" aria-hidden="false"><span class="bluetext">Entries open 16.1.2015</span></a>  </li>
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
