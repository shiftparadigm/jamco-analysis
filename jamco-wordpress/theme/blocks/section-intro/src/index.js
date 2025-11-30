import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

registerBlockType('jamco/section-intro', {
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		const { heading, description } = attributes;

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
					</PanelBody>
				</InspectorControls>

				<ServerSideRender
					block="jamco/section-intro"
					attributes={attributes}
				/>
			</div>
		);
	},

	save: () => null,
});
