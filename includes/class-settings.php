<?php
/**
 * Class settings
 * Dislay each tabson highlightjs admin page 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class HLJS_Settings {

   public function __construct( $admin ) {
      $this->textdomain = $admin->textdomain;
      $this->option = $admin->option;
      $this->ajax_nonce = $admin->ajax_nonce;
   }

   /**
    * Options tab
    */
   public function options() {
      $option = get_option( $this->option );
      ob_start(); ?>
<div class="wrap">
   <div class="postbox inside" id="hljs-metas">
      <table class="form-table">
         <h3 class="title"><?php _e( 'HighlightJS Metas' ); ?></h3>
         <tr>
            <th scope="row"><?php _e( 'Download page', $this->textdomain ); ?></th>
            <td><a href="https://highlightjs.org/download/" target="_blank">https://highlightjs.org/download/</a></td>
         </tr>
         <tr>
            <th scope="row">
               <?php _e( 'Version', $this->textdomain ); ?>
            </th>
            <td id="hljs-version">
               <?php echo $option['hljs_version']; ?>
            </td>
         </tr>
         <tr>
            <th scope="row">
               <?php _e( 'Languages', $this->textdomain ); ?>
            </th>
            <td id="hljs-languages">
               <?php echo implode( ', ', $option['hljs_languages'] ); ?>
            </td>
         </tr>
         <tr>
            <th scope="row">
               <?php _e( 'Styles', $this->textdomain ); ?>
            </th>
            <td id="hljs-styles">
               <?php echo implode( ', ', $option['hljs_styles'] ); ?>
            </td>
         </tr>
      </table>
      <button id="update-meta" class="hljsi-refresh"></button>
   </div>
   <div id="update-meta-response"></div>

   <form id="hljs-option" class="postbox inside">
      <table class="form-table">
         <h3 class="title"><?php _e( 'HighlightJS options', $this->textdomain ); ?></h3>
         <!-- Style -->
         <tr>
            <th scope="row"><?php _e( 'Style', $this->textdomain ); ?></th>
            <td>
               <select name="hljs_option[style]" id="hljs-option-style" />
               <?php foreach( $option['hljs_styles'] as $style ): ?>
                  <option value="<?php echo $style ?>" <?php selected( $option['hljs_option']['style'], $style ); ?>><?php echo ucfirst( $style ); ?></option>
               <?php endforeach; ?>
               </select>
            </td>
         </tr>
         <!-- Language -->
         <tr>
            <th scope="row"><?php _e( 'Language', $this->textdomain ); ?></th>
            <td>
               <select name="hljs_option[language]" id="hljs-option-language" />
               <?php foreach( $option['hljs_languages'] as $language ): ?>
                  <option value="<?php echo $language ?>" <?php selected( $option['hljs_option']['language'], $language ); ?>><?php echo ucfirst( $language ); ?></option>
               <?php endforeach; ?>
               </select>
            </td>
         </tr>
         <!-- Line height -->
         <tr>
            <th scope="row"><?php _e( 'Line height', $this->textdomain ); ?></th>
            <td>
               <input type="number" name="hljs_option[lineHeight]" class="small" value="<?php echo $option['hljs_option']['lineHeight']; ?>" placeholder="<?php echo esc_attr_e( 'line-height', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Font family -->
         <tr>
            <th scope="row"><?php _e( 'Font family', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="hljs_option[fontSize]" class="regular-text" value="<?php echo $option['hljs_option']['fontFamily']; ?>" placeholder="<?php echo esc_attr_e( 'font-family', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Font size -->
         <tr>
            <th scope="row"><?php _e( 'Font size', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="hljs_option[fontSize]" class="small" value="<?php echo $option['hljs_option']['fontSize']; ?>" placeholder="<?php echo esc_attr_e( 'font-size', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Padding -->
         <tr>
            <th scope="row"><?php _e( 'Padding', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="hljs_option[padding]" class="regular-text" value="<?php echo $option['hljs_option']['padding']; ?>" placeholder="<?php echo esc_attr_e( 'padding', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Line number color -->
         <tr>
            <th scope="row"><?php _e( 'Line number color', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="hljs_option[lineNumberColor]" class="regular-text color-picker" value="<?php echo $option['hljs_option']['lineNumberColor']; ?>" placeholder="<?php echo esc_attr_e( 'line number color', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Line number border color -->
         <tr>
            <th scope="row"><?php _e( 'Line number border color', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="hljs_option[lineNumberBorderColor]" class="regular-text color-picker" value="<?php echo $option['hljs_option']['lineNumberBorderColor']; ?>" placeholder="<?php echo esc_attr_e( 'line number border color', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Word break -->
         <tr>
            <th scope="row"><?php _e( 'Word break', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="hljs_option[wordBreak]" class="small" value="<?php echo $option['hljs_option']['wordBreak']; ?>" placeholder="<?php echo esc_attr_e( 'word-break', $this->textdomain ); ?>" />
            </td>
         </tr>
         <tr><td colspan="2">
            <p class="description"><?php _e( 'The other <em>options</em>: <code>showLineNumbers</code> to display line numbers, <code>firstLineNumber</code> the number of the first line, <code>tabSize</code> the tab size, <code>width</code> the width of the code element, <code>wrap</code> wrapping long lines of code, are inherited from <a id="ace-option-link" href="#ace-editor">ace editor</a> options.', $this->textdomain ); ?></p>
         </td></tr>
         <!-- Submit -->
         <tr><td colspan="2">
            <button type="submit" class="button button-primary"><?php _e( 'Save', $this->textdomain ); ?></button>
         </td></tr>
      </table>
   </form>
   <div id="hljs-option-response"></div>   
</div>
      <?php echo ob_get_clean();
   }

   /**
    * Options tab
    */
   public function uploads() {
      $option = get_option( $this->option );
      ob_start(); ?>
<div class="hljs-upload">
   <p><?php _e( 'This tab allows you to upload highlight.js in ZIP format, downloaded beforehand from <em>highlightjs.org</em> <a href="https://highlightjs.org/download/" target="_blank">download page</a>. This tool uploads and unzips the content to <code>/assets/repo/highlightjs</code> and may update your <em>highlight.js</em> version.', $this->textdomain ); ?></p>
   <p><?php printf( __( 'The current version of highlight.js is %s.' ), $option['version'] ); ?></p>
</div>
<div id="zipFileDropbox"
     class="dropbox hljs-upload">
   <p class="upload-message"><?php _e( 'Drop your zip file here or', $this->textdomain ); ?></p>
   <button id="zipFileSelect" class="button button-secondary"><?php _e( 'Choose zip file', $this->textdomain ); ?></button>
  <span id="zipFileName" 
        class="placeholder">
      <?php _e( 'No zip file chosen', $this->textdomain ); ?>
   </span>
   <input type="file" name="zipFile" /> 
</div>
<div class="button-wrap">
   <button disabled id="uploadZipFile" class="button button-primary">
      <?php _e( 'Upload highlight.js', $this->textdomain ); ?>
   </button>
</div>
<div id="uploadZipFileResponse" class="hljs-upload"></div>

      <?php echo ob_get_clean();

   }

   /**
    * Ace editor tab
    */
   public function editor() {
      $option = get_option( $this->option );
      ob_start(); ?>
<div class="wrap">
   <div id="ace-metas" class="postbox inside">
      <table class="form-table">
         <h3 class="title"><?php _e( 'Ace Editor Metas' ); ?></h3>
         <tr>
            <th scope="row">
               <?php _e( 'Version', $this->textdomain ); ?>
            </th>
            <td id="ace-version">
               <?php echo $option['ace_version']; ?>
            </td>
         </tr>
         <tr>
            <th scope="row">
               <?php _e( 'Modes', $this->textdomain ); ?>
            </th>
            <td id="ace-modes">
               <?php echo implode( ', ', $option['ace_modes'] ); ?>
            </td>
         </tr>
         <tr>
            <th scope="row">
               <?php _e( 'Themes', $this->textdomain ); ?>
            </th>
            <td id="ace-themes">
               <?php echo implode( ', ', $option['ace_themes'] ); ?>
            </td>
         </tr>
      </table>
      <button id="update-ace-meta" class="hljsi-refresh"></button>
   </div>
   <div id="update-ace-meta-response"></div>

   <form id="ace-option" class="postbox inside">
      <table class="form-table">
         <h3 class="title"><?php _e( 'Ace editor options', $this->textdomain ); ?></h3>
         <!-- Placeholder -->
         <tr>
            <th scope="row"><?php _e( 'Placeholder', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="ace_option[placeholder]" class="regular-text" value="<?php echo esc_attr( $option['ace_option']['placeholder'] ); ?>" placeholder="<?php esc_attr_e( 'Placeholder', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Theme -->
         <tr>
            <th scope="row"><?php _e( 'Theme', $this->textdomain ); ?></th>
            <td>
               <select name="ace_option[theme]" id="ace-option-theme" />
               <?php foreach( $option['ace_themes'] as $theme ): ?>
                  <option value="<?php echo $theme ?>" <?php selected( $option['ace_option']['theme'], $theme ); ?>><?php echo ucfirst( $theme ); ?></option>
               <?php endforeach; ?>
               </select>
            </td>
         </tr>
         <!-- Mode -->
         <tr>
            <th scope="row"><?php _e( 'Mode', $this->textdomain ); ?></th>
            <td>
               <select name="ace_option[mode]" id="ace-option-mode" />
               <?php foreach( $option['ace_modes'] as $mode ): ?>
                  <option value="<?php echo $mode; ?>" <?php selected( $option['ace_option']['mode'], $mode ); ?>><?php echo ucfirst( $mode ); ?></option>
               <?php endforeach; ?>   
               </select>
            </td>
         </tr>
         <!-- Font Family -->
         <tr>
            <th scope="row"><?php _e( 'Font family', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="ace_option[fontFamily]" class="regular-text" value="<?php echo esc_attr( $option['ace_option']['fontFamily'] ); ?>" placeholder="<?php echo 'font-family'; ?>" />
            </td>
         </tr>
         <!-- Font Size -->
         <tr>
            <th scope="row"><?php _e( 'Font size', $this->textdomain ); ?></th>
            <td>
               <input type="number" name="ace_option[fontSize]" class="small" value="<?php echo esc_attr( $option['ace_option']['fontSize'] ); ?>" placeholder="<?php echo 'font-size'; ?>" />
            </td>
         </tr>
         <!-- Show line numbers -->
         <tr>
            <th scope="row"><?php _e( 'Show line numbers', $this->textdomain ); ?></th>
            <td>
               <input type="checkbox" name="ace_option[showLineNumbers]" class="toggle" <?php checked( $option['ace_option']['showLineNumbers'] ); ?> value="1" />
            </td>
         </tr>
         <!-- First Line Number -->
         <tr>
            <th scope="row"><?php _e( 'First line number', $this->textdomain ); ?></th>
            <td>
               <input type="number" name="ace_option[firstLineNumber]" class="small" value="<?php echo $option['ace_option']['firstLineNumber']; ?>" placeholder="<?php echo esc_attr_e( 'first line number', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Tab Size -->
         <tr>
            <th scope="row"><?php _e( 'Tab size', $this->textdomain ); ?></th>
            <td>
               <input type="number" name="ace_option[tabSize]" class="small" value="<?php echo $option['ace_option']['tabSize']; ?>" placeholder="<?php echo esc_attr_e( 'tab size', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Min lines -->
         <tr>
            <th scope="row"><?php _e( 'Min lines', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="ace_option[minLines]" class="small" value="<?php echo esc_attr( $option['ace_option']['minLines'] ); ?>" placeholder="<?php echo esc_attr_e( 'min lines', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Max lines -->
         <tr>
            <th scope="row"><?php _e( 'Max lines', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="ace_option[maxLines]" class="small" value="<?php echo esc_attr( $option['ace_option']['maxLines'] ); ?>" placeholder="<?php echo esc_attr_e( 'max lines', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Width -->
         <tr>
            <th scope="row"><?php _e( 'Width', $this->textdomain ); ?></th>
            <td>
               <input type="text" name="ace_option[width]" class="small" value="<?php echo esc_attr( $option['ace_option']['width'] ); ?>" placeholder="<?php echo esc_attr_e( 'width', $this->textdomain ); ?>" />
            </td>
         </tr>
         <!-- Show gutter -->
         <tr>
            <th scope="row"><?php _e( 'Show gutter', $this->textdomain ); ?></th>
            <td>
               <input type="checkbox" name="ace_option[showGutter]" class="toggle" <?php checked( $option['ace_option']['showGutter'] ); ?> value="1" />
            </td>
         </tr>
         <!-- Wrap -->
         <tr>
            <th scope="row"><?php _e( 'Wrap long lines', $this->textdomain ); ?></th>
            <td>
               <input type="checkbox" name="ace_option[wrap]" class="toggle" <?php checked( $option['ace_option']['wrap'] ); ?> value="1" />
            </td>
         </tr>
         <!-- Use worker -->
         <tr>
            <th scope="row"><?php _e( 'Use worker', $this->textdomain ); ?></th>
            <td>
               <input type="checkbox" name="ace_option[useWorker]" class="toggle" <?php checked( $option['ace_option']['useWorker'] ); ?> value="1" />
               <span class="description"><?php _e( 'Show code errors', $this->textdomain ); ?></span>
            </td>
         </tr>
         <tr><td colspan="2">
            <button type="submit" class="button button-primary"><?php _e( 'Save', $this->textdomain ); ?></button>
         </td></tr>
      </table>
   </form>
   <div id="ace-option-response"></div>
</div>
      <?php echo ob_get_clean();
   }

   /**
    * Informations tab
    */
   public function informations() {

   }


}