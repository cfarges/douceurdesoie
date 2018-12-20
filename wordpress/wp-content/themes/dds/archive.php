<?php
/**
 * The template for displaying archive page.
 *
 *
 * @package Theme name to replace
 */
?>

<?php
  use Bs\Helpers\TemplateHelper;

  get_header();
?>

<?php
  TemplateHelper::getPart( 'templates/content', 'header'); ?>

<?php
  //TemplateHelper::getPart( 'templates/content', 'search'); ?>


<?php
  get_footer();