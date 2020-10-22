/**
 * HLJS Options
 */


// Dropbox
const zipFileSelect = document.querySelector('#zipFileSelect'),
      zipFile = document.querySelector('[name="zipFile"]'),
      zipFileName = document.querySelector('#zipFileName'),
      dropbox = document.querySelector('#zipFileDropbox');

const handleFiles = files => {
   if( files[0].type != 'application/x-zip-compressed' ) {
      zipFileName.innerText = HLJS_option.not_zip_file;
      return;
   }
   zipFileName.innerText = files[0].name; 
   document.querySelector('#uploadZipFile').disabled = false;
}

const dragenter = e => {
   e.stopPropagation();
   e.preventDefault();
}

const drop = e => {
   e.stopPropagation();
   e.preventDefault();
   zipFile.files = e.dataTransfer.files;
   handleFiles(e.dataTransfer.files);   
}

zipFileSelect.addEventListener('click', e => {
   e.preventDefault();
   zipFile.click();
});
dropbox.addEventListener('dragenter', dragenter);
dropbox.addEventListener('dragover', dragenter);
dropbox.addEventListener('drop', drop);

zipFile.addEventListener('change', () => {
   handleFiles(zipFile.files);
});
//** Dropbox

// Click handler
// Main div
const hljsAdmin = document.querySelector('#hljs-admin');
hljsAdmin.addEventListener('click', e => {
   // Link in Options tab
   if( e.target.id == 'ace-option-link' ) {
      document.querySelector('#editor').click();
   }
   // Notice dismissible
   if( e.target.className == 'notice-dismiss' ) {
      e.target.closest('.notice').remove();
   }
});

// input type checkbox -> toggle switch
document.querySelectorAll('.toggle').forEach(el => {
   const label = document.createElement('label');
   label.setAttribute('class', 'switch');
   const slider = document.createElement('slider');
   slider.setAttribute('class', 'slider round');
   el.parentNode.insertBefore(label, el);
   label.appendChild(el);
   label.appendChild(slider);
});

// Ajax calls, wpColorPicker() with jQuery
($ => {

   const $hljs_dialog = $( '#hljs-dialog' );
   const $hljs_admin = $( '#hljs-admin' );

   /**
    * Options tab
    */

   // Color picker
   $( '.color-picker' ).wpColorPicker();

   // Update hljs metas
   $hljs_admin.on( 'click', '#update-meta', function( e ) {
      e.preventDefault();
      const $button = $( this );
      const $response = $( '#update-meta-response' );
      $button.prop( 'disabled', true ).addClass( 'rotating' );
      $.ajax({
         url: ajaxurl,
         type: 'POST',
         dataType: 'json',
         data: {
            action: 'hljs-option',
            method: 'update-meta',
            security: HLJS_option.ajax_nonce,
         }
      })
      .done( json => {
         $( '#hljs-loader' ).remove();
         $button.prop( 'disabled', false ).removeClass( 'rotating' );
         $response.html( json.response );
         $( '#hljs-version' ).text( json.version );
         $( '#hljs-languages' ).text( json.languages );
         $( '#hljs-styles' ).text( json.styles );
         $( '#hljs-option-style' ).html( json.select_style );
         $( '#hljs-option-language' ).html( json.select_language );

      });
   });

   // Save hljs option
   $hljs_admin.on( 'submit', '#hljs-option', function( e ) {
      e.preventDefault();
      const $button = $( this ).find( 'button[type="submit"]' );
      const $response = $( '#hljs-option-response' );
      $button.after( '<div id="hljs-loader" />' );
      $button.prop( 'disabled', true );
      $.ajax({
         url: ajaxurl,
         type: 'POST',
         dataType: 'json',
         data: {
            action: 'hljs-option',
            method: 'save-hljs-option',
            data: $( this ).serialize(),
            security: HLJS_option.ajax_nonce,
         }
      })
      .done( json => {
         $( '#hljs-loader' ).remove();
         $button.prop( 'disabled', false );
         $response.html( json.response );
      });
   });

   /**
    * Uploads tab
    */
   $hljs_admin.on( 'click', '#uploadZipFile', function( e ) {
      e.preventDefault();
      const $button = $( this );
      const $response = $( '#uploadZipFileResponse' );
      $response.html( '<div id="hljs-loader"></div>' );
      $button.prop( 'disabled', true );
      const formData = new FormData();
      formData.append( 'action', 'hljs-option' );
      formData.append( 'security', HLJS_option.ajax_nonce );
      formData.append( 'method', 'upload-highlightjs' );
      formData.append( 'zip', zipFile.files[0] );
      $.ajax({
         url: ajaxurl,
         type: 'POST',
         dataType: 'json',
         contentType: false,
         processData: false,
         data: formData
      })
      .done( json => {
         $( '#hljs-loader' ).remove();
         $button.prop( 'disabled', false );
         $response.html( json.response );
         if( 'undefined' != json.version ) {
            $( '#hljs-version' ).text( json.version );
            $( '#hljs-languages' ).text( json.languages );
            $( '#hljs-styles' ).text( json.styles );
         }
      });
   })

   /**
    * Ace editor tab
    */
   // Update ace metas
   $hljs_admin.on( 'click', '#update-ace-meta', function( e ) {
      e.preventDefault();
      const $button = $( this );
      const $response = $( '#update-ace-meta-response' );
      $button.prop( 'disabled', true ).addClass( 'rotating' );
      $.ajax({
         url: ajaxurl,
         type: 'POST',
         dataType: 'json',
         data: {
            action: 'hljs-option',
            method: 'update-ace-meta',
            security: HLJS_option.ajax_nonce,
         }
      })
      .done( json => {
         $( '#hljs-loader' ).remove();
         $response.html( json.response );
         $button.prop( 'disabled', false ).removeClass( 'rotating' );
         $( '#ace-version' ).text( json.version );
         $( '#ace-modes' ).text( json.modes );
         $( '#ace-themes' ).text( json.themes );
         $( '#ace-option-theme' ).html( json.select_theme );
         $( '#ace-option-mode' ).html( json.select_mode );
      });
   });

   // Save ace option
   $hljs_admin.on( 'submit', '#ace-option', function( e ) {
      e.preventDefault();
      const $button = $( this ).find( 'button[type="submit"]' );
      const $response = $( '#ace-option-response' );
      $button.after( '<div id="hljs-loader" />' );
      $button.prop( 'disabled', true );
      $.ajax({
         url: ajaxurl,
         type: 'POST',
         dataType: 'json',
         data: {
            action: 'hljs-option',
            method: 'save-ace-option',
            data: $( this ).serialize(),
            security: HLJS_option.ajax_nonce,
         }
      })
      .done( json => {
         $( '#hljs-loader' ).remove();
         $button.prop( 'disabled', false );
         $response.html( json.response );
      });
   });

})(jQuery);