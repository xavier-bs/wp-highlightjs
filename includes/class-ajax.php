<?php
/**
 * Class admin ajax
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class HLJS_Ajax {

   public function __construct( $ajax ) {
      $this->ajax_nonce = $ajax->ajax_nonce;
      $this->textdomain = $ajax->textdomain;
      $this->option = $ajax->option;
      $this->repo = HighLight::dir( 'assets/repo/' );
      add_action( 'wp_ajax_hljs-option', [$this, 'hljs_option'] );
   }

   /**
    * Ajax
    */
   public function hljs_option() {
      $json = [];
      $check =check_ajax_referer( $this->ajax_nonce, 'security', false );
      if( $check !== 1 ) {
         $json['response'] = HLJS_Utils::notice([
            'type' => 'warning',
            'before_content' => '<p class="exclamation-triangle">',
            'content' => __( 'Ajax nonce is not valid, reload the page', $this->textdomain ),
         ]);
         echo json_encode( $json );
         wp_die();
      }

      extract( $_POST );

      switch( $method ) {

         case 'update-meta':
            $meta = $this->getHighlightJSMeta();
            $option = get_option( $this->option );

            update_option( $this->option, HLJS_Utils::parse_arr( $meta, $option ) );
            $json['version'] = $meta['hljs_version'];
            $json['styles'] = implode( ', ', $meta['hljs_styles'] );
            $json['select_style'] = '';
            foreach( $meta['hljs_styles'] as $style ) {
               $json['select_style'] .= "<option value=\"{$style}\"" . selected( $option['hljs_option']['style'], $style, false ) . '>' . ucfirst( $style ) . "</option>\n"; 
            }
            $json['languages'] = implode( ', ', $meta['hljs_languages'] );
            $json['select_language'] = '';
            foreach( $meta['hljs_languages'] as $language ) {
               $json['select_language'] .= "<option value=\"{$language}\"" . selected( $option['hljs_option']['language'], $language, false ) . '>' .ucfirst( $language ) . "</option>\n";
            }
            $json['response'] = HLJS_Utils::notice([
               'type' => 'success',
               'before_content' => '<p class="check">',
               'content' => __( 'HighlightJS metas are updated.', $this->textdomain ),
            ]);
            break;

         case 'update-ace-meta':
            $meta = $this->getAceMeta();
            if( is_wp_error( $meta ) ) {
               $json['response'] = HLJS_Utils::notice([
                  'type' => 'error',
                  'before_content' => '<p class="hljsi-close">',
                  'content' => $meta->get_error_message(),
               ]);
               break;
            }
            $option = get_option( $this->option );
            update_option( $this->option, HLJS_Utils::parse_arr( $meta, $option ) );
            $json['response'] = HLJS_Utils::notice([
               'type' => 'success',
               'before_content' => '<p class="check">',
               'content' => __( 'Ace metas are updated.', $this->textdomain ),²
            ]);
            $json['version'] = $meta['ace_version'];
            $json['themes'] = implode( ', ', $meta['ace_themes'] );
            $json['modes'] = implode( ', ', $meta['ace_modes'] );
            $json['select_theme'] = '';
            foreach( $meta['ace_themes'] as $theme ) {
               $json['select_theme'] .= "<option value=\"{$theme}\"" . selected( $option['ace_option']['theme'], $theme, false ) . '>' . ucfirst( $theme ) . "</option>\n"; 
            }
            $json['select_mode'] = '';
            foreach( $meta['ace_modes'] as $mode ) {
               $json['select_mode'] .= "<option value=\"{$mode}\"" . selected( $option['ace_option']['mode'], $mode, false ) . '>' . ucfirst( $mode ) . "</option>\n"; 
            }

            break;

         case 'upload-highlightjs':
            $json['response'] = '';
            if( $_FILES['zip']['type'] == 'application/x-zip-compressed' && ! $_FILES['zip']['error'] ) {
               $name = basename( $_FILES['zip']['name'] );
               $file = str_replace( [' ',')','('], '', "{$this->repo}/{$name}" );
               if( file_exists( $file ) ) {
                  unlink( $file );
                  $json['response'] .= HLJS_Utils::notice([
                     'type' => 'success',
                     'before_content' => '<p class="hljsi-check hljs-icon-notification">',
                     'content' => __( 'ZIP already exists, it has been deleted.' )
                  ]);
               }
               if( move_uploaded_file( $_FILES['zip']['tmp_name'], $file ) ) {
                  chmod( $file, 0664 );
                  $response = sprintf( __( 'ZIP file <code>%s</code> was moved to <code>%s</code>. ', $this->textdomain ), $name, $this->repo );
                  $response .= $this->manage_zip_upload( $file );
                  $json['response'] .= HLJS_Utils::notice([
                     'type' => 'success',
                     'before_content' => '<p class="hljsi-check hljs-icon-notification">',
                     'content' => $response,
                  ]);
                  // Updates option version...
                  $meta = $this->getHighlightJSMeta();
                  $option = get_option( $this->option );
                  update_option( $this->option, HLJS_Utils::parse_arr( $meta, $option ) );
                  $json['version'] = $meta['version'];
                  $json['languages'] = implode( ', ', $meta['languages'] );
                  $json['styles'] = implode( ', ', $meta['styles'] );
               }
               else {
                  $json['response'] .= HLJS_Utils::notice([
                     'type' => 'error',
                     'before_content' => '<p class="hljsi-close hljs-icon-notification">',
                     'content' => sprintf( __( 'Error while moving tmp zip file, <code>%s</code> to <code>%s</code>.', $this->textdomain ), $name, $file ),
                  ]);
               }
            }
            else {
               $json['response'] = HLJS_Utils::notice([
                  'type' => 'error',
                  'before_content' => '<p class="hljsi-exclamation-triangle hljs-icon-notification">',
                  'content' => __( 'An error occurred, the file is not of ZIP type or there was an error uploading it.', $this->textdomain ),
               ]);
            }
            break;

         case 'save-hljs-option':
            wp_parse_str( $data, $sent );
            $option = get_option( $this->option );
            update_option( $this->option, HLJS_Utils::parse_arr( $sent, $option ) );
            $json['response'] = HLJS_Utils::notice([
               'type' => 'success',
               'before_content' => '<p class="hljsi-check hljs-icon-notification">',
               'content' => __( '<code>highlightjs[\'hljs_option\']</code> option was updated.', $this->textdomain ),
            ]);

            break;

         case 'save-ace-option':
            wp_parse_str( $data, $sent );
            // Checkboxes
            foreach( ['showLineNumbers', 
                      'showGutter', 
                      'wrap', 
                      'useWorker'] as $attr ) {
               if( empty( $sent['ace_option'][$attr] ) ) {
                  $sent['ace_option'][$attr] = 0;
               }
            }
            $option = get_option( $this->option );
            update_option( $this->option, HLJS_Utils::parse_arr( $sent, $option ) );
            $json['response'] = HLJS_Utils::notice([
               'type' => 'success',
               'before_content' => '<p class="hljsi-check hljs-icon-notification">',
               'content' => __( '<code>highlightjs[\'ace_option\']</code> option was updated.', $this->textdomain ),
            ]);

            break;

      }

      echo json_encode( $json );
      wp_die();
   }

   /**
    * Get HighlightJS Meta: Version
    * @return  array 'version', 'languages'[], 'styles'[]
    */
   public function getHighlightJSMeta() {
      $jsfile = "{$this->repo}/highlightjs/highlight.pack.js";
      $content = file_get_contents( $jsfile );
      $meta = [];
      // Gets version
      if( preg_match( '/Highlight\.js\s(\S+)/', $content, $match ) ) {
         $meta['hljs_version'] = $match[1];
      }
      // Gets languages
      if( preg_match_all( '/registerLanguage\("([a-z-_]+)"/', $content, $match ) ) {
         $meta['hljs_languages'] = $match[1];
      }
      // Gets styles
      chdir( "{$this->repo}/highlightjs/styles" );
      $meta['hljs_styles'] = array_map( function( $file ) {
         return str_replace( '.css', '', $file ); }, 
         glob( '*.css' ) );

      return $meta;
   }

   /**
    * Get React Ace Metas
    * @return  array 'ace_version', 'ace_modes'[], 'ace_themes'[] 
    */
   public function getAceMeta() {
      $folder = Highlight::dir( 'assets/syntax/node_modules/ace-builds' );
      $pkgJson = file_get_contents( "{$folder}/package.json" );
      if( false == $pkgJson ) {
         return new WP_Error( 'meta', sprintf( __( '%s cannot be read. '), "{$folder}/package.json" ) );
      }
      else {
         $pkgJson = json_decode( $pkgJson );
         $meta['ace_version'] = $pkgJson->version;
      }

      $folder .= '/src-noconflict/';
      $meta['ace_themes'] = array_map( function( $file ) {
         return preg_replace( "/.+\/theme-(\w+)\.js/", "$1", $file );
      }, glob( $folder . "theme*.js" ) );
      $meta['ace_modes'] = array_map( function( $file ) {
         return preg_replace( "/.+\/mode-(\w+)\.js/", "$1", $file );
      }, glob( $folder . "mode*.js" ) );

      return $meta;
   }

   /**
    * Removes a directory that is not empty
    * @param string directory path
    * @return  bool true/false
    */
   public function rmdir( $dir ) {
    
      if( ! is_dir( $dir ) ) {
         return false;
      }
    
      $dirIterator = new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS );
      $iterator = new RecursiveIteratorIterator( $dirIterator, RecursiveIteratorIterator::CHILD_FIRST );
    
      foreach( $iterator as $fileInfo ) {
         if( $fileInfo->isDir() ) {
            if( ! rmdir( $fileInfo->getPathname() ) ) {
               return false;
            }
         }
         else {
            if( ! unlink( $fileInfo->getPathname() ) ) {
               return false;
            }
         }
      }
      if( ! rmdir( $dir ) ) {
         return false;
      }
      return true;
   }

   /**
    * Deletes highlightjs-backup if it exists
    * Backup old highlighjs folder to highlighjs-backup
    * Unzips highlightjs zip to highlightjs folder
    * @param  string $zipFile path
    * @return  string response
    */
   protected function manage_zip_upload( $zipFile ) {
      // Renames highlightjs folder
      $highlightjs = "{$this->repo}/highlightjs";
      $backup = "{$this->repo}/highlightjs-backup";
      if( file_exists( $backup ) ) {
         $this->rmdir( $backup );
      }
      if( ! rename( $highlightjs, $backup ) ) {
         return sprintf( __( 'Cannot rename <code>%s</code> to <code>%s</code>. ', $this->textdomain ), basename( $highlightjs ), basename( $backup ) );
      }
      // Creates highlightjs folder
      mkdir( $highlightjs );
      // Unzips $zipFile to $highlightjs
      $zip = new ZipArchive;
      if( true === $zip->open( $zipFile ) ) {
         $response .= __( 'ZIP file has been opened. ', $this->textdomain );
         if( true === $zip->extractTo( $highlightjs ) ) {
            $response .= __( 'ZIP file successfully extracted. ', $this->textdomain );
            $zip->close();
         }
         else {
            $response .= sprintf( __( 'ZIP file cannot be extracted to <code>%s</code>. ', $this->textdomain ), basename( $highlightjs ) );
         }
      }
      else {
         $response .= __( 'ZIP file cannot be opened. ', $this->textdomain );
      }
      // Unlinks zipFile
      unlink( $zipFile );
      return $response;

   }


}