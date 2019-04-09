<?php
/**
 * The template for displaying 404 page not found.
 *
 *
 * @package Douceur de Soie
 */
?>

<?php
  use Bs\Helpers\TemplateHelper;

  get_header();
?>

<?php
  TemplateHelper::getPart( 'templates/content', 'header'); ?>

<?php
  TemplateHelper::getPart( 'templates/content', '404'); ?>


<?php
  get_footer();

