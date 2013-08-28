
$(document).ready(function() {
    $('input[id*=img_]:file').bind('change', handleFileSelect);

});



function handleFileSelect(evt) {
    var files = evt.target.files;
    var elId = evt.target.id;
    for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {
                $('#'+elId).next('img').remove();
                $('#'+elId).after('<img class="img-polaroid" width="200" src="'+e.target.result+'" alt="">');
                $('.image_delete').click(function(){
                    $('#'+elId).replaceWith($('#'+elId).clone(true));
                    document.getElementById('Brands_image').addEventListener('change', handleFileSelect, false);
                    $('#image').children('li').fadeOut(500, function(){
                        $('#image').children('li').remove();
                    });
                });
            }
        })(f);
        reader.readAsDataURL(f);
    }
    delete files;
}


