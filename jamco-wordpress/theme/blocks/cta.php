<?php
/**
 * CTA Block Template
 */

$data = $block_attributes['data'] ?? array();

$heading = $data['heading'] ?? '';
$subheading = $data['subheading'] ?? '';
$cta_button = $data['cta_button'] ?? null;

// Handle background image
$background_image_id = $data['background_image'] ?? 0;
$background_image = null;
if ($background_image_id) {
    $image_url = wp_get_attachment_image_url($background_image_id, 'full');
    if ($image_url) {
        $background_image = array('url' => $image_url);
    }
}
?>

<section class="cta-block" <?php if ($background_image) : ?>style="background-image: url('<?php echo esc_url($background_image['url']); ?>');"<?php endif; ?>>
    <div class="cta-overlay"></div>
    <div class="cta-container">
        <div class="cta-content">
            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($subheading) : ?>
                <p class="subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>

            <?php if ($cta_button) : ?>
                <a href="<?php echo esc_url($cta_button['url']); ?>" class="btn btn-<?php echo esc_attr($cta_button['style'] ?: 'primary'); ?>">
                    <?php echo esc_html($cta_button['text']); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
