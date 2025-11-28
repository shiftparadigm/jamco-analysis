<?php
/**
 * Full Width Image Block Template
 */

$height = get_field('height') ?: 'medium';
$watermark = get_field('watermark');
$image = get_field('image');
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
