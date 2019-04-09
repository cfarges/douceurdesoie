<?php
/**
 * The template for displaying Home.
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
  TemplateHelper::getPart( 'templates/content', 'home'); ?>


<?php
  get_footer();

