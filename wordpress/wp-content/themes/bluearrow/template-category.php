<?php use Roots\Sage\Titles; ?>
<?php
/**
 * Template Name: Category page template
 */
?>
<?php while (have_posts()) : the_post(); ?>
    <div id="page-category">
        <?php get_template_part('templates/content', 'page'); ?>

        <!--
        <div class="row mainheader">
            <div class="col-md-2 col-md-offset-1">
                <div class="rotate">
                    <h4>Best customer service award</h4>
                </div>
            </div>
            <div class="col-md-7">
                <h1 class="frontpageheader">
                    Service for<br> human<br> centered<br> <span>design.<img src="wp-content/themes/bluearrow/dist/images/wave.svg"></span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-bluearrow">
                <img src="wp-content/themes/bluearrow/dist/images/arrowdown.svg" alt="" />
            </div>
            <div class="col-md-7">
                <p>
                    This category awards the customer experience that is loved by their customers. Such services are easy and enjoyable to use; they improve the life of their users while making the best use of their time and money. At best, the user’s experience from the very beginning to the last transaction - within the application and outside of it - is so smooth that the user hardly recognises any work done. Often such services almost feel like having a soul of their own.
                </p>
                <p>
                    The service submitted can be either for consumers or business to business, it can be front office or back office.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-bluearrow">
                <img class="judgeimg" alt="" src="http://lh3.googleusercontent.com/u_lrd45SgU50zyOzIMAam2DVuLhaVtFNAk1Qyw3h1JYp4wHor4PFRJfEJiGz9RkUIk6MU7e8HOJzoGwT90-BIEoamsQRK9pLqw=s300">
            </div>
            <div class="col-md-7 judgeinfo">
                <h3>Main judge</h3>
                <h2>Marina Vahtola</h2>
                <h4>Hallitusammattilainen, Executive in Residence, Aalto-yliopiston kauppakorkeakoulu</h4>
                <hr>
                <p>
                    Hallitusammattilainen Marina Vahtola toimii tällä hetkellä Executive in Residence -tehtävässä Aalto-yliopiston markkinoinnin laitoksella, useissa suomalaisten yritysten hallituksissa sekä senior adviser -tehtävissä isoissa kansainvälisissä ketjuohjausyrityksissä. Lisäksi hänellä on lukuisia luottamustehtäviä kotimaassa ja kansainvälisesti.
                </p>
                <p>
                    Vahtolalla on yli 25 vuoden kokemus suurten yritysten ylimmän johdon tehtävistä, joista yli 10 vuotta hän on toiminut toimitusjohtajana mm. Suomen ja Viron Bauhausissa. Vahtolan erikoisalueita ovat brändi- ja konseptiosaaminen sekä verkkokauppojen ja ketjuohjauksen kehittäminen erityisesti vähittäiskaupan alalla.
                </p>
            </div>
        </div>
        <div class="row assistjudges">
            <h3>Assisting judges</h3>
            <div class="col-md-2 col-md-offset-2">
                <img class="judgeimg" alt="" src="http://lh3.googleusercontent.com/u_lrd45SgU50zyOzIMAam2DVuLhaVtFNAk1Qyw3h1JYp4wHor4PFRJfEJiGz9RkUIk6MU7e8HOJzoGwT90-BIEoamsQRK9pLqw=s300">
                <h2>Karri-Pekka Laakso</h2>
                <h4>Reaktor</h4>
            </div>
            <div class="col-md-2">
                <img class="judgeimg" alt="" src="http://lh3.googleusercontent.com/u_lrd45SgU50zyOzIMAam2DVuLhaVtFNAk1Qyw3h1JYp4wHor4PFRJfEJiGz9RkUIk6MU7e8HOJzoGwT90-BIEoamsQRK9pLqw=s300">
                <h2>Virve Kuorelahti</h2>
                <h4>Gofore</h4>
            </div>
            <div class="col-md-2">
                <img class="judgeimg" alt="" src="http://lh3.googleusercontent.com/u_lrd45SgU50zyOzIMAam2DVuLhaVtFNAk1Qyw3h1JYp4wHor4PFRJfEJiGz9RkUIk6MU7e8HOJzoGwT90-BIEoamsQRK9pLqw=s300">
                <h2>Juha Jauhiainen</h2>
                <h4>Exove</h4>
            </div>
            <div class="col-md-2">
                <img class="judgeimg" alt="" src="http://lh3.googleusercontent.com/u_lrd45SgU50zyOzIMAam2DVuLhaVtFNAk1Qyw3h1JYp4wHor4PFRJfEJiGz9RkUIk6MU7e8HOJzoGwT90-BIEoamsQRK9pLqw=s300">
                <h2>Lassi Liikkanen</h2>
                <h4>SC5</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-md-offset-3">
                <h3>Judging criteria</h3>
                <ul>
                    <li>How easy the service is to use</li>
                    <li>How much the service improves the lives of users</li>
                    <li>How relevant is the service for the users</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-md-offset-3">
                <a href="#" class="awardbutton">Apply for this award</a>
            </div>
        </div>
        <div class="row separator">
            <div class="col-md-8 col-md-offset-2 separator">
            </div>
        </div>
        -->
    </div>
<?php endwhile; ?>
