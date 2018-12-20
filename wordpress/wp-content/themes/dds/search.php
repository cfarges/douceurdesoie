<?php
/**
 * The template for displaying search results pages.
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