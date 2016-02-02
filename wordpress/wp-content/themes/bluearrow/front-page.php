<?php while (have_posts()) : the_post(); ?>
<div id="page-frontpage">
    <div class="row mainheader">
        <div class="col-md-2 col-md-offset-1">
            <div class="rotate">
                <h4>award ceremony
                    may 2016
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

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="col-md-9 col-md-offset-3 socialmediaicons">
                <a href="https://www.facebook.com/bluearrowawards/">
                    <img src="wp-content/themes/bluearrow/dist/images/icon-fb.svg" alt="Blue Arrow at Facebook">
                </a>
                <a href="https://twitter.com/bluearrowawards">
                    <img src="wp-content/themes/bluearrow/dist/images/icon-twitter.svg" alt="Blue Arrow at Twitter">
                </a>
                <a href="https://www.linkedin.com/groups/8465932">
                    <img src="wp-content/themes/bluearrow/dist/images/icon-linkedin.svg" alt="Blue Arrow at LinkedIn">
                </a>
            </div>
        </div>
    </div>

    <div class="row twitterstream">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="col-md-9 col-md-offset-3" style="padding-left: 0">
                <a class="twitter-timeline" href="https://twitter.com/bluearrowawards" data-widget-id="694509091348180993">Twiittejä käyttäjältä @bluearrowawards</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>
