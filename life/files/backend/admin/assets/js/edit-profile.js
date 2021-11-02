(function($) {
    "use strict";

    /*--------------------------
      Public Key Regenerate
    -----------------------------*/
    $('#public_key').on('click',function(e) {
        e.preventDefault()
        $('input[name="public_key"]').val(makeid()); 
    });

    /*--------------------------
      Private Key Regenerate
    -----------------------------*/
    $('#private_key').on('click',function(e) {
        e.preventDefault()
        $('input[name="private_key"]').val(makeid()); 
    });

})(jQuery);

/*--------------------------
      Create New Make Id
    -----------------------------*/
function makeid(length = 26) {
    let private = $('input[name="public_key"]').val();
    let public = $('input[name="private_key"]').val();
    var result           = [];
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;

    for ( var i = 0; i < length; i++ ) {
    result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
    }
  return result.join('');
}