import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/split-feature', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const {
			heading,
			description,
			bulletPoints,
			featureImage,
			imagePosition,
			backgroundColor,
			ctaButton
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
							label="Description"
							value={description}
							onChange={(value) => setAttributes({ description: value })}
						/>
						<TextareaControl
							label="Bullet Points (one per line)"
							value={bulletPoints.join('\n')}
							onChange={(value) => setAttributes({ bulletPoints: value.split('\n').filter(p => p.trim()) })}
							help="Enter each bullet point on a new line"
						/>
					</PanelBody>

					<PanelBody title="Feature Image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ featureImage: media.id })}
								allowedTypes={['image']}
								value={featureImage}
								render={({ open }) => (
									<Button onClick={open} variant="secondary">
										{featureImage ? 'Change Image' : 'Select Image'}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{featureImage && (
							<Button
								onClick={() => setAttributes({ featureImage: 0 })}
								variant="link"
								isDestructive
							>
								Remove Image
							</Button>
						)}
						<SelectControl
							label="Image Position"
							value={imagePosition}
							options={[
								{ label: 'Left', value: 'left' },
								{ label: 'Right', value: 'right' }
							]}
							onChange={(value) => setAttributes({ imagePosition: value })}
						/>
					</PanelBody>

					<PanelBody title="Styling">
						<SelectControl
							label="Background Color"
							value={backgroundColor}
							options={[
								{ label: 'White', value: 'white' },
								{ label: 'Light Blue', value: 'light-blue' },
								{ label: 'Blue', value: 'blue' }
							]}
							onChange={(value) => setAttributes({ backgroundColor: value })}
						/>
					</PanelBody>

					<PanelBody title="CTA Button">
						<TextControl
							label="Button Text"
							value={ctaButton?.text || ''}
							onChange={(value) => setAttributes({ ctaButton: { ...ctaButton, text: value } })}
						/>
						<TextControl
							label="Button URL"
							value={ctaButton?.url || ''}
							onChange={(value) => setAttributes({ ctaButton: { ...ctaButton, url: value } })}
						/>
						<SelectControl
							label="Button Style"
							value={ctaButton?.style || 'primary'}
							options={[
								{ label: 'Primary', value: 'primary' },
								{ label: 'Secondary', value: 'secondary' },
								{ label: 'Outline', value: 'outline' }
							]}
							onChange={(value) => setAttributes({ ctaButton: { ...ctaButton, style: value } })}
						/>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/split-feature"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
