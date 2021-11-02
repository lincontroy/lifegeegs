"use strict";
/*----------------------------
    Sweet Aleart
  ------------------------------*/
function Sweet(icon, title, time = 3000) {

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: time,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: icon,
        title: title,
    })
}

/*----------------------------
    Custom File Input Change
  ------------------------------*/
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

/*-------------------------------
    Delete Confirmation Alert
  -----------------------------------*/
$('.delete-confirm').on('click', function(event) {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this blog!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('delete_form_' + id).submit();
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your Data is Save :)',
                'error'
            )
        }
    })
});


/*---------------
    Data Append
  -------------------*/
var x = 0; //Initial field counter is 1
var count = 100;
var maxField = 10; //Input fields increment limitation
var addButton = $('.add_button'); //Add button selector
var wrapper = $('.field_wrapper'); //Input field wrapper

//Once add button is clicked
$(addButton).on('click', function() {
    //Check maximum number of input fields
    if (x < maxField) {
        //Increment field counter
        var fieldHTML = `<div class='row'><div class="col-md-5"> 
                      <br>
                      <input type="text" required class="form-control" name="social[${count}][icon]" value=""> 
                      </div>
                      <div class="col-md-5">
                          <br>
                          <input type="text" required class="form-control" name="social[${count}][link]" class=""> 
                      </div>
                      <div class="col-md-2">
                          <br>
                          <a href="javascript:void(0);" class="remove_button btn btn-danger btn-block btn-lg" title="Add field">Remove</a>
                      </div><div>`; //New input field html 
        x++;
        count++;
        $(wrapper).append(fieldHTML); //Add field html
    }
});

//Once remove button is clicked
$(wrapper).on('click', '.remove_button', function(e) {
    e.preventDefault();
    $(this).parent('div').parent('div.row').remove(); //Remove field html
    x--; //Decrement field counter
});




/*----------------
    Form Submit
  -------------------*/
$('.submitform').on('submit', function(e) {
    $(this).find('.submitbtn').prop('disabled', true)
    $(this).find('.submitbtn').text('Please wait...')
});

$('.form').on('submit', function() {
    $('.submitbtn').text('Please wait...');
    $('.submitbtn').prop('disabled', true);
});