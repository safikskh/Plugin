jQuery(document).ready(function($){
    $( "#sortable" ).sortable({
        delay: 100,
        update: function(event, ui) {

            // Update order indexes
            updateOrderIndexes();
        },
        stop: function(event, ui) {

            // fire off the update method
            //postUpdateOrder();
        }
    });
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: true
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').map( 

                function( attachment ) {
                    attachment.toJSON();
                    return attachment;
            });

            var i;
            var order = 0;
           for (i = 0; i < uploaded_image.length; ++i) {
                order++;
                //$('.sortable').append('<input id="myplugin-image-input' +uploaded_image[i].id +'" type="hidden" name="myplugin_attachment_id_array[]"  value="' + uploaded_image[i].id + '">');
                $('#sortable').append('<div class="column"><img class="close-btn" src="'+plugin_dir.path+'close-icon.png" alt="Snow" style=""><img src="'+uploaded_image[i].attributes.url+'" alt="Snow" style="width:100%"><input id="img_' +uploaded_image[i].id +'" type="hidden" name="myplugin_attachment_id_array[]"  value="' + uploaded_image[i].id + '"><input class="order_id" name="myplugin_attachment_id_order[]" type="hidden" value="'+order+'"></div>');
           }
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            // console.log(uploaded_image);
            // var image_url = uploaded_image.toJSON().url;
            // // Let's assign the url value to the input field
            // $('#image_url').val(image_url);
        });
    });

    $(document).on('click','.close-btn',function(){
        $(this).parent().remove();
    });
});
function updateOrderIndexes()
{
  // Update the order index on each item
  var orderIndex = 1;
  $("#sortable .column").each( function() {
    console.log($(this))
    $(this).find(".order_id").val(orderIndex);
    orderIndex++;
  });    
}