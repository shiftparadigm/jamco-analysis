/**
 * FAQ Accordion Block - Editor
 *
 * @package Likewize
 */

import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

registerBlockType('likewize/faq-accordion', {
  edit: ({ attributes, setAttributes }) => {
    const { heading, faqs } = attributes;
    const blockProps = useBlockProps({
      className: 'likewize-faq-accordion-editor',
    });

    const updateFAQ = (index, key, value) => {
      const newFAQs = [...faqs];
      newFAQs[index] = { ...newFAQs[index], [key]: value };
      setAttributes({ faqs: newFAQs });
    };

    const addFAQ = () => {
      setAttributes({
        faqs: [
          ...faqs,
          {
            question: 'New question?',
            answer: 'Answer goes here.',
          },
        ],
      });
    };

    const removeFAQ = (index) => {
      const newFAQs = faqs.filter((_, i) => i !== index);
      setAttributes({ faqs: newFAQs });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title={__('FAQ Items', 'likewize')} initialOpen={true}>
            {faqs.map((faq, index) => (
              <div key={index} style={{ marginBottom: '20px', paddingBottom: '20px', borderBottom: '1px solid #ddd' }}>
                <h4 style={{ marginBottom: '10px' }}>FAQ {index + 1}</h4>

                <TextControl
                  label={__('Question', 'likewize')}
                  value={faq.question}
                  onChange={(value) => updateFAQ(index, 'question', value)}
                />

                <TextareaControl
                  label={__('Answer', 'likewize')}
                  value={faq.answer}
                  onChange={(value) => updateFAQ(index, 'answer', value)}
                  rows={4}
                />

                <Button
                  isDestructive
                  onClick={() => removeFAQ(index)}
                  style={{ marginTop: '10px' }}
                >
                  {__('Remove FAQ', 'likewize')}
                </Button>
              </div>
            ))}

            <Button isPrimary onClick={addFAQ}>
              {__('Add FAQ', 'likewize')}
            </Button>
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          <div className="container" style={{ maxWidth: '48rem', margin: '0 auto', padding: '3rem 1.5rem', background: 'white' }}>
            <TextControl
              value={heading}
              onChange={(value) => setAttributes({ heading: value })}
              placeholder={__('Enter heading...', 'likewize')}
              style={{ fontSize: '1.875rem', fontWeight: 'bold', textAlign: 'center', marginBottom: '2rem' }}
            />

            <div className="faq-list" style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
              {faqs.map((faq, index) => (
                <div key={index} className="faq-item" style={{ border: '1px solid #e2e8f0', borderRadius: '0.5rem', overflow: 'hidden' }}>
                  <div
                    className="faq-question"
                    style={{
                      padding: '1.25rem',
                      background: '#f8fafc',
                      fontWeight: 'bold',
                      color: '#334155',
                      display: 'flex',
                      justifyContent: 'space-between',
                      alignItems: 'center',
                    }}
                  >
                    <span>{faq.question}</span>
                    <i data-lucide="chevron-down" style={{ width: '1.25rem', height: '1.25rem', color: '#94a3b8' }}></i>
                  </div>

                  <div
                    className="faq-answer"
                    style={{
                      padding: '1.25rem',
                      color: '#64748b',
                      borderTop: '1px solid #f1f5f9',
                      background: 'white',
                    }}
                  >
                    {faq.answer}
                  </div>
                </div>
              ))}
            </div>

            {faqs.length === 0 && (
              <p style={{ textAlign: 'center', color: '#94a3b8' }}>
                {__('No FAQs added yet. Add them in the block settings on the right.', 'likewize')}
              </p>
            )}
          </div>
        </div>
      </>
    );
  },

  save: () => null, // Dynamic block, rendered by PHP
});
