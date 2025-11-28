<?php
/**
 * Testimonial Block Template
 */

$quote = get_field('quote');
$author_name = get_field('author_name');
$author_title = get_field('author_title');
$author_company = get_field('author_company');
$background_color = get_field('background_color') ?: '#3767AD';
$author_image = get_field('author_image');
?>

<section class="testimonial" style="background-color: <?php echo esc_attr($background_color); ?>;">
    <div class="testimonial-container">
        <div class="testimonial-content">
            <?php if ($quote) : ?>
                <blockquote class="quote">
                    &ldquo;<?php echo esc_html($quote); ?>&rdquo;
                </blockquote>
            <?php endif; ?>

            <div class="author">
                <?php if ($author_image) : ?>
                    <div class="author-image">
                        <img src="<?php echo esc_url($author_image['url']); ?>" alt="<?php echo esc_attr($author_name); ?>" />
                    </div>
                <?php endif; ?>

                <div class="author-info">
                    <?php if ($author_name) : ?>
                        <p class="author-name"><?php echo esc_html($author_name); ?></p>
                    <?php endif; ?>

                    <?php if ($author_title || $author_company) : ?>
                        <p class="author-title">
                            <?php
                            $title_parts = array_filter(array($author_title, $author_company));
                            echo esc_html(implode(', ', $title_parts));
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
