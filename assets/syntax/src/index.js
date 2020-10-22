/*
 * Main file index.js
 */

import edit from './edit.js';
import save from './save.js';
import icon from './icon.js';
import attributes from './attributes.js';
import supports from './supports.js';

// const { __ } = wp.i18n;
import { __ } from '@wordpress/i18n'
// const { registerBlockType } = wp.blocks;
import { registerBlockType } from '@wordpress/blocks';

const textdomain = HLJS.textdomain;

registerBlockType('highlight/js', {
   title: __( 'Code HighlightJS', textdomain ),
   description: __( 'Syntax highlighting with highlightJS', textdomain ),
   icon,
   category: 'layout',
   supports,
   attributes,
   edit,
   save,
});