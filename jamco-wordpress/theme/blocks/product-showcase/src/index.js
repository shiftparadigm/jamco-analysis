import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/product-showcase', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { heading, description, image } = attributes;

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Product Showcase">
						<TextControl
							label="Heading"
							value={heading}
							onChange={(value) => setAttributes({ heading: value })}
						/>
						<TextareaControl
							label="Description"
							value={description}
							onChange={(value) => setAttributes({ description: value })}
						/>
					</PanelBody>

					<PanelBody title="Product Image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ image: media.id })}
								allowedTypes={['image']}
								value={image}
								render={({ open }) => (
									<Button onClick={open} variant="secondary">
										{image ? 'Change Image' : 'Select Image'}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{image && (
							<Button
								onClick={() => setAttributes({ image: 0 })}
								variant="link"
								isDestructive
							>
								Remove Image
							</Button>
						)}
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/product-showcase"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
