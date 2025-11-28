<?php
/**
 * Split Feature Block Template
 */

$heading = get_field('heading');
$description = get_field('description');
$image_position = get_field('image_position') ?: 'left';
$background_color = get_field('background_color') ?: 'white';
$cta_button = get_field('cta_button');
$feature_image = get_field('feature_image');
?>

<section class="split-feature bg-<?php echo esc_attr($background_color); ?> image-<?php echo esc_attr($image_position); ?>">
    <div class="split-container">
        <div class="content-side">
            <?php if ($heading) : ?>
                <h2><?php
                    // Handle both HTML entities and Unicode escapes
                    $decoded_heading = html_entity_decode($heading, ENT_QUOTES | ENT_HTML5);
                    $decoded_heading = preg_replace('/u0026/', '&', $decoded_heading);
                    echo esc_html($decoded_heading);
                ?></h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="description">
                    <?php echo wp_kses_post(html_entity_decode($description)); ?>
                </p>
            <?php endif; ?>

            <?php
            $bullet_points = get_field('bullet_points');
            if (!empty($bullet_points)) : ?>
                <ul class="bullet-points">
                    <?php foreach ($bullet_points as $point) : ?>
                        <li><?php echo esc_html($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($cta_button) : ?>
                <a href="<?php echo esc_url($cta_button['url']); ?>" class="btn btn-<?php echo esc_attr($cta_button['style'] ?: 'primary'); ?>">
                    <?php echo esc_html($cta_button['text']); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($feature_image) : ?>
            <div class="image-side">
                <img src="<?php echo esc_url($feature_image['url']); ?>" alt="<?php echo esc_attr($feature_image['alt'] ?: ''); ?>" />
            </div>
        <?php endif; ?>
    </div>
</section>
