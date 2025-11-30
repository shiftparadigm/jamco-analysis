<?php
/**
 * Testimonial Block Template
 */

$quote = $attributes['quote'] ?? '';
$author_name = $attributes['authorName'] ?? '';
$author_title = $attributes['authorTitle'] ?? '';
$author_image_id = $attributes['authorImage'] ?? 0;

$author_image_url = $author_image_id ? wp_get_attachment_image_url($author_image_id, 'thumbnail') : '';
?>

<section class="testimonial">
	<div class="testimonial-container">
		<?php if ($quote) : ?>
			<blockquote class="testimonial-quote">
				"<?php echo esc_html($quote); ?>"
			</blockquote>
		<?php endif; ?>

		<?php if ($author_name || $author_title) : ?>
			<div class="testimonial-author">
				<?php if ($author_image_url) : ?>
					<img src="<?php echo esc_url($author_image_url); ?>"
						 alt="<?php echo esc_attr($author_name); ?>"
						 class="author-image" />
				<?php endif; ?>

				<div class="author-info">
					<?php if ($author_name) : ?>
						<div class="author-name"><?php echo esc_html($author_name); ?></div>
					<?php endif; ?>

					<?php if ($author_title) : ?>
						<div class="author-title"><?php echo esc_html($author_title); ?></div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
