(function () {
    'use strict';    
    
    /*---------------------------	
            Form submit and  copy url
    ------------------------------*/
    
$('.requestform').on('submit', function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var basicbtnhtml=$('.basicbtn').html();
    $.ajax({
        type: "POST",
        url: this.action,
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function() {
            $('.basicbtn').html('<div class="spinner-border text-light spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div> Please Wait....');
            $('.basicbtn').attr('disabled','');
        },
        success: function (response) {
            $('.basicbtn').removeAttr('disabled')
            $('.basicbtn').html(basicbtnhtml)
            var route = $('#url').val() + response;
            $('#route').val(route)
            Swal.fire({
            title: 'Request Link Created',
            input: 'text',
            inputValue: route,
            confirmButtonText: `Copy`,
            icon: 'success',
            showCancelButton: true,
            customClass: {
                input: 'customroute',
            }
            }).then((result) => {
                if (result.value)  {
                    var range = document.createRange();
                    range.selectNode(document.querySelector(".customroute"));
                    window.getSelection().removeAllRanges(); // clear current selection
                    window.getSelection().addRange(range);
                    document.execCommand("copy");
                    Sweet('success', 'Copied!')
                }
            })
        },
        error: function(xhr, status, error) 
        {
            $('.basicbtn').removeAttr('disabled');
            $('.basicbtn').html(basicbtnhtml);
            
            $.each(xhr.responseJSON.errors, function (key, item) 
            {
                Sweet('error',item)
                $("#errors").html("<li class='text-danger'>"+item+"</li>")
            });
        }
    });
})

})();