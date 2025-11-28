<?php
/**
 * Seating Diagram Block Template
 */

$background_color = get_field('background_color') ?: 'white';
$brand_logos = get_field('brand_logos') ?: array();
$diagram_image = get_field('diagram_image');
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
