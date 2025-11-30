import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/full-width-image', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { image, caption } = attributes;

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Image Settings">
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
						<TextControl
							label="Caption"
							value={caption}
							onChange={(value) => setAttributes({ caption: value })}
						/>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/full-width-image"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
