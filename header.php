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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    
    <title class="text-white">Policija</title>
    <?php wp_head(); ?>
  </head>
  <body style="overflow-x: hidden;">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo home_url('/') ?>">Naslovna</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarResponsive" aria-expanded="false" aria-controls="navbarResponsive">
                <span class="navbar-toggler-icon"></span>
                </button>
                    <?php
                        $args = array(
                            'theme_location'  =>  'glavni-menu',
                            'menu_id'       =>  'vuv-glavni-menu',
                            'menu_class'    =>  'navbar-nav ml-auto',
                            'container'     =>  'div',
                            'container_class' =>  'collapse navbar-collapse',
                            'container_id'  => 'navbarResponsive'
                        );
                        wp_nav_menu( $args );
                    ?>   
            </div>
        </nav>    
