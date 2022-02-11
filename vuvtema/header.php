<!DOCTYPE html>
<html <?php language_attributes();?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">

    <title><?php the_title(); ?></title>
    <?php wp_head(); ?>
  </head>
  <body style="overflow-x: hidden;">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.php"><?php echo get_bloginfo(); ?></a>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php
                        $args = array(
                            'theme_location'  =>  'glavni-menu',
                            'menu_id'       =>  'vsmti-glavni-menu',
                            'menu_class'    =>  'navbar-nav ml-auto',
                            'container'     =>  'div',
                            'container_class' =>  'collapse navbar-collapse',
                            'container_id'  => 'navbarReponsive'
                        );
                        wp_nav_menu( $args );

                    ?>   
                </div>
            </div>
        </nav>    
        
        