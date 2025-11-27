<?php
/**
 * ACF Field Groups for Custom Blocks
 * Registers all field groups needed for the custom ACF blocks
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

// Hero Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_hero',
    'title' => 'Hero Block Fields',
    'fields' => array(
        array(
            'key' => 'field_hero_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_hero_subheading',
            'label' => 'Subheading',
            'name' => 'subheading',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_hero_floating_image',
            'label' => 'Hero Image',
            'name' => 'floating_image',
            'type' => 'image',
            'return_format' => 'array',
        ),
        array(
            'key' => 'field_hero_primary_cta',
            'label' => 'Primary CTA',
            'name' => 'primary_cta',
            'type' => 'group',
            'sub_fields' => array(
                array(
                    'key' => 'field_hero_primary_cta_text',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_hero_primary_cta_url',
                    'label' => 'URL',
                    'name' => 'url',
                    'type' => 'url',
                ),
            ),
        ),
        array(
            'key' => 'field_hero_secondary_cta',
            'label' => 'Secondary CTA',
            'name' => 'secondary_cta',
            'type' => 'group',
            'sub_fields' => array(
                array(
                    'key' => 'field_hero_secondary_cta_text',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_hero_secondary_cta_url',
                    'label' => 'URL',
                    'name' => 'url',
                    'type' => 'url',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/hero',
            ),
        ),
    ),
));

// Section Intro Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_section_intro',
    'title' => 'Section Intro Block Fields',
    'fields' => array(
        array(
            'key' => 'field_section_intro_eyebrow',
            'label' => 'Eyebrow Text',
            'name' => 'eyebrow',
            'type' => 'text',
        ),
        array(
            'key' => 'field_section_intro_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_section_intro_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'wysiwyg',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/section-intro',
            ),
        ),
    ),
));

// Feature Grid Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_feature_grid',
    'title' => 'Feature Grid Block Fields',
    'fields' => array(
        array(
            'key' => 'field_feature_grid_features',
            'label' => 'Features',
            'name' => 'features',
            'type' => 'repeater',
            'min' => 1,
            'max' => 3,
            'layout' => 'block',
            'button_label' => 'Add Feature',
            'sub_fields' => array(
                array(
                    'key' => 'field_feature_image',
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'array',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_feature_heading',
                    'label' => 'Heading',
                    'name' => 'heading',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_feature_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/feature-grid',
            ),
        ),
    ),
));

// Split Feature Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_split_feature',
    'title' => 'Split Feature Block Fields',
    'fields' => array(
        array(
            'key' => 'field_split_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_split_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'wysiwyg',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
        ),
        array(
            'key' => 'field_split_feature_image',
            'label' => 'Feature Image',
            'name' => 'feature_image',
            'type' => 'image',
            'return_format' => 'array',
            'required' => 1,
        ),
        array(
            'key' => 'field_split_image_position',
            'label' => 'Image Position',
            'name' => 'image_position',
            'type' => 'select',
            'choices' => array(
                'left' => 'Left',
                'right' => 'Right',
            ),
            'default_value' => 'left',
            'required' => 1,
        ),
        array(
            'key' => 'field_split_background_color',
            'label' => 'Background Color',
            'name' => 'background_color',
            'type' => 'select',
            'choices' => array(
                'white' => 'White',
                'light-blue' => 'Light Blue',
                'blue' => 'Blue',
            ),
            'default_value' => 'white',
            'required' => 1,
        ),
        array(
            'key' => 'field_split_cta_button',
            'label' => 'CTA Button',
            'name' => 'cta_button',
            'type' => 'group',
            'sub_fields' => array(
                array(
                    'key' => 'field_split_cta_text',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_split_cta_url',
                    'label' => 'URL',
                    'name' => 'url',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_split_cta_style',
                    'label' => 'Style',
                    'name' => 'style',
                    'type' => 'select',
                    'choices' => array(
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'outline' => 'Outline',
                    ),
                    'default_value' => 'primary',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/split-feature',
            ),
        ),
    ),
));

// Product Carousel Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_product_carousel',
    'title' => 'Product Carousel Block Fields',
    'fields' => array(
        array(
            'key' => 'field_carousel_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_carousel_description',
            'label' => 'Description',
            'name' => 'description',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_carousel_label',
            'label' => 'Label',
            'name' => 'label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_carousel_products',
            'label' => 'Products',
            'name' => 'products',
            'type' => 'relationship',
            'post_type' => array('product'),
            'return_format' => 'object',
            'min' => 1,
        ),
        array(
            'key' => 'field_carousel_show_pagination',
            'label' => 'Show Pagination',
            'name' => 'show_pagination',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 1,
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/product-carousel',
            ),
        ),
    ),
));

// Testimonial Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_testimonial',
    'title' => 'Testimonial Block Fields',
    'fields' => array(
        array(
            'key' => 'field_testimonial_quote',
            'label' => 'Quote',
            'name' => 'quote',
            'type' => 'textarea',
            'rows' => 4,
            'required' => 1,
        ),
        array(
            'key' => 'field_testimonial_author_name',
            'label' => 'Author Name',
            'name' => 'author_name',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_testimonial_author_title',
            'label' => 'Author Title',
            'name' => 'author_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_testimonial_author_company',
            'label' => 'Author Company',
            'name' => 'author_company',
            'type' => 'text',
        ),
        array(
            'key' => 'field_testimonial_author_image',
            'label' => 'Author Image',
            'name' => 'author_image',
            'type' => 'image',
            'return_format' => 'array',
        ),
        array(
            'key' => 'field_testimonial_background_color',
            'label' => 'Background Color',
            'name' => 'background_color',
            'type' => 'color_picker',
            'default_value' => '#3767AD',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/testimonial',
            ),
        ),
    ),
));

// CTA Block Field Group
acf_add_local_field_group(array(
    'key' => 'group_cta',
    'title' => 'CTA Block Fields',
    'fields' => array(
        array(
            'key' => 'field_cta_heading',
            'label' => 'Heading',
            'name' => 'heading',
            'type' => 'text',
            'required' => 1,
        ),
        array(
            'key' => 'field_cta_subheading',
            'label' => 'Subheading',
            'name' => 'subheading',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_cta_background_image',
            'label' => 'Background Image',
            'name' => 'background_image',
            'type' => 'image',
            'return_format' => 'array',
            'required' => 1,
        ),
        array(
            'key' => 'field_cta_button',
            'label' => 'CTA Button',
            'name' => 'cta_button',
            'type' => 'group',
            'sub_fields' => array(
                array(
                    'key' => 'field_cta_button_text',
                    'label' => 'Text',
                    'name' => 'text',
                    'type' => 'text',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_cta_button_url',
                    'label' => 'URL',
                    'name' => 'url',
                    'type' => 'url',
                    'required' => 1,
                ),
                array(
                    'key' => 'field_cta_button_style',
                    'label' => 'Style',
                    'name' => 'style',
                    'type' => 'select',
                    'choices' => array(
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'outline' => 'Outline',
                    ),
                    'default_value' => 'outline',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'block',
                'operator' => '==',
                'value' => 'acf/cta',
            ),
        ),
    ),
));
