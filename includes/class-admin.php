<?php
/**
 * Class admin
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class HLJS_Admin {

   public function __construct( $hljs ) {
      $this->textdomain = $hljs->textdomain;
      $this->option = 'highlightjs';
      $this->ajax_nonce = 'Mes3SuperBombesDAmour';

      $this->page = (object) [
         'top' => (object) [
            'title'    => __( 'Highlight JS', $this->textdomain ),
            'menu'     => __( 'Highlight JS', $this->textdomain ),
            'cap'      => 'edit_posts',
            'slug'     => 'highlightjs',
            'callback' => 'top_admin_page',
         ]
      ];

      // Options
      if( false === get_option( $this->option ) ) {
         $default = [
            'hljs_version'   => '0.0.0',
            'hljs_languages' => [],
            'hljs_styles'    => [],
            'hljs_option' => [
               'style' => 'agate',
               'language' => 'javascript',
               'fontFamily' => 'Consolas, monospace',
               'fontSize' => '1em',
               'lineHeight' => 1.2,
               'padding' => '0 0 0 0.5em',
               'lineNumberColor' => '#787878',
               'lineNumberBorderColor' => '#787878',
               'wordBreak' => 'break-word',
            ],
            'ace_version'    => '0.0.0',
            'ace_modes'      => [],
            'ace_themes'     => [],
            'ace_option' => [
               'placeholder' => __( 'Enter or paste a code', $this->textdomain ),
               'theme' => 'github',
               'mode' => 'javascript',
               'fontFamily' => 'Consolas, monospace',
               'fontSize' => 16,
               'showLineNumbers' => true,
               'firstLineNumber' => 1,
               'tabSize' => 3,
               'minLines' => 3,
               'maxLines' => 'Infinity',
               'width' => '100%',
               'showGutter' => true,
               'wrap' => true,
               'useWorker' => false,
            ],
         ];
         add_option( $this->option, $default );
      }

      // Ajax
      $this->ajax = new HLJS_Ajax( $this );

      // Hooks
      add_action( 'admin_menu', [$this, 'admin_menu'] );
      add_action( 'admin_enqueue_scripts', [$this, 'admin_enqueue_scripts'] );
      // enqueue_block_editor_assets used to enqueue block scripts and styles in the admin editor only
      add_action( 'enqueue_block_editor_assets', [$this, 'enqueue_block_editor_assets'] );
      // enqueue_block_assets used to enqueue block scripts and styles in both the admin editor and frontend of the site.
      // TODO: HLJS_Admin is valid only in the admin side
      // add_action( 'enqueue_block_assets', [$this, 'enqueue_block_assets'] );

   }

   public function admin_menu() {
      add_menu_page(
         $this->page->top->title,
         $this->page->top->menu,
         $this->page->top->cap,
         $this->page->top->slug,
         [$this, $this->page->top->callback],
         HLJS_Utils::get_icon_svg()
      );
   }

   private function top_admin_settings_tabs() {
      return [
         'options' => [
            'title' => __( 'Options', $this->textdomain ),
            'icon' => 'hljsi-cogs',
         ],
         'uploads' => [
            'title' => __( 'Uploads', $this->textdomain ),
            'icon' => 'hljsi-upload',
         ],
         'editor' => [
            'title' => __( 'Ace editor', $this->textdomain ),
            'icon' => 'hljsi-edit-code',
         ],
         'informations' => [
            'title' => __( 'Informations', $this->textdomain ),
            'icon' => 'hljsi-info',
         ],
      ];
   }

   /**
    * Admin page
    */
   public function top_admin_page() {
      $tabs = $this->top_admin_settings_tabs();
      $active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : key( $tabs );
      $settings = new HLJS_Settings( $this );
      ob_start(); ?>
<div class="wrap" id="hljs-admin">
   <h1><img class="logo" src="<?php echo HLJS_Utils::get_icon_svg(); ?>" /><?php _e( 'Highlight Settings', $this->textdomain ); ?></h1>
   <?php $url = menu_page_url( $this->page->top->slug, false ); ?>
   <h2 class="nav-tab-wrapper">
         <?php foreach( $tabs as $id => $tab ) {
            $active = $active_tab == $id ? 'nav-tab-active' : '';
            echo "<a id=\"{$id}\" href=\"{$url}&tab={$id}\" class=\"nav-tab {$active} {$tab['icon']}\">{$tab['title']}</a>\n";
         } ?>
   </h2>
      <?php foreach( $tabs as $id => $tab ) : ?>
   <div id="<?php echo $id; ?>" class="tabs">
      <h2><?php echo $tab['title']; ?></h2>
      <?php $settings->$id(); ?>
   </div>
      <?php endforeach; ?>
</div>
<div id="hljs-dialog" style="display: none"></div>
      <?php echo ob_get_clean();
   }

   /**
    * Enqueue style and script to icon highlightj options page
    * @param  string $hook
    */
   public function admin_enqueue_scripts( $hook ) {
      if( $hook == "toplevel_page_{$this->page->top->slug}" ) {
         // Font HLJS
         wp_register_style( 'hljs-font', HighLight::url( 'assets/fonts/HLJS/style.css' ), [], HighLight::VERSION );
         wp_enqueue_style( 'hljs-font' );

         // Style Admin settings page
         wp_register_style( 'hljs-admin', HighLight::url( 'assets/css/admin/styles.min.css' ), [], HighLight::VERSION );
         wp_enqueue_style( 'hljs-admin' );

         // Script tabs
         wp_register_script( 'hljs-admin-tabs', HighLight::url( 'assets/js/admin/admin-tabs.js' ), ['jquery'], HighLight::VERSION, true );
         wp_enqueue_script( 'hljs-admin-tabs' );

         // wp-color-picker
         wp_enqueue_style( 'wp-color-picker' );
         wp_enqueue_script( 'wp-color-picker' );

         // Script option
         wp_register_script( 'hljs-admin-option', HighLight::url( 'assets/js/admin/hljs-options.js' ), ['jquery'], HighLight::VERSION, true );
         wp_enqueue_script( 'hljs-admin-option' );

         wp_localize_script( 'hljs-admin-option', 'HLJS_option', [
            'not_zip_file' => __( 'This is not a ZIP File', $this->textdomain ),
            'ajax_nonce' => wp_create_nonce( $this->ajax_nonce ),
         ] );
      }
   }

   /**
    * Enqueue Block Editor Assets
    * @return void
    */
   public function enqueue_block_editor_assets() {

      $build = HighLight::dir( 'assets/syntax/build' );
      $index_asset = require( "{$build}/index.asset.php" );

      wp_enqueue_script(
         'highlight-block',
         HighLight::url( 'assets/syntax/build/index.js' ),
         $index_asset['dependencies'],
         $index_asset['version']
      );

      $option = get_option( $this->option );
      $option['styles'] = ! empty( $option['styles'] ) ? $option['styles'] : false;
      $option['languages'] = ! empty( $option['languages'] ) ? $option['languages'] : false;

      wp_localize_script( 'highlight-block', 'HLJS', [
         'url_ace_builds' => HighLight::url( 'assets/syntax/node_modules/ace-builds/src-noconflict' ),
         'option' => $option,
         'textdomain' => $this->textdomain,
      ] );

   }   
}
