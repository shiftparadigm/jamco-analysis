<?php
foreach (WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $block) {
    if (strpos($name, 'jamco') !== false) {
        echo $name . "\n";
        echo "  Script: " . ($block->editor_script ?? 'none') . "\n";
        echo "  Render: " . ($block->render_callback ? 'callback' : 'template') . "\n";
    }
}
