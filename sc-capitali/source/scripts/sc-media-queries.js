/*! SC Media Queries v2.0.0 | (c) 2019 Web.com | Licensed  */

export default class MediaQueries {

  constructor( breakpoint ) {

    this.breakpoint = breakpoint;
    
    let xs_min    = 0;
    let sm_min    = 576;
    let md_min    = 768;
    let lg_min    = 992;
    let xl_min    = 1200;
    let hg_min    = 1600;
    
    let xs_max    = sm_min - 1;
    let sm_max    = md_min - 1;
    let md_max    = lg_min - 1;
    let lg_max    = xl_min - 1;
    let xl_max    = hg_min - 1;

    this.mediaQueries = {
  
      'xs_up':     window.matchMedia( this.getMediaQueryString( 'min', xs_min ) ),
      'sm_up':     window.matchMedia( this.getMediaQueryString( 'min', sm_min ) ),
      'md_up':     window.matchMedia( this.getMediaQueryString( 'min', md_min ) ),
      'lg_up':     window.matchMedia( this.getMediaQueryString( 'min', lg_min ) ),
      'xl_up':     window.matchMedia( this.getMediaQueryString( 'min', xl_min ) ),
      'hg_up':     window.matchMedia( this.getMediaQueryString( 'min', hg_min ) ),
  
      'sm_only':   window.matchMedia( this.getMediaQueryString( 'min', sm_min ) + ' and ' +  this.getMediaQueryString( 'max', sm_max ) ),
      'md_only':   window.matchMedia( this.getMediaQueryString( 'min', md_min ) + ' and ' +  this.getMediaQueryString( 'max', md_max ) ),
      'lg_only':   window.matchMedia( this.getMediaQueryString( 'min', lg_min ) + ' and ' +  this.getMediaQueryString( 'max', lg_max ) ),
      'xl_only':   window.matchMedia( this.getMediaQueryString( 'min', xl_min ) + ' and ' +  this.getMediaQueryString( 'max', xl_max ) ),
      'hg_only':   window.matchMedia( this.getMediaQueryString( 'min', hg_min ) ),
      
      'portrait':  window.matchMedia( '(orientation: portrait)' ),
      'landscape': window.matchMedia( '(orientation: landscape)' )
      
    };

    return {
  
      'match': this.match( this.breakpoint )
  
    };

  }
  
  getMediaQueryString( type, width ) {
  
    return '(' + type + '-width: ' + width + 'px )';

  }

  match( mediaQuery ) {
  
    return this.mediaQueries[mediaQuery].matches;

  }

}
