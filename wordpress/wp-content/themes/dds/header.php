<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js ie9 ie8 ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie9 ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?> > <!--<![endif]-->

  <head>

    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="HandheldFriendly" content="true" />


    <title>
      <?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        wp_title( '|', true, 'right' );

        // Add the blog name.
        bloginfo( 'name' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";

      ?>
    </title>

    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>


