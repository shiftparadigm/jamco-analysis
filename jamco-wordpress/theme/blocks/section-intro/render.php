<?php
/**
 * Section Intro Block Template
 */

$heading = $attributes['heading'] ?? '';
$description = $attributes['description'] ?? '';
$show_divider = $attributes['showDivider'] ?? true;
?>

<section class="section-intro">
	<div class="container">
		<div class="intro-grid">
			<?php if ($heading) : ?>
				<h4><?php echo esc_html($heading); ?></h4>
			<?php endif; ?>

			<?php if ($description) : ?>
				<p><?php echo esc_html($description); ?></p>
			<?php endif; ?>
		</div>
		<?php if ($show_divider) : ?>
			<hr class="divider" />
		<?php endif; ?>
	</div>
</section>
