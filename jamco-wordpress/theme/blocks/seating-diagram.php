<?php
/**
 * Seating Diagram Block Template
 */

$data = $block_attributes['data'] ?? array();

$background_color = $data['background_color'] ?? 'white';
$brand_logos = $data['brand_logos'] ?? array();

// Handle image
$diagram_image_id = $data['diagram_image'] ?? 0;
$diagram_image = null;
if ($diagram_image_id) {
    $image_url = wp_get_attachment_image_url($diagram_image_id, 'full');
    $image_alt = get_post_meta($diagram_image_id, '_wp_attachment_image_alt', true);
    if ($image_url) {
        $diagram_image = array(
            'url' => $image_url,
            'alt' => $image_alt
        );
    }
}
?>

<section class="seating-diagram bg-<?php echo esc_attr($background_color); ?>">
    <div class="diagram-container">
        <?php if ($diagram_image) : ?>
            <div class="diagram-image">
                <img src="<?php echo esc_url($diagram_image['url']); ?>" alt="<?php echo esc_attr($diagram_image['alt'] ?: 'Seating diagram'); ?>" />
            </div>
        <?php endif; ?>

        <?php if (!empty($brand_logos)) : ?>
            <div class="brand-logos">
                <?php foreach ($brand_logos as $logo) : ?>
                    <div class="brand-logo">
                        <div class="brand-name"><?php echo esc_html($logo['name'] ?? ''); ?></div>
                        <?php if (!empty($logo['tagline'])) : ?>
                            <div class="brand-tagline"><?php echo esc_html($logo['tagline']); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
