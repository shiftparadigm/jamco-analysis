<?php
/**
 * Full Width Image Block Template
 */

$data = $block_attributes['data'] ?? array();

$height = $data['height'] ?? 'medium';
$watermark = $data['watermark'] ?? '';

// Handle image
$image_id = $data['image'] ?? 0;
$image = null;
if ($image_id) {
    $image_url = wp_get_attachment_image_url($image_id, 'full');
    $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
    if ($image_url) {
        $image = array(
            'url' => $image_url,
            'alt' => $image_alt
        );
    }
}
?>

<section class="full-width-image height-<?php echo esc_attr($height); ?>">
    <?php if ($image) : ?>
        <div class="image-wrapper">
            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: ''); ?>" />
            <?php if ($watermark) : ?>
                <div class="watermark"><?php echo esc_html($watermark); ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
