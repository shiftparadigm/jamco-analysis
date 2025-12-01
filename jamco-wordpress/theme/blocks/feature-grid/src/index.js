import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/feature-grid', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { features } = attributes;

		const updateFeature = (index, field, value) => {
			const newFeatures = [...features];
			newFeatures[index] = { ...newFeatures[index], [field]: value };
			setAttributes({ features: newFeatures });
		};

		return (
			<div {...blockProps}>
				<InspectorControls>
					{features.map((feature, index) => (
						<PanelBody key={index} title={`Feature ${index + 1}`} initialOpen={index === 0}>
							<MediaUploadCheck>
								<MediaUpload
									onSelect={(media) => updateFeature(index, 'icon', media.id)}
									allowedTypes={['image']}
									value={feature.icon}
									render={({ open }) => (
										<Button onClick={open} variant="secondary">
											{feature.icon ? 'Change Icon' : 'Select Icon'}
										</Button>
									)}
								/>
							</MediaUploadCheck>
							{feature.icon && (
								<Button
									onClick={() => updateFeature(index, 'icon', 0)}
									variant="link"
									isDestructive
								>
									Remove Icon
								</Button>
							)}
							<TextControl
								label="Title"
								value={feature.title}
								onChange={(value) => updateFeature(index, 'title', value)}
							/>
							<TextareaControl
								label="Description"
								value={feature.description}
								onChange={(value) => updateFeature(index, 'description', value)}
							/>
						</PanelBody>
					))}
				</InspectorControls>

				<ServerSideRender
					block="jamco/feature-grid"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
