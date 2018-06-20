$(document).ready(function() {
    $('.input_file').on('paste', function () {
        var input = this;
        setTimeout(function () {
            var url = $(input).val();
            $(input).val('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/url',
                dataType: "json",
                data: {url: url},
                success: function (resp) {

                    $('.errors ul').html('');
                    if(!resp.error) {
                        $('.thead-inverse').append('<tr data-id="' + resp.id + '"><th>' + resp.id + '</th><th><a href="' + resp.path + '">' + resp.path + '</a></th><th>' + resp.mime_type + '</th><th>' + resp.url + '</th><th><button class="delete" data-id="' + resp.id + '">Delete</button></th></tr>');
                    }else{
                            $('.errors ul').append('<li>'+resp.error+'</li>');
                    }
                },
                error: function (resp) {
                    $('.errors ul').html('');
                    $.each($.parseJSON(resp.responseText).errors.url,function( key,error ) {
                        $('.errors ul').append('<li>'+error+'</li>');
                    });
                }
            });
        }, 100);

        });
    $('.thead-inverse').on('click','.delete', function () {
        var id = $(this).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: '/delete',
                dataType: "json",
                data: {id: id},
                success: function (resp) {
                    if(resp.result) {
                        $('tr[data-id="'+resp.id+'"]').remove();
                    }
                }
            });
    });


});