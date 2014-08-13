function placeMarker(coords) {
    if(typeof marker !== 'undefined') {
        lastCoords = marker.getPosition();
        marker.setPosition(coords);
    }
    else {
        marker = new google.maps.Marker({
            position: coords,
            map: map,
            draggable: true,
        });
        google.maps.event.addListener(marker, 'dragend', function(){
            geocodePosition(marker.getPosition());
        });
    }
}

function restoreMarker() {
    if((typeof marker !== 'undefined') && (typeof lastCoords !== 'undefined')) {
        marker.setPosition(lastCoords);
    }
    alert('К сожалению, нам не удалось определить адрес метки или мы не можем разместить мероприятие в этом городе.');
}

function geocodePosition(pos) 
{
   geocoder = new google.maps.Geocoder();
   geocoder.geocode
    ({
        latLng: pos
    }, 
        function(results, status) 
        {
            if (status == google.maps.GeocoderStatus.OK) 
            {
                formatted_address = results[0].formatted_address;
                var countryError = true;
                for(var i=0; i<results[0].address_components.length;i++) {
                    if ($.inArray('country', results[0].address_components[i].types) != -1) {
                        country = results[0].address_components[i].long_name;
                        var countryExistsError = true;
                        for (var j=0;j<$('#Contents_country_id option').length;j++) {
                            if ($('#Contents_country_id option:eq('+j+')').text() == country) {
                                cityError = true;
                                for(var k=0; k<results[0].address_components.length;k++) {
                                    if ($.inArray('locality', results[0].address_components[k].types) != -1) {
                                        city = results[0].address_components[k].long_name;
                                        $.post('/admin/city/cityExists', { title: city }, function(data) {
                                            if (data == 'false') {
                                                restoreMarker();
                                            }
                                            else {
                                                $('#Contents_country_id').val($('#Contents_country_id option:eq('+j+')').val());
                                                currentCity = $('#Contents_city_id').val();
                                                $.post('/admin/event/dynamiccities', $('#Contents_city_id').parents('form').serialize(), function(html){
                                                    $('#Contents_city_id').html(html);
                                                    for (var l=0;l<$('#Contents_city_id option').length;l++) {
                                                        if ($('#Contents_city_id option:eq('+l+')').text() == city) {
                                                            $('#Contents_city_id').val($('#Contents_city_id option:eq('+l+')').val());
                                                            break;
                                                        }
                                                    }
                                                    if ($.inArray(currentCity, $("#Contents_city_id option").map(function() { return $(this).val(); }) ) == -1) {
                                                        $("#Contents_metro_id option[value='']").attr('selected', true)
                                                    }
                                                    else {
                                                        $.post('/admin/event/dynamicmetros', $('#Contents_metro_id').parents('form').serialize(), function(html){
                                                            $('#Contents_metro_id').html(html);
                                                        });
                                                    }
                                                    var endPos = formatted_address.indexOf(city)-2;
                                                    $('#Contents_address').val(formatted_address.substr(0, endPos));
                                                });
                                            }
                                        });
                                        cityError = false;
                                        break;
                                    }
                                }
                                countryExistsError = cityError;
                                break;
                            }
                        }
                        countryError = countryExistsError;
                        break;
                    }
                }
                if (countryError) 
                    restoreMarker();
            } 
        }
    );
}

function addMarker(event) {
    placeMarker(event.latLng);
    geocodePosition(marker.getPosition());
}

function geocode()
{
    var address = null;
    if ($('#Contents_country_id').val()) {
        address = $('#Contents_country_id').find(":selected").text();
        if ($('#Contents_city_id').val()) {
            address += ', ' + $('#Contents_city_id').find(":selected").text();
            if ($('#Contents_address').val()) {
                address += ', ' + $('#Contents_address').val();
            }
        }
    } 
    

    var geocoder = new google.maps.Geocoder(); 
    geocoder.geocode({
            address : address, 
            region: 'RU' 
        },
        function(results, status) {
            if (status.toLowerCase() == 'ok') {
                // Get center
                var coords = new google.maps.LatLng(
                    results[0]['geometry']['location'].lat(),
                    results[0]['geometry']['location'].lng()
                );
                
                map.setCenter(coords);
                map.setZoom(18);

                // Set marker also
                placeMarker(coords);
            }
        }
    );
}

$(document).ready(function() {
    $('input[id*=img_]:file').bind('change', handleFileSelect);
    $('.control-group .img_preview .deletePhoto').one('click', function(e) {
        var $this = $(this);
        deletePhoto($this);
    });


    $('body').on('change','#Contents_country_id, #Contents_city_id, #Contents_address',function(){
        geocode();
    });


    if ( $('.checkclass').length ) {
        $('.checkclass').on('click', function(){
            if ($('.checkclass:checked').length)
                $('.deleteChecked').prop('disabled', false);
            else 
                $('.deleteChecked').prop('disabled', true);
        });

        $('.deleteChecked').on('click', function(){
            var ids = [];
            $('.checkclass:checked').each(function(){
                ids.push($(this).val());
            });

            if (window.confirm('Вы уверены, что хотите удалить выбранные записи?')) {
                $.post("/admin/event/massDelete/", { ids: ids }, function(data) {
                    alert('Выбранные записи были успешно удалены.');
                    location.reload(true);
                });
            }

            return false;
        });
    }

});




function handleFileSelect(evt) {
    var files = evt.target.files;
    var $el = $(evt.target);
    var elId = evt.target.id;
    for (var i = 0, f; f = files[i]; i++) {
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
        reader.onload = (function(theFile) {
            return function(e) {
                var previewBlock = $el.next('.img_preview');
                $('img', previewBlock).remove();
                previewBlock.prepend('<img class="img-rounded" width="200" src="'+e.target.result+'" alt="">');
                $('.deletePhoto', previewBlock).show().unbind('click').bind('click', function() {
                    var $newEl = $("<input type='file' />").attr({
                        'name': $el.attr('name'),
                        'id': elId,
                        'class': $el.attr('class')
                    }).bind('change', handleFileSelect);
                    $el.replaceWith($newEl);
                    $('img', previewBlock).remove();
                    $(this).hide();
                });
            }
        })(f);
        reader.readAsDataURL(f);
    }
    delete files;
}



function deletePhoto(target) {
    var target = $(target);
    var data = {};
    data[target.data('modelname')] = {'deletePhoto': target.data('attributename')};
    console.log(data);
    $.ajax({
        type: 'POST',
        data: data,
        success: function(data) {
            target.hide().prev('img').remove();
        }
    });
}




function fixHelper(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};




function sortGrid(gridId) {
    var grid = $('#'+gridId+'-grid table.items tbody');
    grid.sortable({
        forcePlaceholderSize: true,
        forceHelperSize: true,
        items: 'tr',
        update : function () {
            var serial = grid.sortable('serialize', {key: 'items[]', attribute: 'id'});
            $.ajax({
                'url': '/admin/'+gridId+'/sort',
                'type': 'post',
                'data': serial,
                'success': function(data){},
                'error': function(request, status, error) {
                    alert('Сортировка сейчас недоступна');
                }
            });
        },
        helper: fixHelper
    }).disableSelection();
}


function transliterate(text) {
    var space = '-',
        transl = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'e', 'ж': 'zh',
            'з': 'z', 'и': 'i', 'й': 'j', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n',
            'о': 'o', 'п': 'p', 'р': 'r','с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'h',
            'ц': 'c', 'ч': 'ch', 'ш': 'sh', 'щ': 'sh','ъ': space, 'ы': 'y', 'ь': space, 'э': 'e', 'ю': 'yu', 'я': 'ya',
            ' ': space, '_': space, '`': space, '~': space, '!': space, '@': space,
            '#': space, '$': space, '%': space, '^': space, '&': space, '*': space,
            '(': space, ')': space,'-': space, '\=': space, '+': space, '[': space,
            ']': space, '\\': space, '|': space, '/': space,'.': space, ',': space,
            '{': space, '}': space, '\'': space, '"': space, ';': space, ':': space,
            '?': space, '<': space, '>': space, '№':space
        };

    var result = '';
    var curent_sim = '';

    text = text.toLowerCase();

    for(i=0; i < text.length; i++) {
        if ( transl[text[i]] != undefined ) {
            if(curent_sim != transl[text[i]] || curent_sim != space){
                result += transl[text[i]];
                curent_sim = transl[text[i]];
            }
        }
        // Если нет, то оставляем так как есть
        else {
            result += text[i];
            curent_sim = text[i];
        }
    }
    return result.replace(/^-/, '').replace(/-$/, '');
}


