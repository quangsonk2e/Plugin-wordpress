jQuery(function($){

    // Set all variables to be used in scope
    var frame,
        metaBox = $('#meta-box-id.postbox'), // Your meta box id here
        addImgLink = $('#upload-custom-img'),
        delImgLink = $( '.delete-custom-img'),
        imgContainer = $( '.custom-img-container'),
        imgIdInput = $( '.custom-img-id' );
    
    // ADD IMAGE LINK
    addImgLink.on( 'click', function( event ){
      
      event.preventDefault();
      
      // If the media frame already exists, reopen it.
      if ( frame ) {
        frame.open();
        return;
      }      
      // Create a new media frame
      frame =wp.media.frames.slideshow_jquery_image_galler_uploader = wp.media({
        title: 'Select or Upload',
        button: {
          text: 'Use this media'
        },
        library: { type: 'image' },
        frame: 'select',
        multiple: 'add'  // Set to true to allow multiple files to be selected
      }); 
      
      // When an image is selected in the media frame...
      frame.on('select', function() {
        
        // Get media attachment details from the frame state
        var selection  = frame.state().get( 'selection' );  
        selection.map( function( attachment ) {
            attachment.toJSON();
            console.log(attachment.attributes);
            // Send the attachment URL to our custom image input field.
            imgContainer.append('<img src="'+attachment.attributes.sizes.thumbnail.url+'" alt="" style="max-width:100%;" class="image-list"/>' );
      
            // Send the attachment id to our hidden input
            imgIdInput.val( attachment.attributes.id );
      
            // Hide the add image link
            // addImgLink.addClass( 'hidden' );
      
            // Unhide the remove image link
            delImgLink.removeClass( 'hidden' );
        });
      });
  
      // Finally, open the modal on click
      frame.open();
    }); 
    
    // DELETE IMAGE LINK
    delImgLink.on( 'click', function( event ){  
      event.preventDefault();  
      // Clear out the preview image
      imgContainer.html( '' );  
      // Un-hide the add image link
      addImgLink.removeClass( 'hidden' );  
      // Hide the delete image link
      delImgLink.addClass( 'hidden' );  
      // Delete the image id from the hidden input
      imgIdInput.val( '' );  
    });
  
  });



