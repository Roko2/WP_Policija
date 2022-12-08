<?php

add_filter('wp_mail_smtp_custom_options', function( $phpmailer ) {
	$phpmailer->SMTPOptions = array(
		'ssl' => array(
			'verify_peer'       => false,
			'verify_peer_name'  => false,
			'allow_self_signed' => true
		)
	);

	return $phpmailer;
} );

//INIT TEME
if ( ! function_exists( 'inicijaliziraj_temu' ) )
{
	function inicijaliziraj_temu()
	{
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		register_nav_menus( array(
			'glavni-menu' => "Glavni izbornik",
			'sporedni-menu' => "Izbornik u podnožju",
		) );
		add_theme_support( 'custom-background', apply_filters
			(
				'test_custom_background_args', array
				(
					'default-color' => 'ffffff',
					'default-image' => '',
				) 	
			) 
		);
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
}
add_action( 'after_setup_theme', 'inicijaliziraj_temu' );

//SIDEBAR ZA NOVOSTI
function aktiviraj_sidebar()
{
	register_sidebar(
		array (
			'name' => "Glavni sidebar",
			'id' => 'glavni-sidebar',
			'description' => "Glavni sidebar",
			'before_widget' => '<div class="widget-content">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		)
	);

	register_sidebar(
		array (
			'name' => "Footer sidebar 1",
			'id' => 'footer-sidebar1',
			'description' => "Footer sidebar 1",
			'before_widget' => '<div class="footer-sidebar">',
			'after_widget' => "</div>",
			'before_title' => '<h4 class="footer-sidebar-title">',
			'after_title' => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'aktiviraj_sidebar' );

function DajSvaVozila(){
	$rbr=0;
	$args = array(
			'posts_per_page' => -1,
			'post_type' => 'vozilo'
			);
	$query = new WP_Query($args);
	echo '<div class="container w-75"><h2 class="text-center">Prikaz svih vozila</h2>
		<p><strong>Legenda:</strong> 
		<canvas id="crveniCanvas"></canvas> istekla registracija
		<canvas id="zeleniCanvas"></canvas> nije istekla registracija
	</p>';
	if ($query->have_posts() ) : 
		echo '<div class="w-100 mx-auto vozilaContainer"><table id="tableVozila" class="table table-hover table-striped text-white mt-5 w-100">
				<thead>
					<tr>
						<th>Rbr.</th>
						<th>Naziv</th>
						<th>Registracijska oznaka</th>
						<th>Datum registracije</th>
						<th>Produlji registraciju</th>
					</tr>	
				</thead><tbody class="text-center">';
		while ( $query->have_posts() ) : $query->the_post();
		$terms = wp_get_post_terms( $query->post->ID, array( 'cinovi') );
		echo'<tr>
				<td>'.++$rbr.'.</td>
				<td>'.get_the_title().'</td>
				<td>'. get_post_meta( $query->post->ID, '_wporg_meta_key_vozila', true ).'</td>
				<td class="datumRegistracije" value="'.get_post_meta( $query->post->ID, '_wporg_meta_key_vozila_registracija', true ).'">'. date('j.n.Y', strtotime(get_post_meta( $query->post->ID, '_wporg_meta_key_vozila_registracija', true ))).'</td>
				<td><button class="btn btn-success btn3d" onclick="ModalRegistracija('."'".$query->post->ID."'".','."'".$query->post->post_title."'".')"><i aria-hidden="true" class="fa fa-cog fa-spin"></i></button></td>
			</tr>';
		endwhile;
		echo '</tbody></table>
		<div class="text-left text-black mt-2"><b class="text-danger">NAPOMENA: </b>Ukoliko je gumb na zelenom vozilu omogućen, znači da je unutar mjesec dana do isteka registracije te se može produljiti prije isteka.</div></div></div>';
		echo '<script>$("#tableVozila").DataTable({
			width:"75%"		
		});
	 </script>';
		wp_reset_postdata();
	endif;
}

function DajSvePolicajce()
{
	$rbr=0;
	$args = array(
			'posts_per_page' => -1,
			'post_type' => 'policajac'
			);
	$query = new WP_Query($args);
	if ($query->have_posts() ) : 
		echo '<h2 class="text-center">Prikaz svih policajaca</h2>';	
		echo '<div class="row">';
		while ( $query->have_posts() ) : $query->the_post();
		$terms = wp_get_post_terms( $query->post->ID, array( 'cinovi') );
		echo'<div class="col-md-3 m-5">
			<div class="card">
				<div class="card-body text-black">
					<h5 class="card-title">'.get_the_title().' ('.$terms[0]->name.')</h5>
					<p class="card-text">'. get_post_meta( $query->post->ID, '_wporg_meta_key_policajac', true ).'</p>
					<a href='.$query->post->guid.' class="btn btn-primary">Detalji</a>
					<button title="Unaprijedi policajca" onclick="DajSelectCinovi('.$query->post->ID.')" class="btn btn-success btn3d pull-right"><span><i class="fa fa-plus-square"></i></span></button>
				</div>
			</div>
		  </div>';
		endwhile;
		echo '</div>';
		wp_reset_postdata();
	endif;
}
function DajSinglePolicajca($idPolicajca){ 
		echo '<h2 class="text-center">Podaci o policajcu</h2>';	
		echo '<div class="row text-center mt-5">
		<div class="col-md-4">
			<h4 class="podnasloviPolicajac">
			Osnovni
			</h4>
			<div class="mt-4 osnovniPodaci">
				Ime i prezime: '.get_the_title().'<br><br>
				Datum rođenja: '.date('j.n.Y', strtotime(get_post_meta( $idPolicajca, '_wporg_meta_key_policajac_datum_rodjenja', true ))).'<br><br>
				Broj telefona: '.get_post_meta( $idPolicajca, '_wporg_meta_key_policajac_telefon', true ).'
			</div>
		</div>	
		<div class="col-md-4">
			<h4 class="podnasloviPolicajac">Napredni</h4>
			<div class="mt-4 osnovniPodaci">
				Čin: '.get_the_terms($idPolicajca,'cinovi')[0]->name.'<br><br>
				Vrsta službe: '.get_the_terms($idPolicajca,'vrstaSluzbe')[0]->name.'<br><br>
				Godina staža: '.get_post_meta($idPolicajca, '_wporg_meta_key_policajac_godinaStaza', true ).'
			</div>
		</div>
		<div class="col-md-4">
		<div class="d-flex align-items-center justify-content-center ">
			<h4 class="m-2 podnasloviPolicajac d-inline">Stručno usavršavanje</h4>';
			if(get_post_meta($idPolicajca, '_wporg_meta_key_policajac_radio')[0]=='0'){
				echo '<button data-bs-toggle="modal" data-bs-target="#modalUsavrsavanje" title="Klikni za stručno usavršavanje" class="pushable">
				<span class="shadow"></span>
				<span class="edge"></span>
				<span class="front">
					 <i class="fa fa-plus-square"></i>
				</span>
				</button>';
			   }
		echo '</div><div class="mt-4 text-left">';
			if(get_post_meta($idPolicajca, '_wporg_meta_key_policajac_radio')[0]=='0'){
				echo 'Policajac nije obavio stručno usavršavanje za trenutnu godinu';
			   }else{
				  echo 'Datum stručnog usavršavanja: '.date('j.n.Y', strtotime(get_post_meta( $idPolicajca, '_wporg_meta_key_policajac_datum', true ))).' <br><br>
				  		 Tema seminara: '.get_post_meta($idPolicajca, '_wporg_meta_key_policajac_tema', true ).'';
				   }
		echo '</div>
		</div>
		</div>';
		wp_reset_postdata();
}
function DajPolicajcePostaje($policajac){ 
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'policajac'
	);          
	$query = new WP_Query( $args );
	$count=0;
	$postojiPolicajac=false;
	echo '<h2 class="text-center">Prikaz svih policajaca u označenoj postaji</h2>
		<div class="row">';
	while ( $query->have_posts() ) : $query->the_post();
	$terms = wp_get_post_terms( $query->post->ID, array( 'cinovi') );
		if(strval($query->post->ID)==$policajac[0][$count]){
				echo '<div class="col-md-3 m-5">
				<div class="card">
					<div class="card-body text-black">
						<p class="card-text">'.$query->post->post_title.' ('.$terms[0]->name.')</p>
						<a href='.$query->post->guid.' class="btn btn-primary">Detalji</a>
					</div>
				</div>
			  </div>';
			  $count++;
			  $postojiPolicajac=true;
		}
		endwhile;
		if($postojiPolicajac==false){
			echo '<div class="text-center mt-5 h5">U ovoj postaji ne postoji niti jedan policajac!</div>';
		}
		echo '</div>';

}
function DajVozilaPostaje($vozilo){
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'vozilo'
	);          
	$query = new WP_Query( $args );
	$count=0;
	$postojiVozilo=false;
	echo '<h2 class="text-center">Prikaz svih vozila u označenoj postaji</h2>
		<div class="row">
		<div class="accordion accordion-flush w-75 mx-auto mt-4" id="accordionFlushExample">';
	while ( $query->have_posts() ) : $query->the_post();
		if(strval($query->post->ID)==$vozilo[0][$count]){
				echo '<div class="accordion-item">
				  <h2 class="accordion-header" id="flush-heading'.$count.'">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'.$count.'" aria-expanded="false" aria-controls="flush-collapse'.$count.'">
					 '.get_the_title().'
					</button>
				  </h2>
				  <div id="flush-collapse'.$count.'" class="accordion-collapse collapse" aria-labelledby="flush-heading'.$count.'" data-bs-parent="#accordionFlushExample">
					<div class="accordion-body text-black text-left"><b><h5>Specifikacije: </h5></b><br>'.get_post_meta($query->post->ID, '_wporg_meta_key_vozila_opis', true ).'</div>
				  </div>
				</div>';
			  $count++;
			  $postojiVozilo=true;
		}
		endwhile;
		if($postojiVozilo==false){
			echo '<div class="text-center mt-5 h5">U ovoj postaji ne postoji niti jedno vozilo!</div>';
		}
		echo '</div></div>';
}
add_action('wp_ajax_selectPolicajci', 'selectPolicajci');

function selectPolicajci()
{
	$terms = get_terms( array(
		'taxonomy' => 'cinovi',
		'hide_empty' => false,
	) );
   echo '<select class="form-select">';
   $cin=wp_get_post_terms( $_POST['idPolicajca'], array( 'cinovi') );
	foreach($terms as $value){
		if($cin[0]->term_id==$value->term_id){$postoji= "selected";} else {$postoji= "";}
		echo '<option '.$postoji.'>'.$value->name.'</option>';
	}
   echo '</select>';
    wp_die();
}

add_action('wp_ajax_usavrsiPolicajca', 'usavrsiPolicajca');
function usavrsiPolicajca(){
	update_post_meta($_POST['idPolicajca'], '_wporg_meta_key_policajac_datum', $_POST['datumUsavrsavanja']);
	update_post_meta($_POST['idPolicajca'], '_wporg_meta_key_policajac_tema', $_POST['temaSeminara']);
	update_post_meta($_POST['idPolicajca'], '_wporg_meta_key_policajac_radio', "1");
	wp_die();
}

add_action('wp_ajax_updateVozilo', 'updateVozilo');
function updateVozilo(){
	$datumRegistracije = get_post_meta( $_POST['idVozila'], '_wporg_meta_key_vozila_registracija', TRUE );
	$stop_date = date('Y-m-d');
	// $stop_date = date('Y-m-d', strtotime($stop_date . ' +1 day'));
	update_post_meta($_POST['idVozila'], '_wporg_meta_key_vozila_registracija', $stop_date);
	DajSvaVozila();
	wp_die();
}
add_action('wp_ajax_selectCinovi', 'selectCinovi');
function selectCinovi(){
	$cinovi= get_terms( array(
        'taxonomy' => 'cinovi',
        'hide_empty' => false,
      ) );
     echo '<select class="form-select mt-4" id="selectCinovi"><option value="" selected>Odaberite</option>';
      foreach($cinovi as $cin){
		  if($cin->description==$_POST['idVrstaSluzbe']){
      	 echo '<option value="'.$cin->term_id.'">'.$cin->name.'</option>';
		  }
      }      
      echo '</select>';
	  wp_die();
    }

add_action('wp_ajax_updatePolicajca', 'updatePolicajca');
function updatePolicajca(){
	$arg1=get_term_by( 'ID',$_POST['vrstaSluzbe'], 'vrstaSluzbe' );
	$arg2=get_term_by( 'ID',$_POST['cin'], 'cinovi' );
	 wp_set_object_terms( $_POST['idPolicajca'], $arg1->name, 'vrstaSluzbe', false );
	 wp_set_object_terms( $_POST['idPolicajca'], $arg2->name, 'cinovi', false );
	 echo $arg1->name;
	 echo $arg2->name;
	wp_die();
}
function DajSvePostaje(){
	$rbr=1;
	$args = array(
			'posts_per_page' => -1,
			'post_type' => 'postaja'
			);
	$query = new WP_Query($args);
	if ($query->have_posts() ) : 
		echo '<h2 class="text-center">Prikaz svih postaja</h2>';	
		echo '<div class="row">';
		while ( $query->have_posts() ) : $query->the_post();
		$terms = wp_get_post_terms( $query->post->ID, array( 'zupanija') );
		echo'<div class="col-md-3 m-5">
			<a href='.$query->post->guid.'>
			<div class="card cardPostaje h-100">
			<img class="card-img-top" src="'.get_template_directory_uri().'/img/slika'.$rbr.'">
				<div class="card-body text-black">
					<h5 class="card-title">'.get_the_title().'</h5>
					<small>('.$terms[0]->name.')</small>
				</div>
			</div>
			</a>
		  </div>';
		  $rbr++;
		endwhile;
		echo '</div>';
		wp_reset_postdata();
	endif;
}
//UCITAVANJE CSS DATOTEKA
function UcitajCssTeme()
{	
	wp_enqueue_style( 'clean-blog-css', get_template_directory_uri() . '/css/clean-blog.min.css' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.min.css' );
	wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() . '/node_modules/fontawesome-free/css/all.min.css' );
	wp_enqueue_style( 'glavni-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'datatables',"https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.css" );

}
add_action( 'wp_enqueue_scripts', 'UcitajCssTeme' );

function admin_enqueue_scripts_callback(){

    //Add the Select2 CSS file
    wp_enqueue_style( 'select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0');

    //Add the Select2 JavaScript file
    wp_enqueue_script( 'select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', 'jquery', '4.1.0-rc.0');

    //Add a JavaScript file to initialize the Select2 elements
    wp_enqueue_script( 'select2-init', '/wp-content/plugins/select-2-tutorial/select2-init.js', 'jquery', '4.1.0-rc.0');

}
add_action( 'admin_enqueue_scripts', 'admin_enqueue_scripts_callback' );
//UCITAVANJE JS DATOTEKA
function UcitajJsTeme()
{	
	wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/node_modules/bootstrap/dist/js/bootstrap.min.js', array('jquery'), true);
	wp_enqueue_script('fontawesome-js', get_template_directory_uri().'/node_modules/fontawesome-free/js/all.min.js', array('jquery'), true);
	wp_enqueue_script('jquery-js1', get_template_directory_uri().'/node_modules/jquery/jquery.min.js', array('jquery'), true);
	wp_enqueue_script('jquery-js3', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'), true);	
	wp_enqueue_style('clean-blog-js', get_template_directory_uri() . '/node_modules/js/clean-blog.min.js' );
	wp_enqueue_script('glavni-js', get_template_directory_uri().'/node_modules/js/skripta.js', array('jquery'), true);
	wp_enqueue_script('datatables', "https://cdn.datatables.net/v/dt/dt-1.11.4/datatables.min.js");

}
add_action( 'wp_enqueue_scripts', 'UcitajJsTeme' );


add_action('init',function(){
	register_post_type('policajac',[
		'name' => _x( 'Policajac', 'Post Type General Name', 'vuv' ),
		'singular_name' => _x( 'Policajac', 'Post Type Singular Name', 'vuv' ),
		'menu_name' => __( 'Policajci', 'vuv' ),
		'name_admin_bar' => __( 'Policajci', 'vuv' ),
		'archives' => __( 'Policajci arhiva', 'vuv' ),
		'attributes' => __( 'Atributi', 'vuv' ),
		'parent_item_colon' => __( 'Roditeljski element', 'vuv' ),
		'all_items' => __( 'Svi policajci', 'vuv' ),
		'add_new_item' => __( 'Dodaj novog policajca', 'vuv' ),
		'taxonomies' => ['cinovi','vrstaSluzbe'],
		'add_new' => __( 'Dodaj novi', 'vuv' ),
		'new_item' => __( 'Novi policajac', 'vuv' ),
		'edit_item' => __( 'Uredi policajca', 'vuv' ),
		'update_item' => __( 'Ažuriraj policajca', 'vuv' ),
		'view_item' => __( 'Pogledaj policajca', 'vuv' ),
		'view_items' => __( 'Pogledaj policajca', 'vuv' ),
		'search_items' => __( 'Pretraži policajce', 'vuv' ),
		'not_found' => __( 'Nije pronađeno', 'vuv' ),
		'not_found_in_trash' => __( 'Nije pronađeno u smeću', 'vuv' ),
		'featured_image' => __( 'Glavna slika', 'vuv' ),
		'set_featured_image' => __( 'Postavi glavnu sliku', 'vuv' ),
		'remove_featured_image' => __( 'Ukloni glavnu sliku', 'vuv' ),
		'use_featured_image' => __( 'Postavi za glavnu sliku', 'vuv' ),
		'insert_into_item' => __( 'Umentni', 'vuv' ),
		'uploaded_to_this_item' => __( 'Preneseno', 'vuv' ),
		'items_list' => __( 'Lista', 'vuv' ),
		'items_list_navigation' => __( 'Navigacija među postajama', 'vuv' ),
		'filter_items_list' => __( 'Filtriranje postaje', 'vuv' ),
	]);
		$args = array(
		'label' => __( 'Policajac', 'vuv' ),
		'description' => __( 'Policajac post type', 'vuv' ),
		'labels' => $labels,
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-businessman',
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => false,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'page',
		);
		register_post_type( 'policajac', $args );
	register_taxonomy('cinovi', ['policajac'], [
		'label' => __('Činovi', 'vuv'),
		'hierarchical' => true,
		'rewrite' => ['slug' => 'cin-policajca'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Čin', 'vuv'),
			'all_items' => __('Svi činovi', 'vuv'),
			'edit_item' => __('Uredi čin', 'vuv'),
			'view_item' => __('Pogledaj čin', 'vuv'),
			'update_item' => __('Ažuriraj čin', 'vuv'),
			'add_new_item' => __('Dodaj novi čin', 'vuv'),
			'new_item_name' => __('Novo ime čina', 'vuv'),
			'search_items' => __('Pretraži činove', 'vuv'),
			'parent_item' => __('Čin roditelj', 'vuv'),
			'parent_item_colon' => __('Čin roditelj:', 'vuv'),
			'not_found' => __('Nijedan čin pronađen', 'vuv'),
		]
	]);
	register_taxonomy_for_object_type('cinovi', 'policajac');

	register_taxonomy('vrstaSluzbe', ['sluzba'], [
		'label' => __('Vrsta službe', 'vuv'),
		'hierarchical' => true,
		'rewrite' => ['slug' => 'vrsta-sluzbe'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Vrsta službe', 'vuv'),
			'all_items' => __('Sve vrste službi', 'vuv'),
			'edit_item' => __('Uredi vrstu službe', 'vuv'),
			'view_item' => __('Pogledaj vrstu službe', 'vuv'),
			'update_item' => __('Ažuriraj vrstu službe', 'vuv'),
			'add_new_item' => __('Dodaj novu vrstu službe', 'vuv'),
			'new_item_name' => __('Novo ime vrste službe', 'vuv'),
			'search_items' => __('Pretraži vrstu službe', 'vuv'),
			'parent_item' => __('Vrsta službe roditelj', 'vuv'),
			'parent_item_colon' => __('Vrsta službe roditelj:', 'vuv'),
			'not_found' => __('Nijedna vrsta službe pronađena', 'vuv'),
		]
	]);
	register_taxonomy_for_object_type('vrstaSluzbe', 'policajac');
 
});

add_action('init',function(){
	register_post_type('postaja',[
		'name' => _x( 'Postaje', 'Post Type General Name', 'vuv' ),
		'singular_name' => _x( 'Postaja', 'Post Type Singular Name', 'vuv' ),
		'menu_name' => __( 'Postaje', 'vuv' ),
		'name_admin_bar' => __( 'Postaje', 'vuv' ),
		'archives' => __( 'Postaje arhiva', 'vuv' ),
		'attributes' => __( 'Atributi', 'vuv' ),
		'parent_item_colon' => __( 'Roditeljski element', 'vuv' ),
		'all_items' => __( 'Sve postaje', 'vuv' ),
		'add_new_item' => __( 'Dodaj novu postaju', 'vuv' ),
		'taxonomies' => ['zupanija'],
		'add_new' => __( 'Dodaj novi', 'vuv' ),
		'new_item' => __( 'Nova postaja', 'vuv' ),
		'edit_item' => __( 'Uredi postaju', 'vuv' ),
		'update_item' => __( 'Ažuriraj postaju', 'vuv' ),
		'view_item' => __( 'Pogledaj postaju', 'vuv' ),
		'view_items' => __( 'Pogledaj postaju', 'vuv' ),
		'search_items' => __( 'Pretraži postaje', 'vuv' ),
		'not_found' => __( 'Nije pronađeno', 'vuv' ),
		'not_found_in_trash' => __( 'Nije pronađeno u smeću', 'vuv' ),
		'featured_image' => __( 'Glavna slika', 'vuv' ),
		'set_featured_image' => __( 'Postavi glavnu sliku', 'vuv' ),
		'remove_featured_image' => __( 'Ukloni glavnu sliku', 'vuv' ),
		'use_featured_image' => __( 'Postavi za glavnu sliku', 'vuv' ),
		'insert_into_item' => __( 'Umentni', 'vuv' ),
		'uploaded_to_this_item' => __( 'Preneseno', 'vuv' ),
		'items_list' => __( 'Lista', 'vuv' ),
		'items_list_navigation' => __( 'Navigacija među postajama', 'vuv' ),
		'filter_items_list' => __( 'Filtriranje postaje', 'vuv' ),
	]);
		$args = array(
		'label' => __( 'Postaja', 'vuv' ),
		'description' => __( 'Postaja post type', 'vuv' ),
		'labels' => $labels,
		'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-admin-multisite',
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => false,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'page',
		);
		register_post_type( 'postaja', $args );
	register_taxonomy('zupanija', ['postaja'], [
		'label' => __('Županije', 'vuv'),
		'hierarchical' => true,
		'rewrite' => ['slug' => 'zupanija-postaje'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Županija', 'vuv'),
			'all_items' => __('Sve županije', 'vuv'),
			'edit_item' => __('Uredi županiju', 'vuv'),
			'view_item' => __('Pogledaj županiju', 'vuv'),
			'update_item' => __('Ažuriraj županiju', 'vuv'),
			'add_new_item' => __('Dodaj novu županiju', 'vuv'),
			'new_item_name' => __('Novo ime županije', 'vuv'),
			'search_items' => __('Pretraži županije', 'vuv'),
			'parent_item' => __('županije roditelj', 'vuv'),
			'parent_item_colon' => __('županije roditelj:', 'vuv'),
			'not_found' => __('Nijedna županije pronađena', 'vuv'),
		]
	]);
	register_taxonomy_for_object_type('zupanija', 'postaja');
}); 

add_action('init', function() {
	register_post_type('vozilo', [
	'name' => _x( 'Vozila', 'Post Type General Name', 'vuv' ),
	'singular_name' => _x( 'Vozilo', 'Post Type Singular Name', 'vuv' ),
	'menu_name' => __( 'Vozila', 'vuv' ),
	'name_admin_bar' => __( 'Vozila', 'vuv' ),
	'archives' => __( 'Vozila arhiva', 'vuv' ),
	'attributes' => __( 'Atributi', 'vuv' ),
	'parent_item_colon' => __( 'Roditeljski element', 'vuv' ),
	'all_items' => __( 'Sva vozila', 'vuv' ),
	'add_new_item' => __( 'Dodaj novo vozilo', 'vuv' ),
	'add_new' => __( 'Dodaj novi', 'vuv' ),
	'new_item' => __( 'Novo vozilo', 'vuv' ),
	'edit_item' => __( 'Uredi vozilo', 'vuv' ),
	'update_item' => __( 'Ažuriraj vozilo', 'vuv' ),
	'view_item' => __( 'Pogledaj vozilo', 'vuv' ),
	'view_items' => __( 'Pogledaj vozilo', 'vuv' ),
	'search_items' => __( 'Pretraži vozilo', 'vuv' ),
	'not_found' => __( 'Nije pronađeno', 'vuv' ),
	'not_found_in_trash' => __( 'Nije pronađeno u smeću', 'vuv' ),
	'featured_image' => __( 'Glavna slika', 'vuv' ),
	'set_featured_image' => __( 'Postavi glavnu sliku', 'vuv' ),
	'remove_featured_image' => __( 'Ukloni glavnu sliku', 'vuv' ),
	'use_featured_image' => __( 'Postavi za glavnu sliku', 'vuv' ),
	'insert_into_item' => __( 'Umentni', 'vuv' ),
	'uploaded_to_this_item' => __( 'Preneseno', 'vuv' ),
	'items_list' => __( 'Lista', 'vuv' ),
	'items_list_navigation' => __( 'Navigacija među vozilima', 'vuv' ),
	'filter_items_list' => __( 'Filtriranje vozila', 'vuv' ),
	]);
	$args = array(
	'label' => __( 'Vozilo', 'vuv' ),
	'description' => __( 'Vozilo post type', 'vuv' ),
	'labels' => $labels,
	'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
	'hierarchical' => false,
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'menu_position' => 6,
	'menu_icon' => 'dashicons-car',
	'show_in_admin_bar' => true,
	'show_in_nav_menus' => true,
	'can_export' => false,
	'has_archive' => true,
	'exclude_from_search' => false,
	'publicly_queryable' => true,
	'capability_type' => 'page',
	);
	register_post_type( 'vozilo', $args );
register_taxonomy('kategorijaVozila', ['vozilo'], [
	'label' => __('Kategorije', 'vuv'),
	'hierarchical' => true,
	'rewrite' => ['slug' => 'kategorija-vozila'],
	'show_admin_column' => true,
	'show_in_rest' => true,
	'labels' => [
		'singular_name' => __('Kategorija', 'vuv'),
		'all_items' => __('Sve kategorije', 'vuv'),
		'edit_item' => __('Uredi kategoriju', 'vuv'),
		'view_item' => __('Pogledaj kategoriju', 'vuv'),
		'update_item' => __('Ažuriraj kategoriju', 'vuv'),
		'add_new_item' => __('Dodaj novu kategoriju', 'vuv'),
		'new_item_name' => __('Novo ime kategorije', 'vuv'),
		'search_items' => __('Pretraži kategorije', 'vuv'),
		'parent_item' => __('kategorija roditelj', 'vuv'),
		'parent_item_colon' => __('kategorija roditelj:', 'vuv'),
		'not_found' => __('Nijedna kategorija pronađena', 'vuv'),
	]
]);
register_taxonomy_for_object_type('kategorijaVozila', 'vozilo');
});

function wporg_add_custom_box() {
    $screens = [ 'post', 'policajac' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id_policajac',                 // Unique ID
            'Opis	',      // Box title
            'wporg_custom_box_html_policajac',  // Content callback, must be of type callable
            $screen                            // Post type
        );
		add_meta_box(
			'wporg_box_id_policajac_radio',
			'Obavljeno stručno usavršavanje',
			'wporg_custom_box_html_policajac_radio',
			$screen
		);
		add_meta_box(
			'wporg_box_id_policajac_datum',
			'Datum obavljanja stručnog usavrašavanja',
			'wporg_custom_box_html_policajac_datum',
			$screen
		);
		add_meta_box(
			'wporg_box_id_policajac_datum_rodjenja',
			'Datum rođenja',
			'wporg_custom_box_html_policajac_datum_rodjenja',
			$screen
		);
		add_meta_box(
			'wporg_box_id_policajac_telefon',
			'Broj telefona',
			'wporg_custom_box_html_policajac_telefon',
			$screen
		);
		add_meta_box(
			'wporg_box_id_policajac_tema',
			'Tema seminara',
			'wporg_custom_box_html_policajac_tema',
			$screen
		);
		add_meta_box(
			'wporg_box_id_policajac_godinaStaza',
			'Godina staža',
			'wporg_custom_box_html_policajac_godinaStaza',
			$screen
		);
    }
	$vozila=['post','vozilo'];
	foreach ( $vozila as $x ) {
        add_meta_box(
            'wporg_box_id_vozila',                 // Unique ID
            'Registracijska oznaka	',      // Box title
            'wporg_custom_box_html_vozila',  // Content callback, must be of type callable
            $x                            // Post type
        );
		add_meta_box(
            'wporg_box_id_vozila_registracija',                 // Unique ID
            'Registracija vozila',      // Box title
            'wporg_custom_box_html_vozila_registracija',  // Content callback, must be of type callable
            $x                            // Post type
        );
		add_meta_box(
            'wporg_box_id_vozila_opis',                 // Unique ID
            'Specifikacije vozila',      // Box title
            'wporg_custom_box_html_vozila_opis',  // Content callback, must be of type callable
            $x                            // Post type
        );
    }
	$postaja=['post','postaja'];
	foreach ( $postaja as $y ) {
        add_meta_box(
            'wporg_box_id_postaja',                 // Unique ID
            'Policajci postaje',      // Box title
            'wporg_custom_box_html_postaja_policajci',  // Content callback, must be of type callable
            $y                            // Post type
        );
		add_meta_box(
            'wporg_box_id_postaja_vozila',                 // Unique ID
            'Vozila postaje',      // Box title
            'wporg_custom_box_html_postaja_vozila',  // Content callback, must be of type callable
             $y                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html_policajac( $post ) {
	 $policajac = get_post_meta( $post->ID, '_wporg_meta_key_policajac', true );
    ?>
	<textarea id="wporg_field_policajac" name="wporg_field_policajac" placeholder="Unesi opis policajca"><?php echo $policajac ?></textarea>
    <?php
}
function wporg_custom_box_html_postaja_policajci( $post ) {
	$policajciPostaje = get_post_meta($post->ID, '_wporg_meta_key_postaja_policajci', true);
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'policajac'
	);              
	$the_query = new WP_Query( $args );
	   ?>
   <select id="wporg_field_postaja_policajci" name="wporg_field_postaja_policajci[]" multiple>
	   <?php
			   if($the_query->have_posts() ) : 
				   while ( $the_query->have_posts() ) : 
					  $the_query->the_post(); 
					  $postoji=(in_array($the_query->post->ID, $policajciPostaje)) ? "selected" : "";
					  echo '<option value="'.$the_query->post->ID.'" '.$postoji.'>'.get_the_title().'</option>';
				   endwhile; 
				   wp_reset_postdata(); 
			   else: 
			   endif;
	   ?>
   </select>
   <?php
   echo '<script type="text/javascript">
   (function($) {
	$("#wporg_field_postaja_policajci").select2();
})(jQuery);
	</script>';
}
function wporg_custom_box_html_postaja_vozila( $post ) {
	$vozilaPostaje = get_post_meta($post->ID, '_wporg_meta_key_postaja_vozila', true);
	$vozila=array(
		'posts_per_page' => -1,
		'post_type' => 'vozilo'
	);           
	$the_query = new WP_Query( $vozila );
	   ?>
   <select id="wporg_field_postaja_vozila" name="wporg_field_postaja_vozila[]" multiple>
	   <?php
			   if($the_query->have_posts() ) : 
				   while ( $the_query->have_posts() ) : 
					  $the_query->the_post(); 
					  $postoji=(in_array($the_query->post->ID, $vozilaPostaje)) ? "selected" : "";
					  echo '<option value="'.$the_query->post->ID.'" '.$postoji.'>'.get_the_title().'</option>';
				   endwhile; 
				   wp_reset_postdata(); 
			   else: 
			   endif;
	   ?>
   </select>
   <?php
   echo '<script type="text/javascript">
   (function($) {
	$("#wporg_field_postaja_vozila").select2();
})(jQuery);
	</script>';
}
function ModalUnaprijedi($idPolicajca){
	$terms = get_terms( array(
		'taxonomy' => 'cinovi',
		'hide_empty' => false,
	) );
	$termPolicajca = wp_get_object_terms( $idPolicajca, 'cinovi' );
}

function wporg_custom_box_html_vozila( $post ) {
	 $vozilo = get_post_meta( $post->ID, '_wporg_meta_key_vozila', true );
    ?>
	<input type="text" value="<?php echo $vozilo ?>" id="wporg_field_vozila" name="wporg_field_vozila" placeholder="Unesi registracijsku oznaku vozila"></input>
    <?php
}
function wporg_custom_box_html_vozila_opis( $post ) {
	$voziloOpis = get_post_meta( $post->ID, '_wporg_meta_key_vozila_opis', true );
   ?>
   <textarea rows="10" style="width:800px !important" type="text"  id="wporg_field_vozila_opis" name="wporg_field_vozila_opis" placeholder="Specifikacije vozila"><?php echo $voziloOpis ?></textarea>
   <?php
}
function wporg_custom_box_html_vozila_registracija( $post ) {
	$voziloRegistracija = get_post_meta( $post->ID, '_wporg_meta_key_vozila_registracija', true );
   ?>
   <input type="date" value="<?php echo $voziloRegistracija ?>" id="wporg_field_vozila_registracija" name="wporg_field_vozila_registracija"></input>
   <?php
}
function wporg_custom_box_html_policajac_radio( $post ) {
	$policajacRadio = get_post_meta( $post->ID, '_wporg_meta_key_policajac_radio', true );
   ?>
	<?php if($policajacRadio=="1"){
		?>
   
   <label for="wporg_field_policajac_radio">Da</label>
   <input type="radio" id="wporg_field_policajac_radio1" name="wporg_field_policajac_radio" value="1" checked>
   <label for="wporg_field_policajac_radio">Ne</label>
   <input type="radio" id="wporg_field_policajac_radio2" name="wporg_field_policajac_radio" value="0">
	<?php
	}
	else{?>
   <label for="wporg_field_policajac_radio">Da</label>
   <input type="radio" id="wporg_field_policajac_radio1" name="wporg_field_policajac_radio" value="1">
   <label for="wporg_field_policajac_radio">Ne</label>
   <input type="radio" id="wporg_field_policajac_radio2" name="wporg_field_policajac_radio" value="0" checked>
	<?php }
	 ?>

   <?php
}

function wporg_custom_box_html_policajac_datum( $post ) {
	$policajacDatum = get_post_meta( $post->ID, '_wporg_meta_key_policajac_datum', true );
   ?>
   <input type="date" value="<?php echo $policajacDatum ?>" id="wporg_field_policajac_datum" name="wporg_field_policajac_datum"></input>
   <?php
}
function wporg_custom_box_html_policajac_datum_rodjenja( $post ) {
	$policajacDatumRodjenja = get_post_meta( $post->ID, '_wporg_meta_key_policajac_datum_rodjenja', true );
   ?>
   <input type="date" value="<?php echo $policajacDatumRodjenja ?>" id="wporg_field_policajac_datum_rodjenja" name="wporg_field_policajac_datum_rodjenja"></input>
   <?php
}
function wporg_custom_box_html_policajac_telefon( $post ) {
	$policajacTelefon = get_post_meta( $post->ID, '_wporg_meta_key_policajac_telefon', true );
   ?>
   <input type="tel" placeholder="000-000-0000" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value="<?php echo $policajacTelefon ?>" id="wporg_field_policajac_telefon" name="wporg_field_policajac_telefon"></input>
   <?php
}
function wporg_custom_box_html_policajac_godinaStaza( $post ) {
	$policajacGodinaStaza = get_post_meta( $post->ID, '_wporg_meta_key_policajac_godinaStaza', true );
   ?>
   <input min="0" max="41" type="number" value="<?php if($policajacGodinaStaza==null || $policajacGodinaStaza==""){echo 0;}else{echo $policajacGodinaStaza;} ?>" id="wporg_field_policajac_godinaStaza" name="wporg_field_policajac_godinaStaza"></input>
   <?php
}

function wporg_custom_box_html_policajac_tema( $post ) {
	$policajacTema = get_post_meta( $post->ID, '_wporg_meta_key_policajac_tema', true );
   ?>
   <input type="text" value="<?php echo $policajacTema ?>" id="wporg_field_policajac_tema" name="wporg_field_policajac_tema" placeholder="Unesi temu seminara"></input>
   <?php
}

function wporg_save_postdata( $post_id ) {
    if ( array_key_exists( 'wporg_field_policajac', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac',
            $_POST['wporg_field_policajac']
        );
    }
	if ( array_key_exists( 'wporg_field_vozila', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_vozila',
            $_POST['wporg_field_vozila']
        );
    }
	if ( array_key_exists( 'wporg_field_postaja_policajci', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_postaja_policajci',
            $_POST['wporg_field_postaja_policajci']
        );
    }
	if ( array_key_exists( 'wporg_field_postaja_vozila', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_postaja_vozila',
            $_POST['wporg_field_postaja_vozila']
        );
    }
	if ( array_key_exists( 'wporg_field_vozila_registracija', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_vozila_registracija',
            $_POST['wporg_field_vozila_registracija']
        );
    }
	if ( array_key_exists( 'wporg_field_vozila_opis', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_vozila_opis',
            $_POST['wporg_field_vozila_opis']
        );
    }
	if ( array_key_exists( 'wporg_field_policajac_radio', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac_radio',
            $_POST['wporg_field_policajac_radio']
        );
    }
	if ( array_key_exists( 'wporg_field_policajac_godinaStaza', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac_godinaStaza',
            $_POST['wporg_field_policajac_godinaStaza']
        );
		}
		if ( array_key_exists( 'wporg_field_policajac_datum', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac_datum',
            $_POST['wporg_field_policajac_datum']
        );
    }
	if ( array_key_exists( 'wporg_field_policajac_telefon', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac_telefon',
            $_POST['wporg_field_policajac_telefon']
        );
    }
	if ( array_key_exists( 'wporg_field_policajac_datum_rodjenja', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac_datum_rodjenja',
            $_POST['wporg_field_policajac_datum_rodjenja']
        );
    }
	if ( array_key_exists( 'wporg_field_policajac_tema', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key_policajac_tema',
            $_POST['wporg_field_policajac_tema']
        );
    }
}
add_action( 'save_post', 'wporg_save_postdata' );

?>