<?php use Roots\Sage\Titles; ?>
<?php
/**
 * Template Name: Gala page template
 */
?>
<?php while (have_posts()) : the_post(); ?>
    <div id="page-gala">

        <!--<?php get_template_part('templates/content', 'page'); ?>-->


        <div class="row mainheader">
            <div class="col-md-2 col-md-offset-1">
                <div class="rotate">
                    <h4>Be there or<br> be square</h4>
                </div>
            </div>
            <div class="col-md-7">
                <h1 class="frontpageheader">
                    The award Gala<br>May 26th <span>2016.<img src="wp-content/themes/bluearrow/dist/images/wave.svg"></span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-bluearrow">
                <img src="wp-content/themes/bluearrow/dist/images/arrowdown.svg" alt="Blue Arrow" />
            </div>
            <div class="col-md-7">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget nulla laoreet, porta elit in, vulputate dolor. Sed diam odio, pellentesque nec viverra vitae, egestas ac velit. Donec molestie ornare est ut consectetur. Vestibulum laoreet porttitor elementum. In hac habitasse platea dictumst. Aliquam tincidunt massa et dolor sollicitudin, id commodo sapien consectetur. Quisque vel finibus magna, et ultrices magna. Suspendisse at diam in massa tempus luctus quis id lectus. Fusce varius interdum felis, nec tincidunt lacus pulvinar nec.
                </p>
                <p>
                    Dresscode: Black tie
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-bluearrow">
                <img src="wp-content/themes/bluearrow/dist/images/schedule.svg" alt="Schedule" />
            </div>
            <div class="col-md-7">
                <h3>Schedule</h3>
                <ul>
                    <li>17:00 Doors open</li>
                    <li>19:00 Welcome drinks</li>
                    <li>19:30 Award ceremony begins</li>
                    <li>22:00 Afterparty</li>
                    <li>02:00 Venue closes</li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-bluearrow">
                <img src="wp-content/themes/bluearrow/dist/images/icon-venue.svg" alt="Venue" />
            </div>
            <div class="col-md-7">
                <h3>Venue</h3>
                <h2>Savoy theatre, Helsinki</h2>
                <p><a href="https://www.google.fi/maps/place/Savoy-teatteri,+Kaserngatan+46,+00130+Helsinki/@60.1667465,24.9453503,17z/">Kasarmikatu 46-48, 00130 Helsinki</a></p>
                <img class="venuemap" src="wp-content/themes/bluearrow/dist/images/map.png" alt="Venue map" />

                <h3>How to get there</h3>
                <p>Easiest way to access the venue is by public transportation or taxi. You can check your best option
                    for public transportation at <a href="http://www.reittiopas.fi">Reittiopas</a> or a taxi.
                    If you are coming with a car, the closest parking hall is
                    at <a href="https://www.q-park.fi/fi/pysakointi-q-parkissa/pysakointilaitokset/kaupunki/parkingid/1273">Q-park Kasarmitori</a>.
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-1 col-bluearrow">
                <img src="wp-content/themes/bluearrow/dist/images/icon-tickets.svg" alt="Tickets" />
            </div>
            <div class="col-md-7">
                <h3>Tickets</h3>
                <p>Tickets will be sold advance. Available tickets are very limited and the capacity for the event is 600.</p>
                <p>Ticket includes the entrance to the main award event and to the afterparty that will start right after
                the event. There are free drinks and coctail style food served at the afterparty.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-md-offset-3">
                <a href="" class="awardbutton">Buy Gala tickets 65€</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>
