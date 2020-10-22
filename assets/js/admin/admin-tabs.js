/**
 * Script for icon inserter options page
 */
( $ => {

   // Tabs
   const $navs = $( '.nav-tab' ),
         $tabs = $( '.tabs' );
 
   const toggle = function( tab ) {
         
            // Navigation
            $tabs.hide().filter(function() {return this.id == tab}).show();
            $navs.removeClass('nav-tab-active').filter(function() {
               return this.id == tab;
            }).addClass('nav-tab-active');
            
            // history.pushState
            let href = location.href.replace(/&tab=.+$/, '');
            let url = href + '&tab=' + tab;
            let title = tab.toUpperCase();
            history.replaceState({tab: tab, href: href}, title, url);
         };
 
   let url = new URL(location.href);
   let tab = url.searchParams.get('tab') || $navs.first().prop('id');
   toggle( tab );
 
   $navs.on( 'click', function( e ) {
      e.preventDefault();
      tab = this.id; 
      toggle( tab );
   });
 
   window.onpopstate = function( e ) {
      if( e.state != null ) {
         $('#' + e.state.tab).trigger( 'click');
      }
      else {
         history.back();
      }
   };

})( jQuery );