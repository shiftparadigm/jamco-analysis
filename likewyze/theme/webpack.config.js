/**
 * WordPress Dependencies
 */
const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const path = require('path');

module.exports = {
    ...defaultConfig,
    entry: {
        'blocks/hero/index': './blocks/hero/index.js',
        'blocks/feature-grid/index': './blocks/feature-grid/index.js',
        'blocks/process-steps/index': './blocks/process-steps/index.js',
        'blocks/pricing-table/index': './blocks/pricing-table/index.js',
        'blocks/faq-accordion/index': './blocks/faq-accordion/index.js',
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, 'build'),
    },
};
