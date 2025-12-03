<?php
/**
 * Process Steps Block Template
 */

if (!defined('ABSPATH')) exit;

$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
$steps = $attributes['steps'] ?? array();
$timeline = $attributes['timeline'] ?? array();
$block_id = 'process-' . uniqid();
?>

<section id="<?php echo esc_attr($attributes['anchor'] ?? $block_id); ?>" class="likewize-process py-20 bg-gray border-y border-slate-200">
    <div class="container">
        <div class="flex flex-col md:flex-row gap-12 items-center">
            <!-- Left: Steps -->
            <div class="md:w-1/2">
                <?php if ($heading) : ?>
                    <h2 class="text-3xl font-bold text-navy mb-6"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <p class="text-slate-600 mb-8"><?php echo esc_html($description); ?></p>
                <?php endif; ?>

                <div class="space-y-6">
                    <?php foreach ($steps as $index => $step) : ?>
                        <div class="flex">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-8 h-8 rounded-full text-white flex items-center justify-center font-bold" style="background-color: <?php echo esc_attr($step['color'] ?? '#003D7C'); ?>;">
                                    <?php echo ($index + 1); ?>
                                </div>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800"><?php echo esc_html($step['title']); ?></h4>
                                <p class="text-sm text-slate-500 mt-1"><?php echo esc_html($step['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right: Timeline Card -->
            <div class="md:w-1/2 relative">
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-slate-800">Claim Status</h3>
                        <span class="text-xs font-mono text-slate-400">#CLM-88291</span>
                    </div>

                    <div class="timeline-container space-y-6 relative before:absolute before:left-3.5 before:top-2 before:h-full before:w-0.5 before:bg-slate-100">
                        <?php foreach ($timeline as $item) :
                            $status = $item['status'] ?? 'pending';
                            $status_colors = [
                                'completed' => ['bg' => 'bg-green-500', 'class' => ''],
                                'active' => ['bg' => 'bg-blue-500', 'class' => 'animate-pulse'],
                                'pending' => ['bg' => 'bg-slate-200', 'class' => 'opacity-50']
                            ];
                            $colors = $status_colors[$status];
                        ?>
                            <div class="relative flex items-center <?php echo esc_attr($colors['class']); ?>">
                                <div class="w-7 h-7 rounded-full <?php echo esc_attr($colors['bg']); ?> text-white flex items-center justify-center border-4 border-white z-10">
                                    <i data-lucide="<?php echo esc_attr($item['icon'] ?? 'circle'); ?>" class="w-3 h-3"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-slate-800"><?php echo esc_html($item['label']); ?></div>
                                    <?php if (!empty($item['sublabel'])) : ?>
                                        <div class="text-xs text-slate-400"><?php echo esc_html($item['sublabel']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <button class="w-full py-2 bg-blue-50 text-blue-600 font-bold rounded hover:bg-blue-100 transition text-sm">
                            Track Another Claim
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
