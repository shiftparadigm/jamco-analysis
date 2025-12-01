import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/testimonial', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { quote, authorName, authorTitle, authorImage } = attributes;

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Testimonial Content">
						<TextareaControl
							label="Quote"
							value={quote}
							onChange={(value) => setAttributes({ quote: value })}
						/>
						<TextControl
							label="Author Name"
							value={authorName}
							onChange={(value) => setAttributes({ authorName: value })}
						/>
						<TextControl
							label="Author Title"
							value={authorTitle}
							onChange={(value) => setAttributes({ authorTitle: value })}
						/>
					</PanelBody>

					<PanelBody title="Author Image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ authorImage: media.id })}
								allowedTypes={['image']}
								value={authorImage}
								render={({ open }) => (
									<Button onClick={open} variant="secondary">
										{authorImage ? 'Change Image' : 'Select Image'}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{authorImage && (
							<Button
								onClick={() => setAttributes({ authorImage: 0 })}
								variant="link"
								isDestructive
							>
								Remove Image
							</Button>
						)}
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/testimonial"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
