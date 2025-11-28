<?php
/**
 * Page Template - Renders blocks from JSON meta
 */
get_header();

while (have_posts()) : the_post();
    // Get blocks data from post meta
    $blocks_data = get_post_meta(get_the_ID(), '_blocks_data', true);

    if ($blocks_data && is_array($blocks_data)) {
        foreach ($blocks_data as $block) {
            $block_type = $block['type'] ?? '';
            $data = $block['data'] ?? [];

            // Load block template
            $template_path = get_template_directory() . "/blocks/{$block_type}.php";

            if (file_exists($template_path)) {
                // Extract data to variables
                extract($data);
                include $template_path;
            }
        }
    } else {
        // Fallback to regular content
        the_content();
    }
endwhile;

get_footer();
