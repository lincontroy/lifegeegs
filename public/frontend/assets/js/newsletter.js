"use strict";
       

/*----------------------------
            Mailchimp Api Integration
        ------------------------------*/
        $('#newsletter').on('submit', function(e){
            e.preventDefault();
            var btnhtml=$('.basicbtn').html();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function() {
                        $('.basicbtn').attr('disabled','')
                        $('.basicbtn').html('Please Wait....')
                },
    
                success: function(response){ 
                    $('.basicbtn').removeAttr('disabled')
                    $('.basicbtn').html('Subscribed')
    
                    Swal.fire({
                        text: response,
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    })
    
                    $('#subscribe_email').val('');
                },
                error: function(xhr, status, error) 
                {
                    $('.basicbtn').removeAttr('disabled');
                    $('.basicbtn').html(btnhtml);
                    $('#subscribe_email').val('');
                }
            });
        });
     