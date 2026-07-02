<?php
/**
 * Fallback template
 *
 * @package Ave_Maria
 */

get_header();
?>

<section class="page-hero">
    <div class="page-hero__container">
        <?php if (is_archive()) : ?>
            <h1 class="page-hero__title"><?php the_archive_title(); ?></h1>
        <?php elseif (is_search()) : ?>
            <h1 class="page-hero__title"><?php printf(__('Resultados: %s', 'avemaria'), get_search_query()); ?></h1>
        <?php else : ?>
            <h1 class="page-hero__title"><?php the_title(); ?></h1>
        <?php endif; ?>
    </div>
</section>

<div style="max-width: var(--max-w); margin: 0 auto; padding: 80px 40px;">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article>
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php avemaria_cta_final(); ?>
<?php get_footer(); ?>
