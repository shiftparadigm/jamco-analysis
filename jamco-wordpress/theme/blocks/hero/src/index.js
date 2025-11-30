import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/hero', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const {
			heading,
			subheading,
			floatingImage,
			featureCallout,
			primaryCta,
			secondaryCta,
			carouselIndicator
		} = attributes;

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Content">
						<TextControl
							label="Heading"
							value={heading}
							onChange={(value) => setAttributes({ heading: value })}
						/>
						<TextareaControl
							label="Subheading"
							value={subheading}
							onChange={(value) => setAttributes({ subheading: value })}
						/>
						<TextControl
							label="Carousel Indicator"
							value={carouselIndicator}
							onChange={(value) => setAttributes({ carouselIndicator: value })}
						/>
					</PanelBody>

					<PanelBody title="Floating Image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ floatingImage: media.id })}
								allowedTypes={['image']}
								value={floatingImage}
								render={({ open }) => (
									<Button onClick={open} variant="secondary">
										{floatingImage ? 'Change Image' : 'Select Image'}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{floatingImage && (
							<Button
								onClick={() => setAttributes({ floatingImage: 0 })}
								variant="link"
								isDestructive
							>
								Remove Image
							</Button>
						)}
					</PanelBody>

					<PanelBody title="Feature Callout">
						<TextControl
							label="Label"
							value={featureCallout?.label || ''}
							onChange={(value) => setAttributes({ featureCallout: { ...featureCallout, label: value } })}
						/>
						<TextControl
							label="Description"
							value={featureCallout?.description || ''}
							onChange={(value) => setAttributes({ featureCallout: { ...featureCallout, description: value } })}
						/>
					</PanelBody>

					<PanelBody title="Primary CTA">
						<TextControl
							label="Text"
							value={primaryCta?.text || ''}
							onChange={(value) => setAttributes({ primaryCta: { ...primaryCta, text: value } })}
						/>
						<TextControl
							label="URL"
							value={primaryCta?.url || ''}
							onChange={(value) => setAttributes({ primaryCta: { ...primaryCta, url: value } })}
						/>
					</PanelBody>

					<PanelBody title="Secondary CTA">
						<TextControl
							label="Text"
							value={secondaryCta?.text || ''}
							onChange={(value) => setAttributes({ secondaryCta: { ...secondaryCta, text: value } })}
						/>
						<TextControl
							label="URL"
							value={secondaryCta?.url || ''}
							onChange={(value) => setAttributes({ secondaryCta: { ...secondaryCta, url: value } })}
						/>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/hero"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null, // Server-side rendering
});
