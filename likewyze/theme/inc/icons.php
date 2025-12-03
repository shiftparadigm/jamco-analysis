<?php
/**
 * Icon Helper Functions
 *
 * @package Likewize
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render a Lucide icon
 *
 * @param string $icon_name The Lucide icon name (e.g., 'smartphone', 'shield')
 * @param string $class Additional CSS classes
 * @param int $size Icon size in pixels (default: 24)
 * @return string HTML for the icon
 */
function likewize_icon($icon_name, $class = '', $size = 24) {
    $classes = 'lucide-icon' . ($class ? ' ' . esc_attr($class) : '');

    return sprintf(
        '<i data-lucide="%s" class="%s" style="width: %dpx; height: %dpx;"></i>',
        esc_attr($icon_name),
        $classes,
        absint($size),
        absint($size)
    );
}

/**
 * List of available Lucide icons for use in blocks
 *
 * @return array Associative array of icon names and labels
 */
function likewize_get_icon_list() {
    return array(
        // Common icons
        'smartphone' => 'Smartphone',
        'shield' => 'Shield',
        'check-circle' => 'Check Circle',
        'alert-circle' => 'Alert Circle',
        'info' => 'Info',

        // Coverage icons
        'droplets' => 'Droplets (Liquid)',
        'smartphone-nfc' => 'Smartphone NFC (Screen)',
        'user-x' => 'User X (Theft/Loss)',
        'zap-off' => 'Zap Off (Power/Hardware)',

        // Process/Timeline icons
        'file-text' => 'File Text',
        'arrow-right' => 'Arrow Right',
        'check' => 'Check',
        'truck' => 'Truck',
        'home' => 'Home',
        'clock' => 'Clock',

        // Pricing/Features
        'dollar-sign' => 'Dollar Sign',
        'refresh-cw' => 'Refresh',
        'alert-octagon' => 'Alert Octagon',

        // UI icons
        'chevron-down' => 'Chevron Down',
        'chevron-up' => 'Chevron Up',
        'chevron-right' => 'Chevron Right',
        'chevron-left' => 'Chevron Left',
        'x' => 'X (Close)',
        'menu' => 'Menu',

        // Contact icons
        'phone' => 'Phone',
        'mail' => 'Mail',
        'message-circle' => 'Message',
    );
}

/**
 * Get icon choices for block attributes
 *
 * @return array Array formatted for block.json enum
 */
function likewize_get_icon_choices() {
    $icons = likewize_get_icon_list();
    $choices = array();

    foreach ($icons as $value => $label) {
        $choices[] = array(
            'label' => $label,
            'value' => $value,
        );
    }

    return $choices;
}

/**
 * Render an icon with optional wrapper
 *
 * @param string $icon_name Icon name
 * @param array $args {
 *     Optional array of arguments
 *     @type string $wrapper Wrapper element (e.g., 'div', 'span')
 *     @type string $wrapper_class CSS class for wrapper
 *     @type string $icon_class CSS class for icon
 *     @type int $size Icon size in pixels
 * }
 * @return string HTML output
 */
function likewize_render_icon($icon_name, $args = array()) {
    $defaults = array(
        'wrapper' => '',
        'wrapper_class' => '',
        'icon_class' => '',
        'size' => 24,
    );

    $args = wp_parse_args($args, $defaults);

    $icon = likewize_icon($icon_name, $args['icon_class'], $args['size']);

    if ($args['wrapper']) {
        return sprintf(
            '<%s class="%s">%s</%s>',
            esc_attr($args['wrapper']),
            esc_attr($args['wrapper_class']),
            $icon,
            esc_attr($args['wrapper'])
        );
    }

    return $icon;
}
