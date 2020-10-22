<?php
/**
 * Group of utility methods for use by Highlightjs
 * All methods are static, this is just a sort of namespacing class wrapper.
 */
class HLJS_Utils {

   /**
    * Returns a base64 URL for the svg for use in the menu
    * @param bool $base64 Whether or not to return base64'd output.
    * @return string
    */
   public static function get_icon_svg( $base64 = true, $color = false ) {
      $fill_tag = false === $color ? 'style="fill:#656565"' : "style=\"fill:{$color}\"";
      ob_start(); ?>
<svg width="512" height="512" viewBox="0 0 512 512" <?php echo $fill_tag; ?> xmlns="http://www.w3.org/2000/svg"><path d="m1 512l0-511 511 0 0 511z m250-91l1 1c6 2 12 3 18 3 6 1 11 2 14 2 23 0 40-6 52-18 12-12 18-30 18-54l0-178-53 0 0 176c0 9-1 16-5 21-3 5-8 7-16 7-4 0-8 0-11 0-4-1-7-2-10-3l0 0z m114-67l1 0c4 2 11 5 22 7 11 3 25 5 41 5 25 0 45-5 58-14 14-10 21-24 21-42 0-7-1-14-3-20-1-6-5-12-9-16-4-5-10-10-18-14-9-5-18-9-28-12-6-3-10-5-14-6-3-2-6-3-8-5-2-1-3-3-4-5-1-1-1-3-1-5 0-9 8-13 24-13 8 0 16 1 24 2 6 2 13 4 19 6l1 0 9-42 0 0c-8-3-17-5-25-6-11-2-21-3-32-3-23 0-41 5-53 15-13 10-20 24-20 41 0 9 1 17 4 23 3 6 6 12 11 17 5 4 11 8 17 11 7 4 14 7 22 10 11 4 19 7 24 11 5 3 7 6 7 10 0 5-2 9-5 11-4 1-11 2-20 2-10 0-19-1-28-3-9-2-18-4-27-8l-1 0z m-178-256l0 203c0 9 1 18 3 26 2 8 6 15 11 20 6 6 13 10 23 13 9 3 22 5 37 5l0 0 8-44-1 0c-6 0-11-1-15-3-3-1-6-3-8-6-2-3-3-6-4-9-1-4-1-9-1-13l0-201z m-98 119c12 0 20 4 24 10 4 7 6 19 6 36l0 98 53 0 0-104c1-12-1-24-3-35-2-10-7-19-13-27-6-7-15-13-24-17-10-4-22-6-37-6-6 0-11 0-16 1-5 1-9 2-13 3l0-88-53 9 0 264 53 0 0-140c3-1 6-2 10-3 5 0 9-1 13-1z m239-124c-9 0-17 3-23 8-6 6-9 13-9 23 0 10 3 17 9 23 13 11 32 11 45 0 6-6 9-13 9-23 0-10-3-17-9-23-6-5-14-8-22-8z m183-92l0 510-510 0 0-510 510 0m-499 361l54 0 0-141c3-1 7-1 10-2 5-1 9-1 13-1 12 0 19 3 23 10 5 6 7 18 7 35l0 98 54 0 0-104c0-12-1-24-4-35-2-10-6-19-12-27-7-8-15-14-25-18-10-4-22-6-37-6-6 0-11 1-16 2-5 1-9 2-13 3l0-88-1 0-52 8-1 0 0 266m250 4l0-1 7-43 0-1-1 0c-6-1-11-2-15-3-3-2-6-4-8-6-2-3-3-6-4-9 0-4-1-9-1-13l0-202-1 1-52 8-1 0 0 204c0 9 1 18 3 26 2 8 6 15 12 21 5 5 13 10 23 13 9 3 22 4 37 5l1 0m66-210c8 0 16-3 22-9 6-5 10-13 10-23 0-10-4-18-10-23-13-12-32-12-45 0-6 5-10 13-10 23 0 10 4 18 10 23 6 6 14 9 23 9m102 166c-10 0-19-1-28-3-9-2-18-5-27-8l-1-1 0 1-9 43 0 1 0 0c5 2 12 4 23 7 11 3 25 4 41 4 25 0 45-5 59-14 13-9 20-24 20-42 1-7 0-14-2-21-2-6-5-11-10-16-4-5-10-9-17-13-10-5-19-9-29-13-5-2-10-4-14-6-3-1-5-3-8-5-2-1-3-2-4-4-1-2-1-3-1-5 0-9 8-13 24-13 8 0 16 1 23 3 7 1 14 3 20 5l1 1 0-1 9-41 1-1-1 0c-8-3-16-5-25-7-11-2-21-3-32-3-23 0-41 5-54 16-13 10-19 24-19 41 0 9 1 17 4 23 2 7 6 12 11 17 5 5 11 9 17 12 7 3 14 6 22 9 11 4 18 8 23 11 5 3 8 6 8 10 0 5-2 8-6 10-3 2-10 3-20 3m-149 59c-4 0-8 0-11-1-4 0-7-1-10-2l-1-1 0 2-7 42 0 1 1 0c6 2 12 3 18 4 6 1 11 1 14 1 23 0 41-6 53-18 12-12 18-30 18-54l0-179-54 0 0 177c0 9-2 16-5 21-3 5-9 7-16 7m232-381l-512 0 0 512 512 0z m-499 361l0-264 52-8 0 88c5-1 9-2 14-3 5-1 10-2 16-2 15 0 27 2 37 6 10 4 18 10 24 18 6 7 10 17 12 26 3 12 4 23 4 35l0 104-52 0 0-98c0-17-2-29-7-36-4-7-12-10-24-10-4 0-8 0-13 1-4 1-8 2-11 3l0 140z m248 4c-15-1-28-2-37-5-10-3-17-7-23-13-5-5-9-12-11-20-2-9-3-17-3-26l0-203 52-8 0 200c0 4 1 9 1 13 1 3 2 6 4 9 3 3 6 5 9 7 4 1 9 2 15 3l-7 43z m67-210c-9 0-16-3-22-9-7-5-10-13-10-22 0-10 3-17 10-23 12-11 31-11 43 0 7 6 10 13 10 23 0 9-3 17-10 22-6 6-13 9-21 9z m102 168c9 0 16-1 20-3 4-2 6-6 6-11 0-4-3-8-8-11-5-3-13-7-23-11-8-2-15-5-23-9-6-3-12-7-17-12-4-4-8-10-10-16-3-6-4-14-4-23 0-17 6-31 19-41 13-10 30-15 53-15 11 0 21 1 32 3 8 2 17 4 24 7l-9 40c-6-2-13-4-19-5-8-2-16-3-24-3-17 0-25 5-25 14 0 2 0 4 1 6 1 1 3 3 4 4 3 2 6 4 9 5 4 2 8 4 14 6 9 3 19 8 28 13 8 4 13 8 18 13 4 4 7 10 9 16 2 6 3 13 3 20 0 18-7 32-21 41-14 10-33 14-58 14-16 0-30-1-41-4-11-3-18-5-22-7l9-42c8 3 18 6 27 8 9 2 18 3 27 3z m-150 59c8 0 13-3 17-7 3-5 5-12 5-22l0-176 52 0 0 178c0 24-6 42-18 54-12 11-29 17-52 17-3 0-8 0-14-1-6-1-12-2-18-4l7-42c3 1 6 2 10 2 3 1 7 1 11 1z"></path></svg>
      <?php $svg = ob_get_clean();
      if( $base64 ) {
         return 'data:image/svg+xml;base64,' . base64_encode( $svg );
      }
      return $svg;
   }

   /**
    * Notice
    * @param  array $args ['type', 'content', 'before_content', 'after_content', 'is_dismissible', 'echo']
    */
   public static function notice( $args ) {
      $defaults = [
         'type' => 'warning',
         'content' => '',
         'before_content' => '<p>',
         'after_content' => '</p>',
         'is_dismissible' => true,
         'inline' => false,
         'echo' => false,
      ];
      extract( wp_parse_args( $args, $defaults ) );

      $dismiss = $is_dismissible === true ? 'is-dismissible' : ''; 
      $inline = $inline === true ? 'inline' : ''; 
      $class = "custom-notice notice notice-{$type} $inline $dismiss";

      ob_start(); ?>
<div class="<?php echo $class ?>">
   <div class="inside-notice"><?php echo $before_content; ?><?php echo $content; ?><?php echo $after_content; ?></div>
   <?php if( $is_dismissible ): ?>
      <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e( 'Dismiss this notice.' ); ?></span></button>
   <?php endif; ?>
</div>

      <?php if( $echo ) {
         echo ob_get_clean();
      }
      else {
         return ob_get_clean();
      }
   }

   /**
    * wp_parse_args recursive for arrays
    * Values from $a override those from $b; keys in $b that don't exist
    * in $a are passed through.
    */
   public static function parse_arr( &$a, $b ) {
      $a = (array) $a;
      $b = (array) $b;
      $result = $b;
      foreach ( $a as $k => &$v ) {
         if ( is_array( $v ) && isset( $result[ $k ] ) ) {
            $result[ $k ] = self::parse_arr( $v, $result[ $k ] );
         } 
         else {
            $result[ $k ] = $v;
         }
      }
      return $result;
   }

}