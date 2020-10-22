<?php
/**
 * Class Frontend
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class HLJS_Frontend {

   public function __construct( $hljs ) {
      $this->textdomain = $hljs->textdomain;
      $this->hightlight_version = '10.1.1';

      // Scripts
      add_action( 'wp_enqueue_scripts', [$this, 'wp_enqueue_scripts'] );
      add_action( 'wp_head', [$this, 'wp_head'] );


   }

   public function wp_enqueue_scripts() {
      global $post;
      // echo "post->post_content<pre>"; print_r( htmlentities( $post->post_content ) ); echo "</pre>\n"; die();
      if( preg_match( '/data-hljs=/', $post->post_content, $match ) ) {
         wp_register_style( "hljs-line", HighLight::url( "assets/repo/hljsLineNumbers/hljsLineNumbers.css'"), [], $this->hightlight_version );
         wp_enqueue_style( "hljs-line" );

      }

      wp_register_script( 'highlight', HighLight::url( 'assets/repo/highlightjs/highlight.pack.js' ) , [], $this->hightlight_version );
      wp_register_script( 'hljs-front', HighLight::url( 'assets/js/frontend.js' ) , ['highlight'], $this->hightlight_version );

      wp_enqueue_script( 'highlight' );
      wp_enqueue_script( 'hljs-front' );
   }

   public function wp_head() {
      global $post;
      if( preg_match_all( '/data-hljs="([\w-]+)"/', $post->post_content, $match ) ) {
         /* 
          * Prefixes and minifies highlightjs style, for multiple code styles on the same page.
          */
         foreach( $match[1] as $key => $style ) {
            $path = HighLight::dir( "assets/repo/highlightjs/styles/{$style}.css" );
            $min = $this->prefix_min_css( $path, $style );
            echo "\n<style>{$min}</style>\n";
         }
       }
   }

      /**
    * minimizes css and prefixes classes
    * @param  string $path
    * @return string minimized css
    */
   protected function prefix_min_css( $path, $prefix ) {

      $buffer = file_get_contents( $path );

      $pattern = [
         '/\.hljs/',             // Prefix classes
         '/\/\*(.+?)\*\//s',     // Skip comments
         '/[\r\n\t]/',           // Line return, tab
         '/\s*([\{\}\:;,])\s*/'  // blanks
      ];
      $replace = [
         ".{$prefix} .hljs",
         '', 
         '', 
         '$1',
      ];

      $buffer = preg_replace( $pattern, $replace, $buffer );
      return $buffer;
   }


}
