<?php
/**
 * Hero Block Template
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

$badge_text = $attributes['badgeText'] ?? '';
$show_badge = $attributes['showBadge'] ?? true;
$heading = $attributes['heading'] ?? '';
$heading_highlight = $attributes['headingHighlight'] ?? '';
$description = $attributes['description'] ?? '';
$primary_cta = $attributes['primaryCTA'] ?? array();
$secondary_cta = $attributes['secondaryCTA'] ?? array();
$show_card = $attributes['showCard'] ?? true;
$card_data = $attributes['cardData'] ?? array();
$bg_color = $attributes['backgroundColor'] ?? '#003D7C';

$block_id = 'hero-' . uniqid();

?>

<header
    id="<?php echo esc_attr($attributes['anchor'] ?? $block_id); ?>"
    class="likewize-hero relative text-white pt-32 pb-32 clip-path-hero overflow-hidden"
    style="background-color: <?php echo esc_attr($bg_color); ?>;"
>
    <!-- Abstract Background -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.05; pointer-events: none;">
        <svg style="height: 100%; width: 100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
        </svg>
    </div>

    <div class="container">
        <!-- Left Column: Content -->
        <div class="hero-content">
            <?php if ($show_badge && $badge_text) : ?>
                <div class="hero-badge inline-flex items-center bg-blue-900/50 backdrop-blur-sm border border-blue-500/30 rounded-full px-4 py-1.5 text-xs font-semibold text-blue-200 mb-2">
                    <span style="width: 0.5rem; height: 0.5rem; background-color: rgb(74, 222, 128); border-radius: 9999px; margin-right: 0.5rem; animation: pulse 2s infinite;"></span>
                    <?php echo esc_html($badge_text); ?>
                </div>
            <?php endif; ?>

            <h1 class="text-white text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                <?php if ($heading) : ?>
                    <?php echo esc_html($heading); ?><br>
                <?php endif; ?>
                <?php if ($heading_highlight) : ?>
                    <span class="text-blue-300"><?php echo esc_html($heading_highlight); ?></span>
                <?php endif; ?>
            </h1>

            <?php if ($description) : ?>
                <p class="text-lg text-blue-100 max-w-lg leading-relaxed">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>

            <div class="hero-ctas flex flex-col sm:flex-row gap-4 pt-4">
                <?php if (!empty($primary_cta['text'])) : ?>
                    <a
                        href="<?php echo esc_url($primary_cta['url'] ?? '#'); ?>"
                        class="btn bg-white text-navy px-8 py-3 rounded-full font-bold hover:bg-blue-50 transition shadow-lg flex items-center justify-center"
                    >
                        <?php echo esc_html($primary_cta['text']); ?>
                        <i data-lucide="arrow-right" class="ml-2 w-4 h-4"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($secondary_cta['text'])) : ?>
                    <a
                        href="<?php echo esc_url($secondary_cta['url'] ?? '#'); ?>"
                        class="btn border border-blue-400 text-blue-100 px-8 py-3 rounded-full font-semibold hover:bg-blue-900/50 transition flex items-center justify-center"
                    >
                        <i data-lucide="file-text" class="mr-2 w-4 h-4"></i>
                        <?php echo esc_html($secondary_cta['text']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Coverage Card -->
        <?php if ($show_card) : ?>
            <div class="hero-card relative hidden md:block">
                <div class="absolute -inset-4 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl p-6 transform rotate-2 hover:rotate-0 transition duration-500 border-t-4 border-red">
                    <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                        <div class="text-sm font-bold text-navy">Coverage Status</div>
                        <div class="flex items-center text-green-600 text-sm font-bold bg-green-50 px-3 py-1 rounded-full">
                            <i data-lucide="check-circle" class="w-4 h-4 mr-1.5"></i>
                            <?php echo esc_html($card_data['status'] ?? 'Active'); ?>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-slate-50 rounded-lg">
                            <div class="bg-blue-100 p-2 rounded-lg mr-4">
                                <i data-lucide="smartphone" class="text-blue" style="color: #0070B8;"></i>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800">
                                    <?php echo esc_html($card_data['deviceName'] ?? 'iPhone 15 Pro'); ?>
                                </div>
                                <div class="text-xs text-slate-500">
                                    <?php echo esc_html($card_data['planName'] ?? 'Protection Plan Plus'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-sm px-2">
                            <span class="text-slate-500">Next Bill</span>
                            <span class="font-bold text-slate-800">
                                <?php echo esc_html($card_data['billingAmount'] ?? '$24.00/mo'); ?>
                            </span>
                        </div>

                        <button class="w-full bg-navy text-white py-3 rounded-lg font-bold text-sm hover:bg-blue-900 transition" style="background-color: #003D7C;">
                            <?php echo esc_html($card_data['buttonText'] ?? 'Manage Device'); ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</header>
