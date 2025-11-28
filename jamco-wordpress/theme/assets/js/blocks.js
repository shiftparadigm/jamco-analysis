/**
 * Register Jamco Blocks for Gutenberg Editor
 */
(function(wp) {
    const { registerBlockType } = wp.blocks;
    const { ServerSideRender } = wp.serverSideRender || wp.editor;
    const { InspectorControls } = wp.blockEditor || wp.editor;
    const { PanelBody, TextControl, TextareaControl, ToggleControl, SelectControl } = wp.components;
    const { createElement: el } = wp.element;

    // Helper to create a server-rendered block
    function createServerRenderedBlock(name, title, icon, attributes = {}) {
        registerBlockType('jamco/' + name, {
            title: title,
            icon: icon,
            category: 'jamco',
            attributes: {
                data: {
                    type: 'object',
                    default: {}
                }
            },
            edit: function(props) {
                return el('div', { className: 'jamco-block-editor' },
                    el('div', {
                        style: {
                            padding: '20px',
                            border: '2px dashed #ccc',
                            backgroundColor: '#f5f5f5',
                            textAlign: 'center'
                        }
                    },
                        el('p', { style: { margin: 0, fontWeight: 'bold' } }, title),
                        el('p', { style: { margin: '10px 0 0', fontSize: '12px', color: '#666' } },
                            'This block will render on the frontend. Edit via code or use ACF fields.')
                    )
                );
            },
            save: function() {
                return null; // Server-side rendered
            }
        });
    }

    // Register all blocks
    createServerRenderedBlock('hero', 'Hero Section', 'cover-image');
    createServerRenderedBlock('section-intro', 'Section Intro', 'editor-textcolor');
    createServerRenderedBlock('feature-grid', 'Feature Grid', 'grid-view');
    createServerRenderedBlock('split-feature', 'Split Feature', 'columns');
    createServerRenderedBlock('product-carousel', 'Product Carousel', 'images-alt2');
    createServerRenderedBlock('testimonial', 'Testimonial', 'format-quote');
    createServerRenderedBlock('cta', 'Call to Action', 'megaphone');

})(window.wp);
