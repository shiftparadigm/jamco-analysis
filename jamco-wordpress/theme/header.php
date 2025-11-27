<?php
/**
 * Theme Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="top-nav">
        <div class="nav-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>" class="logo-icon" />
                    <span class="logo-text"><?php bloginfo('name'); ?></span>
                    <?php
                }
                ?>
            </a>

            <nav class="main-nav">
                <a href="/locations" class="nav-item">LOCATIONS</a>
                <a href="/news" class="nav-item">NEWS</a>
                <div class="nav-dropdown">
                    <button class="nav-item dropdown">
                        PRODUCTS
                        <svg width="10" height="6" viewBox="0 0 10 6" fill="none">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <?php
                        $products = get_posts(array(
                            'post_type' => 'product',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC'
                        ));
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

    <?php
    $breadcrumbs = jamco_breadcrumbs();
    if (!empty($breadcrumbs)) :
        ?>
        <div class="breadcrumb-bar">
            <div class="breadcrumb-container">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    <?php foreach ($breadcrumbs as $index => $crumb) : ?>
                        <span class="breadcrumb-item">
                            <?php if (!empty($crumb['href'])) : ?>
                                <a href="<?php echo esc_url($crumb['href']); ?>"><?php echo esc_html($crumb['label']); ?></a>
                            <?php else : ?>
                                <span><?php echo esc_html($crumb['label']); ?></span>
                            <?php endif; ?>
                            <?php if ($index < count($breadcrumbs) - 1) : ?>
                                <span class="separator">›</span>
                            <?php endif; ?>
                        </span>
                    <?php endforeach; ?>
                </nav>
                <a href="/contact" class="btn-contact">Contact Us</a>
            </div>
        </div>
    <?php endif; ?>
</header>
