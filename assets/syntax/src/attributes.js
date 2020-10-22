/*
 * Attributes
 * HLJS is defined in highlightj option in class-admin.php
 */
import { __ } from '@wordpress/i18n';
const textdomain = HLJS.textdomain;

const attributes = {
   // Ace is the editor in Gutenberg
   title: {
      type: 'string',
      default: '',      // The title
   },
   showButtonCopy: {
      type: 'boolean',
      default: false,
   },
   ace: {
      type: 'object',
      default: {
         code: '',       // The code
         name: 'ace-1',  // Unique ID of DIV
         placeholder: HLJS.option.ace_option.placeholder,
         theme: HLJS.option.ace_option.theme,
         mode: HLJS.option.ace_option.mode,
         aceFontFamily: HLJS.option.ace_option.fontFamily,
         aceFontSize: parseInt(HLJS.option.ace_option.fontSize),
         firstLineNumber: parseInt(HLJS.option.ace_option.firstLineNumber),
         minLines: parseInt(HLJS.option.ace_option.minLines),
         maxLines: HLJS.option.ace_option.maxLines,
         showLineNumbers: HLJS.option.ace_option.showLineNumbers == '1',
         tabSize: parseInt(HLJS.option.ace_option.tabSize),
         width: HLJS.option.ace_option.width,
         showGutter: HLJS.option.ace_option.showGutter == '1',
         wrap: HLJS.option.ace_option.wrap == '1',
         useWorker: HLJS.option.ace_option.useWorker == '1',   // Display errors in gutter
      },
   },

   // highlightjs code syntax displayed in the frontend
   highlightjs: {
      type: 'object',
      default: {
         style: HLJS.option.hljs_option.style,
         language: HLJS.option.hljs_option.language,
         hljsFontFamily: HLJS.option.hljs_option.fontFamily,
         hljsFontSize: HLJS.option.hljs_option.fontSize,
         lineHeight: HLJS.option.hljs_option.lineHeight,
         padding: HLJS.option.hljs_option.padding,
         lineNumberColor: HLJS.option.hljs_option.lineNumberColor,
         lineNumberBorderColor: HLJS.option.hljs_option.lineNumberBorderColor,
         wordBreak: HLJS.option.hljs_option.wordBreak,
      },
   },
};

export default attributes;
