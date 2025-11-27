<?php
/**
 * Section Intro Block Template
 */

$eyebrow = get_field('eyebrow');
$heading = get_field('heading');
$description = get_field('description');
$alignment = get_field('alignment') ?: 'center';
?>

<section class="section-intro text-<?php echo esc_attr($alignment); ?>">
    <div class="container-narrow">
        <?php if ($eyebrow) : ?>
            <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($heading) : ?>
            <h2><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($description) : ?>
            <div class="description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
