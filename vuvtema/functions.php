<?php

//INIT TEME
if ( ! function_exists( 'inicijaliziraj_temu' ) )
{
	function inicijaliziraj_temu()
	{
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		register_nav_menus( array(
			'glavni-menu' => "Glavni navigacijski izbornik",
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

	register_sidebar(
		array (
			'name' => "Footer sidebar 2",
			'id' => 'footer-sidebar2',
			'description' => "Footer sidebar 2",
			'before_widget' => '<div class="footer-sidebar">',
			'after_widget' => "</div>",
			'before_title' => '<h4 class="footer-sidebar-title">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array (
			'name' => "Footer sidebar 3",
			'id' => 'footer-sidebar3',
			'description' => "Footer sidebar 3",
			'before_widget' => '<div class="footer-sidebar">',
			'after_widget' => "</div>",
			'before_title' => '<h4 class="footer-sidebar-title">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array (
			'name' => "Footer sidebar 4",
			'id' => 'footer-sidebar4',
			'description' => "Footer sidebar 4",
			'before_widget' => '<div class="footer-sidebar">',
			'after_widget' => "</div>",
			'before_title' => '<h4 class="footer-sidebar-title">',
			'after_title' => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'aktiviraj_sidebar' );

function DajObjaveStudij()
{
	$args = array(
			'posts_per_page' => -1,
			'category_name' => 'studij'
			);

	$oResults = get_posts( $args );
	$sIstaknutaSlika = "";			
	foreach ($oResults as $oRezultat)
	{
		
		if( get_the_post_thumbnail_url($oRezultat->ID) )
		{
			$sIstaknutaSlika = get_the_post_thumbnail_url($oRezultat->ID);
		}
		else
		{
			$sIstaknutaSlika = get_template_directory_uri(). '/img/home-bg.jpg';
		}

		$sUrl = get_permalink($oRezultat->ID);
		$sRezultatNaziv = $oRezultat->post_title;
		
		$sHtml .= '
				<div class="row dvObavijesti">
					<h4><a href="'.$sUrl.'" style="cursor:pointer;">'.$sRezultatNaziv.'</a></h4>
				</div>';					
	}
	return $sHtml;
}

function DajObjaveStudenti()
{
	$args = array(
				'posts_per_page' => -1,
				'category_name' => 'studenti'
			);

	$oResults = get_posts( $args );
	$sIstaknutaSlika = "";			
	
	foreach ($oResults as $oRezultat)
	{
		
		if( get_the_post_thumbnail_url($oRezultat->ID) )
		{
			$sIstaknutaSlika = get_the_post_thumbnail_url($oRezultat->ID);
		}
		else
		{
			$sIstaknutaSlika = get_template_directory_uri(). '/img/home-bg.jpg';
		}

		$sUrl = get_permalink($oRezultat->ID);
		$sRezultatNaziv = $oRezultat->post_title;
		
		$sHtml .= '
				<div class="row dvObavijesti">
				<h4><a href="'.$sUrl.'" style="cursor:pointer;">'.$sRezultatNaziv.'</a></h4>
				</div>';					
	}
	return $sHtml;
}

function DajObjaveObavijesti()
{
	$args = array(
				'posts_per_page' => -1,
				'category_name' => 'obavijesti'
			);

	$oResults = get_posts( $args );
	$sIstaknutaSlika = "";			
	
	foreach ($oResults as $oRezultat)
	{
		
		if( get_the_post_thumbnail_url($oRezultat->ID) )
		{
			$sIstaknutaSlika = get_the_post_thumbnail_url($oRezultat->ID);
		}
		else
		{
			$sIstaknutaSlika = get_template_directory_uri(). '/img/home-bg.jpg';
		}

		$sUrl = get_permalink($oRezultat->ID);
		$sRezultatNaziv = $oRezultat->post_title;
		
		$sHtml .= '
				<div class="row dvObavijesti">
				<h4><a href="'.$sUrl.'" style="cursor:pointer;">'.$sRezultatNaziv.'</a></h4>
				</div>';					
	}
	return $sHtml;
}

//UCITAVANJE CSS DATOTEKA
function UcitajCssTeme()
{	
	wp_enqueue_style( 'clean-blog-css', get_template_directory_uri() . '/css/clean-blog.min.css' );
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
	wp_enqueue_style( 'fontawesome-css', get_template_directory_uri() . '/vendor/fontawesome-free/css/all.min.css' );
	wp_enqueue_style( 'glavni-css', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'select-css',"https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" );
}
add_action( 'wp_enqueue_scripts', 'UcitajCssTeme' );

//UCITAVANJE JS DATOTEKA
function UcitajJsTeme()
{		
	wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/vendor/bootstrap/js/bootstrap.min.js', array('jquery'), true);
	wp_enqueue_script('bootstrap-js', get_template_directory_uri().'/vendor/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), true);
	wp_enqueue_script('fontawesome-js', get_template_directory_uri().'/vendor/fontawesome-free/js/all.min.js', array('jquery'), true);
	wp_enqueue_script('jquery-js', get_template_directory_uri().'/vendor/jquery/jquery.min.js', array('jquery'), true);	
	wp_enqueue_style('clean-blog-js', get_template_directory_uri() . '/js/clean-blog.min.js' );
	wp_enqueue_script('glavni-js', get_template_directory_uri().'/js/skripta.js', array('jquery'), true);
	wp_enqueue_script('select-js', "https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js");
}
add_action( 'wp_enqueue_scripts', 'UcitajJsTeme' );


function registriraj_novi_predmet() {

	$labels = array(
		'name'                  => _x( 'predmet', 'Post Type General Name', 'vuv' ),
		'singular_name'         => _x( 'predmet', 'Post Type Singular Name', 'vuv' ),
		'menu_name'             => __( 'Predmeti', 'vuv' ),
		'name_admin_bar'        => __( 'Predmeti', 'vuv' ),
		'archives'              => __( 'Predmeti arhiva', 'vuv' ),
		'attributes'            => __( 'Atributi', 'vuv' ),
		'parent_item_colon'     => __( 'Roditeljski element', 'vuv' ),
		'all_items'             => __( 'Svi predmeti', 'vuv' ),
		'add_new_item'          => __( 'Dodaj novi predmet', 'vuv' ),
		'add_new'               => __( 'Dodaj novi', 'vuv' ),
		'new_item'              => __( 'Novi predmet', 'vuv' ),
		'edit_item'             => __( 'Uredi predmet', 'vuv' ),
		'update_item'           => __( 'Azuriraj predmet', 'vuv' ),
		'view_item'             => __( 'Pogledaj predmet', 'vuv' ),
		'view_items'            => __( 'Pogledaj predmete', 'vuv' ),
		'search_items'          => __( 'Pretrazi predmet', 'vuv' ),
		'not_found'             => __( 'Nije pronadeno', 'vuv' ),
		'not_found_in_trash'    => __( 'Nije pronadeno u smecu', 'vuv' ),
		'featured_image'        => __( 'Glavna slika', 'vuv' ),
		'set_featured_image'    => __( 'Postavi glavnu sliku', 'vuv' ),
		'remove_featured_image' => __( 'Ukloni glavnu sliku', 'vuv' ),
		'use_featured_image'    => __( 'Postavi za glavnu sliku', 'vuv' ),
		'insert_into_item'      => __( 'Umetni', 'vuv' ),
		'uploaded_to_this_item' => __( 'preneseno', 'vuv' ),
		'items_list'            => __( 'Lista', 'vuv' ),
		'items_list_navigation' => __( 'Navigacija medu predmetima', 'vuv' ),
		'filter_items_list'     => __( 'Filtriranje predmeta', 'vuv' ),
	);
	$args = array(
		'label'                 => __( 'predmet', 'vuv' ),
		'description'           => __( 'Post Type Description', 'vuv' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'taxonomies'            => array( 'godina', 'semestar' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'predmet', $args );

}
add_action( 'init', 'registriraj_novi_predmet', 0 );
function registriraj_taksonomiju() {

	$labels = array(
		'name'                       => _x( 'godine', 'Taxonomy General Name', 'vuv' ),
		'singular_name'              => _x( 'godina', 'Taxonomy Singular Name', 'vuv' ),
		'menu_name'                  => __( 'Godina', 'vuv' ),
		'all_items'                  => __( 'Sve godine', 'vuv' ),
		'parent_item'                => __( 'Raditeljska godina', 'vuv' ),
		'parent_item_colon'          => __( 'Roditeljska godina', 'vuv' ),
		'new_item_name'              => __( 'Nova godina', 'vuv' ),
		'add_new_item'               => __( 'Dodaj novu godinu', 'vuv' ),
		'edit_item'                  => __( 'Uredi godinu', 'vuv' ),
		'update_item'                => __( 'Azuriraj godinu', 'vuv' ),
		'view_item'                  => __( 'Pogledaj godinu', 'vuv' ),
		'separate_items_with_commas' => __( 'Odvojite godine zarezima', 'vuv' ),
		'add_or_remove_items'        => __( 'Dodaj ili ukloni godinu', 'vuv' ),
		'choose_from_most_used'      => __( 'Odaberi među najčešće korištenima', 'vuv' ),
		'popular_items'              => __( 'Popularne godine', 'vuv' ),
		'search_items'               => __( 'Pretraga', 'vuv' ),
		'not_found'                  => __( 'Nema rezultata', 'vuv' ),
		'no_terms'                   => __( 'Godine prazne', 'vuv' ),
		'items_list'                 => __( 'Lista godina', 'vuv' ),
		'items_list_navigation'      => __( 'Navigacija', 'vuv' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'godina', array( 'predmet' ), $args );
}
// Register Custom Taxonomy
function registriraj_taksonomiju_semestar() {

	$labels = array(
		'name'                       => _x( 'semestri', 'Taxonomy General Name', 'vuv' ),
		'singular_name'              => _x( 'semestar', 'Taxonomy Singular Name', 'vuv' ),
		'menu_name'                  => __( 'Semestri', 'vuv' ),
		'all_items'                  => __( 'Svi semestri', 'vuv' ),
		'parent_item'                => __( 'Raditeljski semestar', 'vuv' ),
		'parent_item_colon'          => __( 'Roditeljsk semestar', 'vuv' ),
		'new_item_name'              => __( 'Novi semestar', 'vuv' ),
		'add_new_item'               => __( 'Dodaj novi semestar', 'vuv' ),
		'edit_item'                  => __( 'Uredi semestar', 'vuv' ),
		'update_item'                => __( 'Azuriraj semestar', 'vuv' ),
		'view_item'                  => __( 'Pogledaj semestar', 'vuv' ),
		'separate_items_with_commas' => __( 'Odvojite semestre zarezima', 'vuv' ),
		'add_or_remove_items'        => __( 'Dodaj ili ukloni semestar', 'vuv' ),
		'choose_from_most_used'      => __( 'Odaberi među najčešće korištenima', 'vuv' ),
		'popular_items'              => __( 'Popularni semestri', 'vuv' ),
		'search_items'               => __( 'Pretraga', 'vuv' ),
		'not_found'                  => __( 'Nema rezultata', 'vuv' ),
		'no_terms'                   => __( 'Semestri prazni', 'vuv' ),
		'items_list'                 => __( 'Lista semestara', 'vuv' ),
		'items_list_navigation'      => __( 'Navigacija', 'vuv' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'semestar', array( 'predmet' ), $args );

}
add_action( 'init', 'registriraj_taksonomiju_semestar', 0 );
add_action( 'init', 'registriraj_taksonomiju', 0 );
function daj_semestre( $slug )
{
	$args = array(
	'posts_per_page' => -1,
	'post_type' => 'predmet',
	'post_status' => 'publish',
		'tax_query' => array(
			array(
			'taxonomy' => 'semestar',
			'field' => 'slug',
			'terms' => $slug
			)
		)
	);
	$nastavnici = get_posts( $args );
	$sHtml = 
	'<table class="table table-bordered">
		<thead>
			<tr>
			<th>Naziv predmeta</th>
			<th>ECTS bodova</th>
			<th>P</th>
			<th>LV</th>
			<th>KV</th>
			</tr>
		</thead>
	<tbody>
	';
	foreach ($nastavnici as $nastavnik)
	{
		$ects = get_post_meta($nastavnik->ID,'predmet_ects_bodovi',true);
		$predmet_SatiPredavanja = get_post_meta($nastavnik->ID,'predmet_sati_predavanja',true);
		$satiLabaratorijskihVjezbi = get_post_meta($nastavnik->ID,'predmet_sati_lv_vjezbi',true);
		$satiKonstrukcijskihVjezbi = get_post_meta($nastavnik->ID,'predmet_sati_kv',true);
		$sNastavnikUrl = $nastavnik->guid;
		$sNastavnikNaziv = $nastavnik->post_title;
		$sHtml .= '<td><a href="'.$sNastavnikUrl.'">'.$sNastavnikNaziv.'</a></td>';
		$sHtml .= '<td>'.$ects.'</td>';
		$sHtml .= '<td>'.$predmet_SatiPredavanja.'</td>';
		$sHtml .= '<td>'.$satiLabaratorijskihVjezbi.'</td>';
		$sHtml .= '<td>'.$satiKonstrukcijskihVjezbi.'</td></tr>';
	}
	$sHtml .= "</tbody></table>";
	return $sHtml;
}
function registriraj_nastavnik_cpt() {
	$labels = array(
	'name' => _x( 'Nastavnici', 'Post Type General Name', 'vsmti' ),
	'singular_name' => _x( 'Nastavnik', 'Post Type Singular Name', 'vsmti' ),
	'menu_name' => __( 'Nastavnici', 'vsmti' ),
	'name_admin_bar' => __( 'Nastavnici', 'vsmti' ),
	'archives' => __( 'Nastavnici arhiva', 'vsmti' ),
	'attributes' => __( 'Atributi', 'vsmti' ),
	'parent_item_colon' => __( 'Roditeljski element', 'vsmti' ),
	'all_items' => __( 'Svi nastavnici', 'vsmti' ),
	'add_new_item' => __( 'Dodaj novoga nastavnika', 'vsmti' ),
	'add_new' => __( 'Dodaj novi', 'vsmti' ),
	'new_item' => __( 'Novi nastavnik', 'vsmti' ),
	'edit_item' => __( 'Uredi nastavnika', 'vsmti' ),
	'update_item' => __( 'Ažuriraj nastavnika', 'vsmti' ),
	'view_item' => __( 'Pogledaj nastavnika', 'vsmti' ),
	'view_items' => __( 'Pogledaj nastavnike', 'vsmti' ),
	'search_items' => __( 'Pretraži nastavnike', 'vsmti' ),
	'not_found' => __( 'Nije pronađeno', 'vsmti' ),
	'not_found_in_trash' => __( 'Nije pronađeno u smeću', 'vsmti' ),
	'featured_image' => __( 'Glavna slika', 'vsmti' ),
	'set_featured_image' => __( 'Postavi glavnu sliku', 'vsmti' ),
	'remove_featured_image' => __( 'Ukloni glavnu sliku', 'vsmti' ),
	'use_featured_image' => __( 'Postavi za glavnu sliku', 'vsmti' ),
	'insert_into_item' => __( 'Umentni', 'vsmti' ),
	'uploaded_to_this_item' => __( 'Preneseno', 'vsmti' ),
	'items_list' => __( 'Lista', 'vsmti' ),
	'items_list_navigation' => __( 'Navigacija među nastanvicima', 'vsmti' ),
	'filter_items_list' => __( 'Filtriranje nastavnika', 'vsmti' ),
	);
	$args = array(
	'label' => __( 'Nastavnik', 'vsmti' ),
	'description' => __( 'Nastavnik post type', 'vsmti' ),
	'labels' => $labels,
	'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
	'hierarchical' => false,
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'menu_position' => 5,
	'menu_icon' => 'dashicons-groups',
	'show_in_admin_bar' => true,
	'show_in_nav_menus' => true,
	'can_export' => false,
	'has_archive' => true,
	'exclude_from_search' => false,
	'publicly_queryable' => true,
	'capability_type' => 'page',
	);
	register_post_type( 'nastavnik', $args );
}
add_action( 'init', 'registriraj_nastavnik_cpt', 0 );

function registriraj_taksonomiju_naslovno_zvanje() {
	$labels = array(
	'name' => _x( 'Naslovna zvanja', 'Taxonomy General Name', 'vsmti' ),
	'singular_name' => _x( 'Naslovno zvanje', 'Taxonomy Singular Name', 'vsmti' ),
	'menu_name' => __( 'Naslovna zvanja', 'vsmti' ),
	'all_items' => __( 'Sva naslovna zvanja', 'vsmti' ),
	'parent_item' => __( 'Roditeljsko zvanje', 'vsmti' ),
	'parent_item_colon' => __( 'Roditeljsko zvanje', 'vsmti' ),
	'new_item_name' => __( 'Novo naslovno zvanje', 'vsmti' ),
	'add_new_item' => __( 'Dodaj novo naslovno zvanje', 'vsmti' ),
	'edit_item' => __( 'Uredi naslovno zvanje', 'vsmti' ),
	'update_item' => __( 'Ažuiriraj naslovno zvanje', 'vsmti' ),
	'view_item' => __( 'Pogledaj naslovno zvanje', 'vsmti' ),
	'separate_items_with_commas' => __( 'Odvojite zvanja sa zarezima', 'vsmti' ),
	'add_or_remove_items' => __( 'Dodaj ili ukloni naslovno zvanje', 'vsmti' ),
	'choose_from_most_used' => __( 'Odaberi među najčešće korištenima', 'vsmti' ),
	'popular_items' => __( 'Popularna naslovna zvanja', 'vsmti' ),
	'search_items' => __( 'Pretraga', 'vsmti' ),
	'not_found' => __( 'Nema rezultata', 'vsmti' ),
	'no_terms' => __( 'Nema naslovnih zvanja', 'vsmti' ),
	'items_list' => __( 'Lista naslovnih zvanja', 'vsmti' ),
	'items_list_navigation' => __( 'Navigacija', 'vsmti' ),
	);
	$args = array(
	'labels' => $labels,
	'hierarchical' => true,
	'public' => true,
	'show_ui' => true,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'show_tagcloud' => true,
	);
	register_taxonomy( 'naslovno_zvanje', array( 'nastavnik' ), $args );
}
add_action( 'init', 'registriraj_taksonomiju_naslovno_zvanje', 0 );

function daj_nastavnike( $slug , $arr_selected)
{
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'nastavnik',
		'post_status' => 'publish',
		'tax_query' => array(
			array(
			'taxonomy' => 'naslovno_zvanje',
			'field' => 'slug',
			'terms' => $slug
			)
		)
	);
	$nastavnici = get_posts( $args );
	$sHtml = "";
	foreach ($nastavnici as $nastavnik)
	{
		foreach($arr_selected as $value){
			$sNastavnikNaziv = $nastavnik->post_title;
			if($sNastavnikNaziv == $value)
				$sHtml .= '<option selected value="'.$sNastavnikNaziv.'">'.$sNastavnikNaziv.'</option>';
			$sHtml .= $value;
			$sHtml .= '<option  value="'.$sNastavnikNaziv.'">'.$sNastavnikNaziv.'</option>';
		}
	}
	return $sHtml;
}

function add_meta_box_predmet_podatci()
{
	add_meta_box( 'vuv_predmet_info', 'Podatci predmeta', 'html_meta_box_predmet', 'predmet');
}
function html_meta_box_predmet($post)
{
	wp_nonce_field('spremi_podatke_predmeta', 'ects_bodovi_nonce');
	wp_nonce_field('spremi_podatke_predmeta', 'sati_predavanja_nonce');
	wp_nonce_field('spremi_podatke_predmeta', 'sati_lv_vjezbi_nonce');
	wp_nonce_field('spremi_podatke_predmeta', 'sati_kv_nonce');
	//dohvaćanje meta vrijednosti
	$ects_bodovi = get_post_meta($post->ID, 'predmet_ects_bodovi', true);
	$sati_predavanja = get_post_meta($post->ID, 'predmet_sati_predavanja', true);
	$sati_lv_vjezbi = get_post_meta($post->ID, 'predmet_sati_lv_vjezbi', true);
	$sati_kv = get_post_meta($post->ID, 'predmet_sati_kv', true);

	echo '
	<div>
		<div>
			<label for="predmet_ects_bodovi">Ects bodovi: </label>
			<input type="text" id="predmet_ects_bodovi"
			name="predmet_ects_bodovi" value="'.$ects_bodovi.'" />
		</div>
		
		<br/>
		
		<div>
			<label for="predmet_sati_predavanja">Sati predavanja: </label>
			<input type="text" id="predmet_sati_predavanja"
			name="predmet_sati_predavanja" value="'.$sati_predavanja.'" />
		</div>
		
		<br/>

		<div>
			<label for="predmet_sati_lv_vjezbi">Sati laboratorijskih vjezbi: </label>
			<input type="text" id="predmet_sati_lv_vjezbi"
			name="predmet_sati_lv_vjezbi" value="'.$sati_lv_vjezbi.'" />
		</div>

		<br/>
		
		<div>
			<label for="predmet_sati_kv">Sati konstrukcijskih vjezbi: </label>
			<input type="text" id="predmet_sati_kv"
			name="predmet_sati_kv" value="'.$sati_kv.'" />
		</div>
		</br>
	</div>';
}
function spremi_podatke_predmeta($post_id)
{
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );

	$is_valid_nonce_ects_bodovi = ( isset( $_POST[ 'ects_bodovi_nonce' ] ) && wp_verify_nonce(
	$_POST[ 'ects_bodovi_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
	$is_valid_nonce_sati_predavanja = ( isset( $_POST[ 'sati_predavanja_nonce' ] ) && wp_verify_nonce(
	$_POST[ 'sati_predavanja_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	$is_valid_nonce_sati_lv_vjezbi = ( isset( $_POST[ 'sati_lv_vjezbi_nonce' ] ) && wp_verify_nonce(
	$_POST[ 'sati_lv_vjezbi_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	$is_valid_nonce_sati_kv = ( isset( $_POST[ 'sati_kv_nonce' ] ) && wp_verify_nonce(
	$_POST[ 'sati_kv_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
	if ( $is_autosave || $is_revision || !$is_valid_nonce_ects_bodovi || !$is_valid_nonce_sati_predavanja || !$is_valid_nonce_sati_lv_vjezbi || !$is_valid_nonce_sati_kv ) 
	{
	return;
	}

	if(!empty($_POST['predmet_ects_bodovi']))
	{
		update_post_meta($post_id, 'predmet_ects_bodovi',
		$_POST['predmet_ects_bodovi']);
	}
	else
	{
		delete_post_meta($post_id, 'predmet_ects_bodovi');
	}

	if(!empty($_POST['predmet_sati_predavanja']))
	{
		update_post_meta($post_id, 'predmet_sati_predavanja',
		$_POST['predmet_sati_predavanja']);
	}
	else
	{
		delete_post_meta($post_id, 'predmet_sati_predavanja');
	}
		
	if(!empty($_POST['predmet_sati_lv_vjezbi']))
	{
		update_post_meta($post_id, 'predmet_sati_lv_vjezbi',
		$_POST['predmet_sati_lv_vjezbi']);
	}
	else
	{
		delete_post_meta($post_id, 'predmet_sati_lv_vjezbi');
	}

	if(!empty($_POST['predmet_sati_kv']))
	{
		update_post_meta($post_id, 'predmet_sati_kv', $_POST['predmet_sati_kv']);
	}
	else
	{
		delete_post_meta($post_id, 'predmet_sati_kv');
	}
}

function add_meta_box_nastavnici()
{
	add_meta_box( 'vuv_predmet_nastavnici', 'Nastavnici', 'html_meta_box_nastavnici', 'predmet');
}

function html_meta_box_nastavnici($post)
{
	wp_nonce_field('spremi_nastavnici_predmet', 'predmet_nastavnik_nonce');
	$nastavnici_predmeta_ids = get_post_meta($post->ID, 'nastavnici', true);
	$nastavnici_predmeta_ids = explode(',', $nastavnici_predmeta_ids);
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'nastavnik',
		'post_status' => 'publish'
	);
	$nastavnici = get_posts($args);
	echo '<script type="text/javascript">
	$(document).ready(function($) {
	$(".s2").select2(
	{
		width: "resolve",
		theme: "classic",
		placeholder: "Odaberi nastavnike"
	}
	);
	});
	</script>';
	$nastavnici_form = '<select id="mySelect" name="nastavnici[]" id="nastavnici[]" class="s2" multiple>';

	foreach($nastavnici as $nastavnik)
	{
		$selected_text = (in_array($nastavnik->ID, $nastavnici_predmeta_ids)) ? "selected" : "";
		$nastavnici_form .='<option '.$selected_text.' value="'.$nastavnik->ID.'">'.$nastavnik->post_title.'</option>';
	}
	$nastavnici_form .= '</select>';
	echo '<div>'.$nastavnici_form.'</div>';
}

function spremi_nastavnici_predmet($post_id)
{
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );

	$is_valid_nonce_titula_prefiks = ( isset( $_POST[ 'predmet_nastavnik_nonce' ] ) && wp_verify_nonce(
	$_POST[ 'predmet_nastavnik_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
	$is_valid_nonce_titula_sufiks = ( isset( $_POST[ 'predmet_nastavnik_nonce' ] ) && wp_verify_nonce(
	$_POST[ 'predmet_nastavnik_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
	if ( $is_autosave || $is_revision || !$is_valid_nonce_titula_prefiks || !$is_valid_nonce_titula_sufiks) {
	return;
	}
	if(!empty($_POST['nastavnici']))
	{
		$nastavnici = implode(",", $_POST[ 'nastavnici' ]);
		update_post_meta($post_id, 'nastavnici',$nastavnici);
	}
	else
	{
		delete_post_meta($post_id, 'nastavnici');
	}
} 
	add_action( 'add_meta_boxes', 'add_meta_box_predmet_podatci' );
	add_action( 'save_post', 'spremi_podatke_predmeta' );
	add_action( 'add_meta_boxes', 'add_meta_box_nastavnici' );
	add_action( 'save_post', 'spremi_nastavnici_predmet' );
?>