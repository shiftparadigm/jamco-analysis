<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="site-header">
	<!-- Top Navigation Bar -->
	<div class="top-nav">
		<div class="nav-container">
			<a href="<?php echo home_url('/'); ?>" class="logo">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="Jamco Logo" class="logo-icon" />
				<span class="logo-text">Jamco</span>
			</a>

			<nav class="main-nav">
				<a href="/locations" class="nav-item">LOCATIONS</a>
				<a href="/news" class="nav-item">NEWS</a>
				<div class="nav-dropdown">
					<button class="nav-item dropdown-toggle">
						PRODUCTS
						<svg width="10" height="6" viewBox="0 0 10 6" fill="none">
							<path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</button>
					<div class="dropdown-menu">
						<?php
						// Get all products for dropdown
						$products = get_posts([
							'post_type' => 'product',
							'posts_per_page' => -1,
							'orderby' => 'title',
							'order' => 'ASC'
						]);
						foreach ($products as $product) :
						?>
							<a href="<?php echo get_permalink($product->ID); ?>" class="dropdown-item">
								<?php echo esc_html($product->post_title); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			</nav>
		</div>
	</div>

	<!-- Breadcrumb Bar -->
	<?php if (!is_front_page()) : ?>
		<div class="breadcrumb-bar">
			<div class="breadcrumb-container">
				<nav class="breadcrumb" aria-label="Breadcrumb">
					<span class="breadcrumb-item">
						<a href="<?php echo home_url('/'); ?>">Home</a>
						<span class="separator">›</span>
					</span>
					<?php if (is_single() || is_page()) : ?>
						<span class="breadcrumb-item">
							<span><?php the_title(); ?></span>
						</span>
					<?php endif; ?>
				</nav>
				<a href="/contact" class="btn-contact">Contact Us</a>
			</div>
		</div>
	<?php endif; ?>
</header>
