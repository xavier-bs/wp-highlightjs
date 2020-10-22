/*
 * What is saved in editor (html) to displayed on frontend
 * save.js
 */

// import SyntaxHighlighter from 'react-syntax-highlighter';
// import { agate } from 'react-syntax-highlighter/dist/esm/styles/hljs';
import AceEditor from 'react-ace';

import { Fragment } from '@wordpress/element';

// import 'ace-builds/webpack-resolver';
// import './resolver';

const save = props => {
   // return <h2>How am I looking on the front End</h2>
   const { attributes } = props;
   const {
      title,
      showButtonCopy
   } = attributes;
   const { 
      code,
      mode,
      theme,
      fontFamily: hljsFontFamily,
      fontSize: hljsFontSize,
      showLineNumbers,
      tabSize,
      firstLineNumber,
      width,
      wrap
   } = attributes.ace;
   const {
      lineHeight,
      style,
      language,
   } = attributes.highlightjs;
   const whiteSpace = wrap ? 'pre-wrap' : 'none';
   const preStyle = {
      lineHeight,
      width,
      whiteSpace
   };
   const codeStyle = {
      fontFamily: hljsFontFamily,
      fontSize: hljsFontSize,
   };
   return <div data-hljs={style}>
             {title.length > 0 && <p className="hljs title">{title}</p>}
             <pre style={preStyle} className={style}>
               <code 
                 className={language}
                 data-show-line-numbers={showLineNumbers}
                 data-first-line-number={firstLineNumber} 
                 style={codeStyle}>
                    {code}
               </code>
             </pre>
          </div>
}
  
export default save;