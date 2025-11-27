<?php
/**
 * Hero Block Template
 */

$heading = get_field('heading');
$subheading = get_field('subheading');
$floating_image = get_field('floating_image');
$primary_cta = get_field('primary_cta');
$secondary_cta = get_field('secondary_cta');
$feature_callout = get_field('feature_callout');
$carousel_indicator = get_field('carousel_indicator');
?>

<section class="hero">
    <div class="hero-container">
        <div class="hero-content">
            <?php if ($heading) : ?>
                <h1><?php echo esc_html($heading); ?></h1>
            <?php endif; ?>

            <?php if ($subheading) : ?>
                <p class="subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($primary_cta || $secondary_cta) : ?>
                <div class="hero-ctas">
                    <?php if ($primary_cta) : ?>
                        <a href="<?php echo esc_url($primary_cta['url']); ?>" class="btn btn-<?php echo esc_attr($primary_cta['style'] ?: 'primary'); ?>">
                            <?php echo esc_html($primary_cta['text']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($secondary_cta) : ?>
                        <a href="<?php echo esc_url($secondary_cta['url']); ?>" class="btn btn-<?php echo esc_attr($secondary_cta['style'] ?: 'outline'); ?>">
                            <?php echo esc_html($secondary_cta['text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($floating_image) : ?>
            <div class="hero-image">
                <img src="<?php echo esc_url($floating_image['url']); ?>" alt="<?php echo esc_attr($floating_image['alt'] ?: ''); ?>" />

                <?php if ($feature_callout) : ?>
                    <div class="feature-callout">
                        <strong><?php echo esc_html($feature_callout['label']); ?></strong>
                        <?php if (!empty($feature_callout['description'])) : ?>
                            <p><?php echo esc_html($feature_callout['description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($carousel_indicator) : ?>
                    <span class="carousel-indicator"><?php echo esc_html($carousel_indicator); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
