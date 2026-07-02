<?php
/**
 * Template Name: Styleguide
 * ---------------------------------------------------
 * Página interna de documentación visual del design system.
 * Muestra tokens, playground de botones y playground de textos.
 * ---------------------------------------------------
 *
 * @package Ave_Maria
 */

defined('ABSPATH') || exit;

get_header();

// Datos reutilizables
$paleta_colores = [
    ['--color-green',      '#00c92c', 'Green'],
    ['--color-green-light','#00e032', 'Green Light'],
    ['--color-dark',       '#0B1829', 'Dark'],
    ['--color-dark-deep',  '#000000', 'Dark Deep'],
    ['--color-navy',       '#0D1F3C', 'Navy'],
    ['--color-gray-dark',  '#2D2D2D', 'Gray Dark'],
    ['--color-gray-mid',   '#4a4a4a', 'Gray Mid'],
    ['--color-gray-light', '#e8e8e8', 'Gray Light'],
    ['--color-white',      '#ffffff', 'White'],
];

$escala_spacing = [
    ['--space-1',  4],   ['--space-2',  8],   ['--space-3',  12],
    ['--space-4',  16],  ['--space-5',  20],  ['--space-6',  24],
    ['--space-8',  32],  ['--space-10', 40],  ['--space-12', 48],
    ['--space-16', 64],  ['--space-20', 80],  ['--space-24', 96],
    ['--space-30', 120],
];

$escala_radius = [
    ['--radius-sm',   4],
    ['--radius-md',   8],
    ['--radius-lg',   12],
    ['--radius-xl',   24],
    ['--radius-full', 9999],
];

$niveles_texto = [
    'display' => [
        'size'        => 'clamp(36px, 5vw, 64px)',
        'descripcion' => 'Títulos grandes · heros · section titles',
        'default_tag' => 'h2',
    ],
    'title' => [
        'size'        => '20px',
        'descripcion' => 'Subtítulos · card titles · destacados',
        'default_tag' => 'h3',
    ],
    'body' => [
        'size'        => '16px',
        'descripcion' => 'Párrafos · descripciones · labels (con mod. label)',
        'default_tag' => 'p',
    ],
];
?>

<main class="sg" id="sg-root">
    <div class="sg__container">

        <!-- ============ HEADER ============ -->
        <header class="sg__header">
            <h1>Fundació Ave Maria — Design System</h1>
            <p>Guía visual e interactiva de tokens y componentes. Trabajo en progreso.</p>
            <nav class="sg__toc">
                <a href="#tokens">1. Tokens</a>
                <a href="#buttons">2. Botones · Playground</a>
                <a href="#typography">3. Tipografía · Playground</a>
            </nav>
        </header>


        <!-- ============================================
             SECCIÓN 1 — TOKENS
             ============================================ -->
        <section class="sg-section" id="tokens">
            <h2 class="sg-section__title">Tokens</h2>
            <p class="sg-section__subtitle">Variables base del sistema. Todos los componentes consumen de aquí.</p>

            <div class="sg-tokens">

                <!-- Colores -->
                <div class="sg-tokens__group">
                    <h3 class="sg-tokens__group-title">Colors</h3>
                    <?php foreach ($paleta_colores as $c) :
                        [$token, $hex, $name] = $c; ?>
                        <div class="sg-color">
                            <span class="sg-color__swatch" style="background: <?php echo esc_attr($hex); ?>;"></span>
                            <span class="sg-color__name"><?php echo esc_html($name); ?></span>
                            <span class="sg-color__hex"><?php echo esc_html($hex); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Spacing -->
                <div class="sg-tokens__group">
                    <h3 class="sg-tokens__group-title">Spacing</h3>
                    <?php foreach ($escala_spacing as $s) :
                        [$token, $px] = $s; ?>
                        <div class="sg-space">
                            <span class="sg-space__name"><?php echo esc_html($token); ?></span>
                            <span class="sg-space__bar" style="width: <?php echo (int) $px; ?>px;"></span>
                            <span class="sg-space__name"><?php echo (int) $px; ?>px</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Radius -->
                <div class="sg-tokens__group">
                    <h3 class="sg-tokens__group-title">Radius</h3>
                    <?php foreach ($escala_radius as $r) :
                        [$token, $px] = $r; ?>
                        <div class="sg-radius">
                            <span class="sg-radius__box" style="border-radius: <?php echo (int) $px; ?>px;"></span>
                            <span class="sg-radius__label"><?php echo esc_html($token); ?> · <?php echo (int) $px; ?>px</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Shadows -->
                <div class="sg-tokens__group">
                    <h3 class="sg-tokens__group-title">Shadows</h3>
                    <div class="sg-shadow" style="box-shadow: var(--shadow-sm);">shadow-sm</div>
                    <div class="sg-shadow" style="box-shadow: var(--shadow-md);">shadow-md</div>
                    <div class="sg-shadow" style="box-shadow: var(--shadow-lg);">shadow-lg</div>
                    <div class="sg-shadow" style="box-shadow: var(--shadow-xl);">shadow-xl</div>
                    <div class="sg-shadow" style="box-shadow: var(--shadow-glow);">shadow-glow</div>
                </div>

            </div>
        </section>


        <!-- ============================================
             SECCIÓN 2 — BOTONES · PLAYGROUND
             ============================================ -->
        <section class="sg-section" id="buttons">
            <h2 class="sg-section__title">Botones</h2>
            <p class="sg-section__subtitle">Juega con las props y copia el código resultante.</p>

            <div class="sg-playground" data-sg-playground="button">

                <!-- Controls -->
                <div class="sg-controls">
                    <div class="sg-control">
                        <label class="sg-control__label" for="btn-texto">Texto</label>
                        <input type="text" id="btn-texto" data-sg-input="texto" value="Contáctanos">
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Variante</span>
                        <div class="sg-control__options" data-sg-group="variante">
                            <button class="sg-chip is-active" data-sg-value="primary">Primary</button>
                            <button class="sg-chip" data-sg-value="secondary">Secondary</button>
                            <button class="sg-chip" data-sg-value="ghost">Ghost</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Tamaño</span>
                        <div class="sg-control__options" data-sg-group="tamano">
                            <button class="sg-chip" data-sg-value="sm">SM</button>
                            <button class="sg-chip is-active" data-sg-value="md">MD</button>
                            <button class="sg-chip" data-sg-value="lg">LG</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Tipo</span>
                        <div class="sg-control__options" data-sg-group="tipo">
                            <button class="sg-chip is-active" data-sg-value="a">Enlace &lt;a&gt;</button>
                            <button class="sg-chip" data-sg-value="button">Botón</button>
                            <button class="sg-chip" data-sg-value="submit">Submit</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Opciones</span>
                        <label class="sg-switch">
                            <input type="checkbox" data-sg-toggle="icono">
                            Mostrar icono →
                        </label>
                        <label class="sg-switch">
                            <input type="checkbox" data-sg-toggle="disabled">
                            Disabled
                        </label>
                    </div>
                </div>

                <!-- Preview + Code -->
                <div class="sg-preview">
                    <div class="sg-preview__stage" data-sg-stage="button">
                        <!-- el JS renderiza aquí -->
                        <?php get_template_part('template-parts/components/button', null, [
                            'texto'    => 'Contáctanos',
                            'enlace'   => '#',
                            'variante' => 'primary',
                            'tamano'   => 'md',
                        ]); ?>
                    </div>

                    <div class="sg-code">
                        <button class="sg-code__copy" data-sg-copy>Copiar</button>
                        <pre class="sg-code__pre" data-sg-code="button"></pre>
                    </div>
                </div>
            </div>

            <!-- Galería de variantes -->
            <div class="sg-gallery">
                <h3 class="sg-gallery__title">Todas las variantes</h3>

                <div class="sg-gallery__row">
                    <span class="sg-gallery__label">Primary</span>
                    <?php foreach (['sm','md','lg'] as $t) {
                        get_template_part('template-parts/components/button', null, [
                            'texto' => 'Contáctanos', 'enlace' => '#', 'variante' => 'primary', 'tamano' => $t,
                        ]);
                    } ?>
                    <?php get_template_part('template-parts/components/button', null, [
                        'texto' => 'Con icono', 'enlace' => '#', 'variante' => 'primary', 'tamano' => 'md', 'icono' => true,
                    ]); ?>
                </div>

                <div class="sg-gallery__row">
                    <span class="sg-gallery__label">Secondary</span>
                    <?php foreach (['sm','md','lg'] as $t) {
                        get_template_part('template-parts/components/button', null, [
                            'texto' => 'Ver más', 'enlace' => '#', 'variante' => 'secondary', 'tamano' => $t,
                        ]);
                    } ?>
                    <?php get_template_part('template-parts/components/button', null, [
                        'texto' => 'Con icono', 'enlace' => '#', 'variante' => 'secondary', 'tamano' => 'md', 'icono' => true,
                    ]); ?>
                </div>

                <div class="sg-gallery__row">
                    <span class="sg-gallery__label">Ghost</span>
                    <?php foreach (['sm','md','lg'] as $t) {
                        get_template_part('template-parts/components/button', null, [
                            'texto' => 'Cancelar', 'enlace' => '#', 'variante' => 'ghost', 'tamano' => $t,
                        ]);
                    } ?>
                    <?php get_template_part('template-parts/components/button', null, [
                        'texto' => 'Con icono', 'enlace' => '#', 'variante' => 'ghost', 'tamano' => 'md', 'icono' => true,
                    ]); ?>
                </div>

                <div class="sg-gallery__row">
                    <span class="sg-gallery__label">Disabled</span>
                    <?php foreach (['primary','secondary','ghost'] as $v) {
                        get_template_part('template-parts/components/button', null, [
                            'texto' => 'Disabled', 'enlace' => '#', 'variante' => $v, 'tamano' => 'md', 'disabled' => true,
                        ]);
                    } ?>
                </div>
            </div>
        </section>


        <!-- ============================================
             SECCIÓN 3 — TIPOGRAFÍA · PLAYGROUND
             ============================================ -->
        <section class="sg-section" id="typography">
            <h2 class="sg-section__title">Tipografía</h2>
            <p class="sg-section__subtitle">Sistema simplificado · 3 niveles: <code>display</code>, <code>title</code>, <code>body</code>. Para labels usa <code>body</code> + modificador <code>label</code>.</p>

            <div class="sg-playground" data-sg-playground="text">

                <!-- Controls -->
                <div class="sg-controls">
                    <div class="sg-control">
                        <label class="sg-control__label" for="txt-contenido">Contenido</label>
                        <textarea id="txt-contenido" data-sg-input="contenido">The quick brown fox</textarea>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Nivel</span>
                        <div class="sg-control__options" data-sg-group="nivel">
                            <button class="sg-chip is-active" data-sg-value="display">Display</button>
                            <button class="sg-chip" data-sg-value="title">Title</button>
                            <button class="sg-chip" data-sg-value="body">Body</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <label class="sg-control__label" for="txt-elemento">Elemento HTML</label>
                        <select id="txt-elemento" data-sg-select="elemento">
                            <option value="h1">h1</option>
                            <option value="h2" selected>h2</option>
                            <option value="h3">h3</option>
                            <option value="h4">h4</option>
                            <option value="h5">h5</option>
                            <option value="h6">h6</option>
                            <option value="p">p</option>
                            <option value="span">span</option>
                            <option value="small">small</option>
                            <option value="div">div</option>
                        </select>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Peso</span>
                        <div class="sg-control__options" data-sg-group="peso">
                            <button class="sg-chip" data-sg-value="light">Light</button>
                            <button class="sg-chip" data-sg-value="regular">Regular</button>
                            <button class="sg-chip" data-sg-value="semibold">Semibold</button>
                            <button class="sg-chip is-active" data-sg-value="bold">Bold</button>
                            <button class="sg-chip" data-sg-value="black">Black</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Color</span>
                        <div class="sg-control__options" data-sg-group="color">
                            <button class="sg-chip is-active" data-sg-value="white">White</button>
                            <button class="sg-chip" data-sg-value="green">Green</button>
                            <button class="sg-chip" data-sg-value="muted">Muted</button>
                            <button class="sg-chip" data-sg-value="dark">Dark</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Alineación</span>
                        <div class="sg-control__options" data-sg-group="alineacion">
                            <button class="sg-chip is-active" data-sg-value="left">Left</button>
                            <button class="sg-chip" data-sg-value="center">Center</button>
                            <button class="sg-chip" data-sg-value="right">Right</button>
                        </div>
                    </div>

                    <div class="sg-control">
                        <span class="sg-control__label">Modificadores</span>
                        <label class="sg-switch">
                            <input type="checkbox" data-sg-toggle="italic"> Italic
                        </label>
                        <label class="sg-switch">
                            <input type="checkbox" data-sg-toggle="label"> Label (uppercase + verde)
                        </label>
                    </div>
                </div>

                <!-- Preview + Code -->
                <div class="sg-preview">
                    <div class="sg-preview__stage" data-sg-stage="text">
                        <?php get_template_part('template-parts/components/text', null, [
                            'contenido' => 'The quick brown fox',
                            'nivel'     => 'display',
                            'elemento'  => 'h2',
                            'peso'      => 'bold',
                            'color'     => 'white',
                        ]); ?>
                    </div>

                    <div class="sg-code">
                        <button class="sg-code__copy" data-sg-copy>Copiar</button>
                        <pre class="sg-code__pre" data-sg-code="text"></pre>
                    </div>
                </div>
            </div>

            <!-- Galería de niveles -->
            <div class="sg-gallery">
                <h3 class="sg-gallery__title">Los 3 niveles</h3>
                <?php foreach ($niveles_texto as $key => $meta) : ?>
                    <div class="sg-type-row">
                        <div class="sg-type-row__meta">
                            <strong>txt--<?php echo esc_html($key); ?></strong> · <?php echo esc_html($meta['size']); ?> · <?php echo esc_html($meta['descripcion']); ?>
                        </div>
                        <?php get_template_part('template-parts/components/text', null, [
                            'contenido' => 'The quick brown fox jumps over the lazy dog',
                            'nivel'     => $key,
                            'elemento'  => $meta['default_tag'],
                            'color'     => 'white',
                        ]); ?>
                    </div>
                <?php endforeach; ?>

                <!-- Ejemplo de label (body + modificador label) -->
                <div class="sg-type-row">
                    <div class="sg-type-row__meta">
                        <strong>txt--body + txt--label</strong> · estilo label (uppercase + verde + tracking)
                    </div>
                    <?php get_template_part('template-parts/components/text', null, [
                        'contenido' => 'Nuestros servicios',
                        'nivel'     => 'body',
                        'elemento'  => 'span',
                        'label'     => true,
                    ]); ?>
                </div>
            </div>

            <!-- Mockup realista -->
            <div class="sg-gallery" style="margin-top: 24px; padding: 0; overflow: hidden;">
                <h3 class="sg-gallery__title" style="padding: 28px 28px 0;">👀 Ejemplo real combinando los 3 niveles</h3>
                <div class="sg-mockup">
                    <?php get_template_part('template-parts/components/text', null, [
                        'contenido' => 'Nuestros servicios',
                        'nivel'     => 'body',
                        'elemento'  => 'span',
                        'label'     => true,
                        'clase_extra' => 'sg-mockup__caption',
                    ]); ?>
                    <?php get_template_part('template-parts/components/text', null, [
                        'contenido' => 'Logística global que conecta marcas',
                        'nivel'     => 'display',
                        'elemento'  => 'h3',
                        'peso'      => 'bold',
                        'clase_extra' => 'sg-mockup__display',
                    ]); ?>
                    <?php get_template_part('template-parts/components/text', null, [
                        'contenido' => 'Ofrecemos servicios de logística adaptados a cada cliente, con cobertura nacional e internacional. Nuestro equipo gestiona toda la cadena de suministro de principio a fin.',
                        'nivel'     => 'body',
                        'elemento'  => 'p',
                        'color'     => 'muted',
                        'clase_extra' => 'sg-mockup__body',
                    ]); ?>
                    <div class="sg-mockup__grid">
                        <?php
                        $cards = [
                            ['Transporte nacional', 'Red logística propia con cobertura en toda la península y flota especializada.'],
                            ['Transporte internacional', 'Operamos en más de 40 países con acuerdos estratégicos a medida.'],
                            ['Almacenaje', 'Centros logísticos propios con gestión integral de stock y distribución.'],
                        ];
                        foreach ($cards as $c) : ?>
                            <div class="sg-mockup__card">
                                <?php get_template_part('template-parts/components/text', null, [
                                    'contenido' => $c[0], 'nivel' => 'title', 'elemento' => 'h4', 'peso' => 'bold',
                                ]); ?>
                                <?php get_template_part('template-parts/components/text', null, [
                                    'contenido' => $c[1], 'nivel' => 'body', 'elemento' => 'p', 'color' => 'muted',
                                ]); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>
