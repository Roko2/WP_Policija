<?php
    get_header();

    $sImageUrl = get_template_directory_uri().'/img/home-bg.jpg';
    echo '
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('.$sImageUrl.')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
            <h1>Predmeti</h1>
            <span class="subheading"></span>
            </div>
        </div>
        </div>
    </div>
    </header>';
    echo '<div class="container">';
    echo '<h2>1. Godina</h2>';
    echo '<h2>I semestar</h2>';
    echo daj_semestre( 'prvi-semestar' );
    echo '<h2>II semestar</h2>';
    echo daj_semestre( 'drugi-semestar' );
    echo '<br>';
    echo '<h2>2. Godina</h2>';
    echo '<h2>II semestar</h2>';
    echo daj_semestre( 'treci-semestar' );
    echo '<h2>IV semestar</h2>';
    echo daj_semestre( 'cetvrti-semestar' );
    echo '<br>';
    echo '<h2>3. Godina</h2>';
    echo '<h2>V semestar</h2>';
    echo daj_semestre( 'peti-semestar' );
    echo '<h2>VI semestar</h2>';
    echo daj_semestre( 'sesti-semestar' );
    echo '</div>';
    get_footer();
?>