<?php 
get_header();
$sImageUrl = get_template_directory_uri().'/img/home.jpg';
    echo '
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('.$sImageUrl.')">
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

$x=get_post_meta(get_the_ID(),'_wporg_meta_key_postaja_vozila');
$y=get_post_meta(get_the_ID(),'_wporg_meta_key_postaja_policajci');
echo DajPolicajcePostaje($y);
echo DajVozilaPostaje($x);
get_footer(); 
?>

