/**
 * Feature Grid Block - Editor
 *
 * @package Likewize
 */

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, RangeControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

// Icon list for dropdown
const ICON_OPTIONS = [
  { label: 'Droplets (Liquid)', value: 'droplets' },
  { label: 'Smartphone (Screen)', value: 'smartphone-nfc' },
  { label: 'User X (Theft)', value: 'user-x' },
  { label: 'Zap Off (Hardware)', value: 'zap-off' },
  { label: 'Shield', value: 'shield' },
  { label: 'Check Circle', value: 'check-circle' },
  { label: 'Alert Circle', value: 'alert-circle' },
];

registerBlockType('likewize/feature-grid', {
  edit: ({ attributes, setAttributes }) => {
    const { heading, description, columns, features } = attributes;
    const blockProps = useBlockProps({
      className: 'likewize-feature-grid-editor',
    });

    const updateFeature = (index, key, value) => {
      const newFeatures = [...features];
      newFeatures[index] = { ...newFeatures[index], [key]: value };
      setAttributes({ features: newFeatures });
    };

    const addFeature = () => {
      setAttributes({
        features: [
          ...features,
          {
            icon: 'circle',
            iconColor: '#003D7C',
            iconBgColor: '#F4F4F4',
            title: 'New Feature',
            description: 'Feature description',
          },
        ],
      });
    };

    const removeFeature = (index) => {
      const newFeatures = features.filter((_, i) => i !== index);
      setAttributes({ features: newFeatures });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('Grid Settings', 'likewize')} initialOpen={true}>
            <RangeControl
              label={__('Columns', 'likewize')}
              value={columns}
              onChange={(value) => setAttributes({ columns: value })}
              min={2}
              max={4}
            />
          </PanelBody>

          <PanelBody title={__('Features', 'likewize')} initialOpen={true}>
            {features.map((feature, index) => (
              <div key={index} style={{ marginBottom: '20px', paddingBottom: '20px', borderBottom: '1px solid #ddd' }}>
                <h4 style={{ marginBottom: '10px' }}>Feature {index + 1}</h4>

                <TextControl
                  label={__('Icon Name', 'likewize')}
                  value={feature.icon}
                  onChange={(value) => updateFeature(index, 'icon', value)}
                  help={__('Lucide icon name (e.g., droplets, smartphone-nfc)', 'likewize')}
                />

                <TextControl
                  label={__('Icon Color', 'likewize')}
                  value={feature.iconColor}
                  onChange={(value) => updateFeature(index, 'iconColor', value)}
                  type="color"
                />

                <TextControl
                  label={__('Icon Background', 'likewize')}
                  value={feature.iconBgColor}
                  onChange={(value) => updateFeature(index, 'iconBgColor', value)}
                  type="color"
                />

                <TextControl
                  label={__('Title', 'likewize')}
                  value={feature.title}
                  onChange={(value) => updateFeature(index, 'title', value)}
                />

                <TextareaControl
                  label={__('Description', 'likewize')}
                  value={feature.description}
                  onChange={(value) => updateFeature(index, 'description', value)}
                  rows={3}
                />

                <Button
                  isDestructive
                  onClick={() => removeFeature(index)}
                  style={{ marginTop: '10px' }}
                >
                  {__('Remove Feature', 'likewize')}
                </Button>
              </div>
            ))}

            <Button isPrimary onClick={addFeature}>
              {__('Add Feature', 'likewize')}
            </Button>
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="container">
            <div className="feature-grid-header text-center">
              <TextControl
                tagName="h2"
                value={heading}
                onChange={(value) => setAttributes({ heading: value })}
                placeholder={__('Enter heading...', 'likewize')}
                style={{ fontSize: '1.875rem', fontWeight: 'bold', marginBottom: '1rem' }}
              />

              <TextareaControl
                value={description}
                onChange={(value) => setAttributes({ description: value })}
                placeholder={__('Enter description...', 'likewize')}
                rows={2}
                style={{ color: '#64748b' }}
              />
            </div>

            <div
              className="feature-grid"
              style={{
                display: 'grid',
                gridTemplateColumns: `repeat(${columns}, 1fr)`,
                gap: '1.5rem',
              }}
            >
              {features.map((feature, index) => (
                <div key={index} className="feature-card" style={{ background: 'white', padding: '1.5rem', borderRadius: '0.75rem', border: '1px solid #f1f5f9' }}>
                  <div
                    className="icon-wrapper"
                    style={{
                      width: '3rem',
                      height: '3rem',
                      borderRadius: '0.5rem',
                      display: 'flex',
                      alignItems: 'center',
                      justifyContent: 'center',
                      marginBottom: '1rem',
                      backgroundColor: feature.iconBgColor,
                      color: feature.iconColor,
                    }}
                  >
                    <i data-lucide={feature.icon} style={{ width: '1.5rem', height: '1.5rem' }}></i>
                  </div>

                  <h3 style={{ fontSize: '1.125rem', fontWeight: 'bold', marginBottom: '0.5rem' }}>
                    {feature.title}
                  </h3>

                  <p style={{ fontSize: '0.875rem', color: '#64748b' }}>
                    {feature.description}
                  </p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </>
    );
  },

  save: () => null, // Dynamic block, rendered by PHP
});
