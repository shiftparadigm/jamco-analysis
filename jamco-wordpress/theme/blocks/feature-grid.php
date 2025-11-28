<?php
/**
 * Feature Grid Block Template
 */

$features = get_field('features') ?: array();
?>

<section class="feature-grid">
    <div class="container">
        <div class="grid">
            <?php if ($features) : foreach ($features as $feature) : ?>
                <div class="feature-item">
                    <?php if (!empty($feature['image'])) : ?>
                        <div class="feature-image">
                            <img src="<?php echo esc_url($feature['image']['url']); ?>" alt="<?php echo esc_attr($feature['image']['alt'] ?: ''); ?>" />
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($feature['heading'])) : ?>
                        <h3><?php echo esc_html($feature['heading']); ?></h3>
                    <?php endif; ?>

                    <?php if (!empty($feature['description'])) : ?>
                        <p><?php echo esc_html($feature['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</section>
