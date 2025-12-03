<?php
/**
 * Feature Grid Block Template
 *
 * @param array $attributes Block attributes
 * @param string $content Block content
 * @param WP_Block $block Block instance
 *
 * @package Likewize
 */

if (!defined('ABSPATH')) {
    exit;
}

$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
$columns = $attributes['columns'] ?? 4;
$features = $attributes['features'] ?? array();

// Generate unique ID for section
$block_id = 'feature-grid-' . uniqid();

// Wrapper classes
$wrapper_classes = array('likewize-feature-grid', 'py-20');
if (!empty($attributes['anchor'])) {
    $wrapper_classes[] = 'anchor-' . sanitize_title($attributes['anchor']);
}

?>

<section
    id="<?php echo esc_attr($attributes['anchor'] ?? $block_id); ?>"
    class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>"
>
    <div class="container">
        <?php if ($heading || $description) : ?>
            <div class="feature-grid-header text-center max-w-3xl mx-auto mb-16">
                <?php if ($heading) : ?>
                    <h2 class="text-3xl font-bold text-navy mb-4">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="text-slate-500">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($features)) : ?>
            <div class="feature-grid grid grid-cols-<?php echo esc_attr($columns); ?> gap-6">
                <?php foreach ($features as $feature) :
                    $icon = $feature['icon'] ?? 'circle';
                    $icon_color = $feature['iconColor'] ?? '#003D7C';
                    $icon_bg_color = $feature['iconBgColor'] ?? '#F4F4F4';
                    $title = $feature['title'] ?? '';
                    $desc = $feature['description'] ?? '';
                ?>
                    <div class="feature-card bg-white p-6 rounded-xl border border-slate-100 shadow-soft hover:shadow-card transition group">
                        <div
                            class="icon-wrapper w-12 h-12 rounded-lg flex items-center justify-center mb-4 transition"
                            style="background-color: <?php echo esc_attr($icon_bg_color); ?>; color: <?php echo esc_attr($icon_color); ?>;"
                        >
                            <i data-lucide="<?php echo esc_attr($icon); ?>" class="w-6 h-6"></i>
                        </div>

                        <?php if ($title) : ?>
                            <h3 class="font-bold text-lg text-slate-800 mb-2">
                                <?php echo esc_html($title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($desc) : ?>
                            <p class="text-sm text-slate-500">
                                <?php echo esc_html($desc); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
