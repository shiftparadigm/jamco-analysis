import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, RangeControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/seating-diagram', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { diagramImage, hotspots } = attributes;

		const updateHotspot = (index, field, value) => {
			const newHotspots = [...hotspots];
			newHotspots[index] = { ...newHotspots[index], [field]: value };
			setAttributes({ hotspots: newHotspots });
		};

		const addHotspot = () => {
			setAttributes({
				hotspots: [...hotspots, { x: 50, y: 50, label: '' }]
			});
		};

		const removeHotspot = (index) => {
			const newHotspots = hotspots.filter((_, i) => i !== index);
			setAttributes({ hotspots: newHotspots });
		};

		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Diagram Image">
						<MediaUploadCheck>
							<MediaUpload
								onSelect={(media) => setAttributes({ diagramImage: media.id })}
								allowedTypes={['image']}
								value={diagramImage}
								render={({ open }) => (
									<Button onClick={open} variant="secondary">
										{diagramImage ? 'Change Diagram' : 'Select Diagram'}
									</Button>
								)}
							/>
						</MediaUploadCheck>
						{diagramImage && (
							<Button
								onClick={() => setAttributes({ diagramImage: 0 })}
								variant="link"
								isDestructive
							>
								Remove Diagram
							</Button>
						)}
					</PanelBody>

					<PanelBody title="Hotspots">
						{hotspots.map((hotspot, index) => (
							<div key={index} style={{ marginBottom: '20px', padding: '10px', border: '1px solid #ddd' }}>
								<h4>Hotspot {index + 1}</h4>
								<TextControl
									label="Label"
									value={hotspot.label}
									onChange={(value) => updateHotspot(index, 'label', value)}
								/>
								<RangeControl
									label="X Position (%)"
									value={hotspot.x}
									onChange={(value) => updateHotspot(index, 'x', value)}
									min={0}
									max={100}
								/>
								<RangeControl
									label="Y Position (%)"
									value={hotspot.y}
									onChange={(value) => updateHotspot(index, 'y', value)}
									min={0}
									max={100}
								/>
								<Button
									onClick={() => removeHotspot(index)}
									variant="secondary"
									isDestructive
								>
									Remove Hotspot
								</Button>
							</div>
						))}
						<Button onClick={addHotspot} variant="primary">
							Add Hotspot
						</Button>
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/seating-diagram"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
