<?php
  // Being functions.php : All will be done in "/bs" - you don't need to write more here
  require_once dirname(__FILE__) . '/bs/bsThemeCore.class.php';
  $bsThemeCore = new bsThemeCore();
  $bsThemeCore->initTheme();
  // END functions.php


function presentation_cpt() {
    $labels = array(
        'name' => __( 'Presentation', 'Post Type General Name', 'textdomain' ),
        'menu_name' => __( 'Presentations', 'textdomain' ),
        'name_admin_bar' => __( 'Presentation', 'textdomain' ),
        'archives' => __( 'Archives presentation', 'textdomain' ),
        'attributes' => __( 'Attributs presentation', 'textdomain' ),
        'parent_item_colon' => __( 'Parents presentation:', 'textdomain' ),
        'edit_item' => __( 'Modifier présentation', 'textdomain' ),
        'update_item' => __( 'Mettre à jour la présentation', 'textdomain' ),
        'view_item' => __( 'Voir présentation', 'textdomain' ),
        'view_items' => __( 'Voir présentations', 'textdomain' ),
        'not_found' => __( 'Aucune présentation trouvée.', 'textdomain' ),
        'not_found_in_trash' => __( 'Aucune présentation retrouvée dans la corbeille.', 'textdomain' ),
        'items_list' => __( 'Liste des présentations', 'textdomain' ),
        'filter_items_list' => __( 'Filtrer la liste des présentations', 'textdomain' ),
    );
    $args = array(
        'label' => __( 'Présentation', 'textdomain' ),
        'description' => __( '', 'textdomain' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array('title', 'editor', 'revisions', 'author', 'comments', 'custom-fields', ),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type( 'presentation', $args );
}

add_action( 'init', 'presentation_cpt', 0 );

function static_slide_cpt() {
    $labels = array(
        'name' => __( 'Pain Points', 'Post Type General Name', 'textdomain' ),
        'menu_name' => __( 'Pain Points', 'textdomain' ),
        'name_admin_bar' => __( 'Pain Points', 'textdomain' ),
        'archives' => __( 'Archives pain points', 'textdomain' ),
        'attributes' => __( 'Attributs static slides', 'textdomain' ),
        'not_found' => __( 'Aucun pain point trouvé.', 'textdomain' ),
        'not_found_in_trash' => __( 'Aucun pain point retrouvé dans la corbeille.', 'textdomain' ),
        'items_list' => __( 'Liste des pain points', 'textdomain' ),
        'filter_items_list' => __( 'Filtrer la liste des pain points', 'textdomain' ),
    );
    $args = array(
        'label' => __( 'Pain points', 'textdomain' ),
        'description' => __( '', 'textdomain' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array('title', 'editor', 'revisions', 'author', 'comments', 'custom-fields', ),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );

    register_post_type( 'static_slide', $args );
}

add_action( 'init', 'static_slide_cpt', 0 );

function jobs_cpt() {
    $labels = array(
        'name' => __( 'job', 'Post Type General Name', 'textdomain' ),
        'menu_name' => __( 'Jobs', 'textdomain' ),
        'name_admin_bar' => __('Jobs', 'textdomain' ),
        'archives' => __( 'Archives jobs', 'textdomain' ),
        'attributes' => __( 'Attributs jobs', 'textdomain' ),
        'not_found' => __( 'Aucun job trouvé.', 'textdomain' ),
        'not_found_in_trash' => __( 'Aucun job retrouvé dans la corbeille.', 'textdomain' ),
        'items_list' => __( 'Liste des jobs', 'textdomain' ),
        'filter_items_list' => __( 'Filtrer la liste des jobs', 'textdomain' ),
    );
    $args = array(
        'label' => __( 'Jobs', 'textdomain' ),
        'description' => __( '', 'textdomain' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-post',
        'supports' => array('title', 'editor', 'revisions', 'author', 'comments', 'custom-fields', ),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => true,
        'show_in_rest' => true,
        'publicly_queryable' => false,
        'capability_type' => 'post',
    );

    register_post_type( 'job', $args );
}

add_action( 'init', 'jobs_cpt', 0 );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}
