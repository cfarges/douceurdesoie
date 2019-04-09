<?php
/**
 * The template for displaying all single post.
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

    <?php while ( have_posts() ) : the_post(); ?>
    
    <h1 class="page-title"><?php the_title(); ?></h1>

    <article id="article">
        <div class="wysiwyg-content">
            <?php the_content(); ?>
        </div>
    </article>

    <?php endwhile; ?>


<?php
  get_footer();