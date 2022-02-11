 <?php 
    get_header();
    $posts;
    if ( have_posts() )
    {
        while ( have_posts() )
        {
            the_post();
            $ects = get_post_meta($post->ID,'predmet_ects_bodovi',true);
            $predmet_SatiPredavanja = get_post_meta($post->ID,'predmet_sati_predavanja',true);
            $satiLabaratorijskihVjezbi = get_post_meta($post->ID,'predmet_sati_lv_vjezbi',true);
            $satiKonstrukcijskihVjezbi = get_post_meta($post->ID,'predmet_sati_kv',true);
            $nastavnici = get_post_meta($post->ID,'nastavnici',true);
        }
    };
    $sImageUrl = get_template_directory_uri().'/img/home-bg.jpg';
    echo '
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('.$sImageUrl.')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
            <h2>'; echo the_title(); echo '</h2>
            <h3> ECTS: '. $ects.'</h3>
            <h3> Predavanja: '. $predmet_SatiPredavanja.'</h3>
            <h3> Labaratorijske vježbe: '. $satiLabaratorijskihVjezbi.'</h3>
            <h3> Konstrukcijske vježbe: '. $satiKonstrukcijskihVjezbi.'</h3>
            <span class="subheading"></span>
            </div>
        </div>
        </div>
    </div>
    </header>';

    $args = array(
        'post_type' => 'nastavnik',
        'post__in' => array_map('intval', explode(',', $nastavnici))
    );
    $postsNastavnik = get_posts($args);

    foreach ($postsNastavnik as $p){
        echo '<div>';
        echo '<a href="'.$p->guid.'">'.$p->post_title .'</a>';
        echo '</div>';
    }
    
    get_footer(); 
?> 