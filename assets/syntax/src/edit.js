/*
 * edit.js
 * displayed in the editor
 * HLJS is defined in class-admin.php
 */
import AceEditor from 'react-ace';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/editor';
import { Panel,
         PanelBody, 
         PanelRow,
         ToggleControl,
         SelectControl, 
         TextControl, 
         CheckboxControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
// import React from 'react';
// import Select from 'react-select';

const textdomain = HLJS.textdomain;

// import 'ace-builds/webpack-resolver';
import './resolver';

const edit = props => {
   const { attributes, setAttributes } = props;
   const {
      title,
      showButtonCopy
   } = attributes;

// fontFamily, fontSize

   const { 
      code,
      placeholder, 
      theme, 
      mode,
      aceFontFamily,
      aceFontSize, 
      showLineNumbers, 
      tabSize,
      firstLineNumber,
      minLines,
      maxLines, 
      width,
      wrap,
      useWorker
   } = attributes.ace;
   const {
      style,
      language,
      hljsFontFamily,
      hljsFontSize,
      lineHeight,
      padding,
      lineNumberColor,
      lineNumberBorderColor,
      wordBreak
   } = attributes.highlightjs;

   let aceModes = HLJS.option.ace_modes.map(value => {
      return {label: `${value[0].toUpperCase()}${value.substring(1)}`, value};
   });
   aceModes.unshift({label: __('No mode', textdomain), value: ''});

   let aceThemes = HLJS.option.ace_themes.map(value => {
      return {label: `${value[0].toUpperCase()}${value.substring(1)}`, value};
   });
   aceThemes.unshift({label: __('No theme', textdomain), value: ''});

   let hljsLanguages = HLJS.option.hljs_languages.map(value => {
      return {label: `${value[0].toUpperCase()}${value.substring(1)}`, value};
   });
   hljsLanguages.unshift({label: __('Default', textdomain), value: ''});

   let hljsStyles = HLJS.option.hljs_styles.map(value => {
      return {label: `${value[0].toUpperCase()}${value.substring(1)}`, value};
   });
   hljsStyles.unshift({label: __('Default', textdomain), value: ''});


   return <Fragment>
             <InspectorControls>
               <Panel title={__('HighLightJS', textdomain)}>
                  {/* Title and button copy */}
                  <PanelBody
                     title={__( 'Title')}
                     initialOpen={false}>
                     {/* Title */}
                     <PanelRow>
                        <TextControl
                           label={__('Title', textdomain)}
                           placeholder={__('Leave blank to not activate', textdomain)}
                           type="text"
                           value={title}
                           onChange={newValue => setAttributes({title: newValue})}
                        />
                     </PanelRow>
                     {/* Button copy */}
                     <PanelRow>
                        <ToggleControl
                           label={__('Show button copy', textdomain)}
                           checked={showButtonCopy}
                           onChange={newValue => setAttributes({showButtonCopy: newValue})}
                        />
                     </PanelRow>
                  </PanelBody>
                  {/* Ace */}
                  <PanelBody
                     title={__( 'Ace editor backend', textdomain )}
                     icon="edit"
                     initialOpen={false}>
                     {/* Show line numbers*/}
                     <PanelRow>
                        <ToggleControl
                           label={__('Show line numbers', textdomain)}
                           checked={showLineNumbers}
                           onChange={newValue => {
                                 const newShowLineNumbers = {showLineNumbers: newValue};
                                 setAttributes({ace: { ...attributes.ace, ...newShowLineNumbers}});
                              }
                           }
                        />
                     </PanelRow>
                     {/* First line number */}
                     {showLineNumbers &&
                        <PanelRow>
                           <TextControl
                              label={__('First Line Number', textdomain)}
                              type="number"
                              value={firstLineNumber}
                              onChange={newValue => {
                                    const newFirstLineNumber = {firstLineNumber: newValue};
                                    setAttributes({ace: { ...attributes.ace, ...newFirstLineNumber}});
                                 }
                              }
                           />
                        </PanelRow>
                     }
                     {/* Mode */}
                     <PanelRow>
                        <SelectControl
                           label={__('Languages', textdomain)}
                           value={mode}
                           options={aceModes}
                           onChange={newValue => {
                                 const newMode = {mode: newValue};
                                 setAttributes({ace: { ...attributes.ace, ...newMode}});
                              }
                           }
                        />
                     </PanelRow>
                     {/* Test Select2 on Mode
                     <PanelRow>
                        <Select
                           label={__('Test Select2 Languages', textdomain)}
                           value={mode}
                           options={aceModes}
                           onChange={newValue => {
                                 const newMode = {mode: newValue};
                                 setAttributes({ace: { ...attributes.ace, ...newMode}});
                              }
                           }
                           style="width: 100%" 
                        />
                     </PanelRow>
                      */}
                     {/* Theme */}
                     <PanelRow>
                        <SelectControl
                           label={__('Theme', textdomain)}
                           value={theme}
                           options={aceThemes}
                           onChange={newValue => {
                                 const newMode = {theme: newValue};
                                 setAttributes({ace: { ...attributes.ace, ...newMode}});
                              }
                           }
                        />
                     </PanelRow>
                  </PanelBody>
                  {/*HighLight JS */}
                  <PanelBody
                     title={__('HighlightJS frontend', textdomain)}
                     icon="visibility"
                     initialOpen={false}>
                     {/* Language */}
                     <PanelRow>
                        <SelectControl
                           label={__('Language', textdomain)}
                           value={language}
                           options={hljsLanguages}
                           onChange={newValue => {
                                 const newLanguage = {language: newValue};
                                 setAttributes({highlightjs: { ...attributes.ace, ...newLanguage}});
                              }
                           }
                        />
                     </PanelRow>
                     {/* Style */}
                     <PanelRow>
                        <SelectControl
                           label={__('Style', textdomain)}
                           value={style}
                           options={hljsStyles}
                           onChange={newValue => {
                                 const newStyle = {style: newValue};
                                 setAttributes({highlightjs: { ...attributes.highlightjs, ...newStyle}});
                              }
                           }
                        />
                     </PanelRow>
                     {/* font-family */}
                     <PanelRow>
                        <TextControl
                           label={__('Font family', textdomain)}
                           type="text"
                           value={hljsFontFamily}
                           onChange={newValue => {
                                 const newFontFamily = {hljsFontFamily: newValue};
                                 setAttributes({highlightjs: { ...attributes.highlightjs, ...newFontFamily}});
                              }
                           }
                        />
                     </PanelRow>
                     {/* font-size */}
                     <PanelRow>
                        <TextControl
                           label={__('Font size', textdomain)}
                           type="text"
                           value={hljsFontSize}
                           onChange={newValue => {
                                 const newFontSize = {style: newValue};
                                 setAttributes({highlightjs: { ...attributes.highlightjs, ...newFontSize}});
                              }
                           }
                        />
                     </PanelRow>
                  </PanelBody>
               </Panel>
             </InspectorControls>
             <AceEditor
               name={() => {
   const ind = document.querySelectorAll('[id^="ace-code"]').length + 1;
   return "ace-code-" + ind; }} // UNIQUE_ID_OF_DIV, doesn't seem to work, TODO improvement. No ID to created div.ace_editor is assigned.
               placeholder={placeholder}
               mode={mode}
               theme={theme}
               width={width}
               value={code}
               onChange={newValue => {
                  const newCode = {code: newValue};
                  setAttributes({ace: { ...attributes.ace, ...newCode }});
               }}
               editorProps={{$blockScrolling: true }}
               setOptions={{
                  fontFamily: aceFontFamily,
                  fontSize: aceFontSize,
                  firstLineNumber: parseInt(firstLineNumber),
                  minLines,
                  maxLines,
                  showLineNumbers,
                  tabSize,
                  wrap,
                  useWorker
               }}
             />
          </Fragment>
}

export default edit;
