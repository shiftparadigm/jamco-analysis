<?php
/**
 * FAQ Accordion Block Template
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
$faqs = $attributes['faqs'] ?? array();

// Generate unique ID
$block_id = 'faq-accordion-' . uniqid();

// Wrapper classes
$wrapper_classes = array('likewize-faq-accordion', 'py-20', 'bg-white');
if (!empty($attributes['anchor'])) {
    $wrapper_classes[] = 'anchor-' . sanitize_title($attributes['anchor']);
}

?>

<section
    id="<?php echo esc_attr($attributes['anchor'] ?? $block_id); ?>"
    class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>"
>
    <div class="container max-w-3xl">
        <?php if ($heading) : ?>
            <h2 class="text-3xl font-bold text-navy mb-8 text-center">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($faqs)) : ?>
            <div class="faq-list space-y-4">
                <?php foreach ($faqs as $index => $faq) :
                    $question = $faq['question'] ?? '';
                    $answer = $faq['answer'] ?? '';

                    if (!$question) continue;
                ?>
                    <div class="faq-item border border-slate-200 rounded-lg overflow-hidden">
                        <button
                            class="likewize-accordion-button w-full flex justify-between items-center p-5 bg-slate-50 hover:bg-slate-100 transition text-left focus:outline-none"
                            type="button"
                            aria-expanded="false"
                            aria-controls="faq-answer-<?php echo esc_attr($block_id . '-' . $index); ?>"
                        >
                            <span class="font-bold text-slate-700">
                                <?php echo esc_html($question); ?>
                            </span>
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300"></i>
                        </button>

                        <div
                            id="faq-answer-<?php echo esc_attr($block_id . '-' . $index); ?>"
                            class="likewize-accordion-content bg-white"
                        >
                            <div class="p-5 text-slate-600 leading-relaxed border-t border-slate-100">
                                <?php echo wp_kses_post(wpautop($answer)); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-slate-400">
                <?php _e('No FAQs added yet. Add them in the block settings.', 'likewize'); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
