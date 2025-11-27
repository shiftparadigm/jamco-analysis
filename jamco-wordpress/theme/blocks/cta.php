<?php
/**
 * CTA Block Template
 */

$heading = get_field('heading');
$subheading = get_field('subheading');
$background_image = get_field('background_image');
$cta_button = get_field('cta_button');
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
