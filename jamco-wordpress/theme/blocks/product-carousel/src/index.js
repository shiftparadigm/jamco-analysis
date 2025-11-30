import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/product-carousel', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { heading, description, label, productRefs } = attributes;

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Carousel Settings">
						<TextControl
							label="Heading"
							value={heading}
							onChange={(value) => setAttributes({ heading: value })}
						/>
						<TextControl
							label="Description"
							value={description}
							onChange={(value) => setAttributes({ description: value })}
						/>
						<TextControl
							label="Label"
							value={label}
							onChange={(value) => setAttributes({ label: value })}
						/>
						<p>Products: {productRefs?.length || 0} selected</p>
						<p style={{ fontSize: '12px', color: '#666' }}>
							Product references are managed via block attributes (productRefs).
						</p>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/product-carousel"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
