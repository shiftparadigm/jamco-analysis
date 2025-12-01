import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/cta', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { heading, buttonText, buttonUrl, backgroundImage } = attributes;

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="CTA Content">
						<TextControl
							label="Heading"
							value={heading}
							onChange={(value) => setAttributes({ heading: value })}
						/>
						<TextControl
							label="Button Text"
							value={buttonText}
							onChange={(value) => setAttributes({ buttonText: value })}
						/>
						<TextControl
							label="Button URL"
							value={buttonUrl}
							onChange={(value) => setAttributes({ buttonUrl: value })}
						/>
					</PanelBody>

					<PanelBody title="Background Image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ backgroundImage: media.id })}
								allowedTypes={['image']}
								value={backgroundImage}
								render={({ open }) => (
									<Button onClick={open} variant="secondary">
										{backgroundImage ? 'Change Background' : 'Select Background'}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{backgroundImage && (
							<Button
								onClick={() => setAttributes({ backgroundImage: 0 })}
								variant="link"
								isDestructive
							>
								Remove Background
							</Button>
						)}
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/cta"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
