<?php
/**
 * Pricing Table Block Template
 *
 * @package Likewize
 */

if (!defined('ABSPATH')) exit;

$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
$tiers = $attributes['tiers'] ?? array();
$rows = $attributes['rows'] ?? array();
$block_id = 'pricing-' . uniqid();
?>

<section id="<?php echo esc_attr($attributes['anchor'] ?? $block_id); ?>" class="likewize-pricing py-20">
    <div class="container">
        <?php if ($heading || $description) : ?>
            <div class="text-center mb-12">
                <?php if ($heading) : ?>
                    <h2 class="text-3xl font-bold text-navy"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <p class="text-slate-500 mt-2"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="pricing-table bg-white rounded-2xl shadow-card overflow-hidden border border-slate-200">
            <!-- Header -->
            <div class="pricing-header grid md:grid-cols-4 bg-navy text-white font-semibold text-sm">
                <div class="p-6 md:border-r border-blue-800">Plan Feature</div>
                <?php foreach ($tiers as $tier) : ?>
                    <div class="p-6 md:border-r border-blue-800 text-center">
                        <?php echo esc_html($tier['name']); ?>
                        <span class="block text-xs font-normal text-blue-300"><?php echo esc_html($tier['subtitle']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Rows -->
            <?php foreach ($rows as $index => $row) :
                $is_last = ($index === count($rows) - 1);
                $full_width = $row['fullWidth'] ?? false;
            ?>
                <div class="pricing-row grid md:grid-cols-4 <?php echo !$is_last ? 'border-b border-slate-100' : ''; ?> hover:bg-slate-50 transition">
                    <div class="p-6 font-bold text-slate-700 flex items-center">
                        <i data-lucide="<?php echo esc_attr($row['icon'] ?? 'circle'); ?>" class="w-4 h-4 mr-2 text-farmers-red"></i>
                        <?php echo esc_html($row['label']); ?>
                    </div>

                    <?php if ($full_width) : ?>
                        <div class="p-6 text-center text-slate-600 col-span-3">
                            <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                <?php echo esc_html($row['values'][0]); ?>
                            </span>
                        </div>
                    <?php else : ?>
                        <?php foreach ($row['values'] as $i => $value) : ?>
                            <div class="p-6 text-center text-slate-600 <?php echo ($row['highlight'] ?? -1) === $i ? 'bg-blue-50/30 font-bold text-blue' : ''; ?>">
                                <?php echo esc_html($value); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
