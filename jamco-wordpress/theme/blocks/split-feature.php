<?php
/**
 * Split Feature Block Template
 */

$heading = get_field('heading');
$description = get_field('description');
$feature_image = get_field('feature_image');
$image_position = get_field('image_position') ?: 'left';
$background_color = get_field('background_color') ?: 'white';
$cta_button = get_field('cta_button');
?>

<section class="split-feature bg-<?php echo esc_attr($background_color); ?> image-<?php echo esc_attr($image_position); ?>">
    <div class="split-container">
        <div class="split-content">
            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <div class="description">
                    <?php echo wp_kses_post($description); ?>
                </div>
            <?php endif; ?>

            <?php if ($cta_button) : ?>
                <a href="<?php echo esc_url($cta_button['url']); ?>" class="btn btn-<?php echo esc_attr($cta_button['style'] ?: 'primary'); ?>">
                    <?php echo esc_html($cta_button['text']); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($feature_image) : ?>
            <div class="split-image">
                <img src="<?php echo esc_url($feature_image['url']); ?>" alt="<?php echo esc_attr($feature_image['alt'] ?: ''); ?>" />
            </div>
        <?php endif; ?>
    </div>
</section>
