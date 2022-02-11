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
            <h1>'; echo the_title(); echo'</h1>
            <span class="subheading"></span>
            </div>
        </div>
        </div>
    </div>
    </header>';

get_footer(); 
?>

