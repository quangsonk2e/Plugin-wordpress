(function( $ ) {
    'use strict';
    $( document ).ready( function() {
        if( $( '#uploaded_img_btn' ).length ) { //checks if the button exists
            var metaImageFrame;
            $( 'body' ).click( function( e ) {
                var btn = e.target;
                if ( !btn || !$( btn ).attr( 'data-media-uploader-target' ) ) return;
                var field = $( btn ).data( 'media-uploader-target' );
                e.preventDefault();
                metaImageFrame = wp.media.frames.metaImageFrame = wp.media( {
                    button: { text:  'Use this file' },
                } );
                metaImageFrame.on( 'select', function() {
                    var media_attachment = metaImageFrame.state().get( 'selection' ).first().toJSON();
                    $( field ).val( media_attachment.url );
                } );
                metaImageFrame.open();
            } );
        }
    } );
} )( jQuery );