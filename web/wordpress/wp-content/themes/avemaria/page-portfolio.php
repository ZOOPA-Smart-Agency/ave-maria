<?php
/**
 * Template Name: Portfolio
 *
 * @package Ave_Maria
 */

get_header();
$pid = get_the_ID();

$portfolio_query = new WP_Query([
    'post_type'      => 'avemaria_proyecto',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
]);

$fallback_cards = [
    ['title' => 'Proyecto Alpha', 'cat' => 'impresion'],
    ['title' => 'Proyecto Beta', 'cat' => 'parches'],
    ['title' => 'Proyecto Gamma', 'cat' => 'marcado'],
    ['title' => 'Proyecto Delta', 'cat' => 'impresion'],
    ['title' => 'Proyecto Epsilon', 'cat' => 'parches'],
    ['title' => 'Proyecto Zeta', 'cat' => 'marcado'],
    ['title' => 'Proyecto Eta', 'cat' => 'impresion'],
    ['title' => 'Proyecto Theta', 'cat' => 'parches'],
    ['title' => 'Proyecto Iota', 'cat' => 'marcado'],
    ['title' => 'Proyecto Kappa', 'cat' => 'impresion'],
    ['title' => 'Proyecto Lambda', 'cat' => 'parches'],
    ['title' => 'Proyecto Mu', 'cat' => 'marcado'],
];

$badge_labels = [
    'impresion' => avemaria_field('pf_pill_imp', $pid, 'Impresión'),
    'parches'   => avemaria_field('pf_pill_par', $pid, 'Parches'),
    'marcado'   => avemaria_field('pf_pill_mar', $pid, 'Marcado'),
];
?>

    <?php avemaria_page_hero(get_the_title(), ['green_word' => 'Portfolio']); ?>

    <section class="portfolio-filters">
        <div class="portfolio-filters__container">
            <div class="portfolio-filters__header" data-animate="fadeInUp">
                <p class="section-label section-label--center"><?php echo esc_html(avemaria_field('pf_filters_label', $pid, 'Explora por categoría')); ?></p>
                <h2 class="section-title section-title--light portfolio-filters__title"><?php echo wp_kses_post(avemaria_field('pf_filters_title', $pid, 'Selecciona una categoría para <span class="text-green">filtrar</span> el trabajo')); ?></h2>
            </div>
            <div class="portfolio-filters__pills" role="tablist" aria-label="<?php echo esc_attr(avemaria_t('Filtros de portfolio')); ?>" data-animate="fadeInUp" data-delay="1">
                <button type="button" class="portfolio-filters__pill is-active" data-filter="todos" role="tab" aria-selected="true"><?php echo esc_html(avemaria_field('pf_pill_all', $pid, 'Todos')); ?></button>
                <button type="button" class="portfolio-filters__pill" data-filter="impresion" role="tab" aria-selected="false"><?php echo esc_html($badge_labels['impresion']); ?></button>
                <button type="button" class="portfolio-filters__pill" data-filter="parches" role="tab" aria-selected="false"><?php echo esc_html($badge_labels['parches']); ?></button>
                <button type="button" class="portfolio-filters__pill" data-filter="marcado" role="tab" aria-selected="false"><?php echo esc_html($badge_labels['marcado']); ?></button>
            </div>

        <div class="portfolio-grid" data-animate="fadeInUp">
            <?php
            if ($portfolio_query->have_posts()) :
                $d = 0;
                while ($portfolio_query->have_posts()) :
                    $portfolio_query->the_post();
                    $d++;
                    $terms = get_the_terms(get_the_ID(), 'avemaria_cat_proyecto');
                    $cat   = 'impresion';
                    $badge_text = $badge_labels['impresion'];
                    if (!empty($terms) && !is_wp_error($terms)) {
                        $badge_text = $terms[0]->name;
                        $slug       = $terms[0]->slug;
                        if (strpos($slug, 'parche') !== false) {
                            $cat = 'parches';
                        } elseif (strpos($slug, 'marcad') !== false || strpos($slug, 'marcaje') !== false) {
                            $cat = 'marcado';
                        } elseif (strpos($slug, 'impres') !== false) {
                            $cat = 'impresion';
                        }
                    }
                    ?>
                    <article class="portfolio-card" data-category="<?php echo esc_attr($cat); ?>" data-animate="fadeInUp" data-delay="<?php echo esc_attr(min($d, 12)); ?>">
                        <div class="portfolio-card__visual" aria-hidden="true">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'portfolio-card__img']); ?>
                            <?php else : ?>
                                <svg class="portfolio-card__icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true"><rect x="8" y="8" width="32" height="32" rx="4"/><path d="M16 20h16M16 28h10"/></svg>
                            <?php endif; ?>
                        </div>
                        <div class="portfolio-card__content">
                            <span class="portfolio-card__category"><?php echo esc_html($badge_text); ?></span>
                            <h3 class="portfolio-card__title"><?php the_title(); ?></h3>
                        </div>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                foreach ($fallback_cards as $i => $card) :
                    $cat = $card['cat'];
                    ?>
                    <article class="portfolio-card" data-category="<?php echo esc_attr($cat); ?>" data-animate="fadeInUp" data-delay="<?php echo esc_attr($i + 1); ?>">
                        <div class="portfolio-card__visual" aria-hidden="true">
                            <svg class="portfolio-card__icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true"><rect x="8" y="8" width="32" height="32" rx="4"/><path d="M16 20h16M16 28h10"/></svg>
                        </div>
                        <div class="portfolio-card__content">
                            <span class="portfolio-card__category"><?php echo esc_html($badge_labels[$cat]); ?></span>
                            <h3 class="portfolio-card__title"><?php echo esc_html($card['title']); ?></h3>
                        </div>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
        </div>
    </section>

    <section class="case-study">
        <div class="case-study__container">
            <div class="case-study__content" data-animate="fadeInLeft">
                <p class="section-label section-label--dark"><?php echo esc_html(avemaria_field('pf_case_label', $pid, 'Caso destacado')); ?></p>
                <h2 class="section-title"><?php echo wp_kses_post(avemaria_field('pf_case_title', $pid, 'De la idea a la <span class="text-green">prenda terminada</span>')); ?></h2>
                <div class="case-study__details">
                    <?php
                    $details = [
                        ['cli_label', 'cli_text', 'Cliente'],
                        ['obj_label', 'obj_text', 'Objetivo'],
                        ['sol_label', 'sol_text', 'Solución'],
                        ['tec_label', 'tec_text', 'Técnicas'],
                        ['res_label', 'res_text', 'Resultado'],
                    ];
                    foreach ($details as $d) : ?>
                        <div class="case-study__detail">
                            <span class="case-study__detail-label"><?php echo esc_html(avemaria_field("pf_case_{$d[0]}", $pid, $d[2])); ?></span>
                            <p class="case-study__detail-text"><?php echo esc_html(avemaria_field("pf_case_{$d[1]}", $pid, '')); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="case-study__divider" aria-hidden="true"></div>
                <p class="case-study__quote"><?php echo esc_html(avemaria_field('pf_case_quote', $pid, '')); ?></p>
            </div>
            <div class="case-study__visual" data-animate="fadeInRight" aria-hidden="true">
                <div class="case-study__visual-accent"></div>
                <div class="case-study__visual-inner">
                    <svg class="case-study__visual-icon" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true">
                        <path d="M24 4l6 12h14l-11 8 4 14-13-9-13 9 4-14L4 16h14z"/>
                    </svg>
                    <span class="case-study__visual-text"><?php echo esc_html(avemaria_field('pf_case_badge', $pid, 'Caso de éxito')); ?></span>
                </div>
            </div>
        </div>
    </section>

    <?php avemaria_cta_final(); ?>

<style>.portfolio-filters__title { text-align: center; }</style>
<script>
(function () {
    var pills = document.querySelectorAll('.portfolio-filters__pill');
    var cards = document.querySelectorAll('.portfolio-card');
    if (!pills.length || !cards.length) return;

    function setActive(filter) {
        pills.forEach(function (btn) {
            var on = btn.getAttribute('data-filter') === filter;
            btn.classList.toggle('is-active', on);
            btn.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        cards.forEach(function (card) {
            var cat = card.getAttribute('data-category') || '';
            var show = filter === 'todos' || cat === filter;
            card.hidden = !show;
            card.style.display = show ? '' : 'none';
        });
    }

    pills.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var f = btn.getAttribute('data-filter') || 'todos';
            setActive(f);
        });
    });
})();
</script>

<?php get_footer(); ?>
