<?php while (have_posts()) : the_post(); ?>
<div id="page-frontpage">
    <div class="row mainheader">
        <div class="col-md-2 col-md-offset-1">
            <div class="rotate">
                <h4>award ceremony
                    april 2016
                    helsinki/finland</h4>
            </div>
        </div>
        <div class="col-md-offset-3">
            <h1 class="frontpageheader">
                Blue Arrow.</br> An award </br>for <span>impact.<img src="wp-content/themes/bluearrow/dist/images/wave.svg"></span>
                <img class="bluearrow" src="wp-content/themes/bluearrow/dist/images/arrowdown.svg" alt="" />
            </h1>
        </div>
    </div>


    <?php get_template_part('templates/content', 'page'); ?>
</div>

<?php endwhile; ?>
