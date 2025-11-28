<?php
/**
 * Split Feature Block Template
 */

$data = $block_attributes['data'] ?? array();

$heading = $data['heading'] ?? '';
$description = $data['description'] ?? '';
$image_position = $data['image_position'] ?? 'left';
$background_color = $data['background_color'] ?? 'white';
$cta_button = $data['cta_button'] ?? null;

// Handle image
$feature_image_id = $data['feature_image'] ?? 0;
$feature_image = null;
if ($feature_image_id) {
    $image_url = wp_get_attachment_image_url($feature_image_id, 'full');
    $image_alt = get_post_meta($feature_image_id, '_wp_attachment_image_alt', true);
    if ($image_url) {
        $feature_image = array(
            'url' => $image_url,
            'alt' => $image_alt
        );
    }
}
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

            <?php if (!empty($data['bullet_points'])) : ?>
                <ul class="bullet-points">
                    <?php foreach ($data['bullet_points'] as $point) : ?>
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
