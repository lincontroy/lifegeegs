(function () {
    'use strict';    
    
    /*---------------------------	
            Copy To clipboard
        ------------------------------*/
    let copyUrl = document.getElementById('copyUrl')
    let urlInput = document.getElementById('url');
    document.getElementById('generateUrl').addEventListener('click',function(e){
        e.preventDefault()
        let url = e.target.dataset.url;
        let param = e.target.dataset.param;
        urlInput.value = url +'/'+ param
        displayCopyButton(urlInput.value)
    })

    document.getElementById('copyUrl').addEventListener('click',function(e){
        e.preventDefault()
        /* Get the text field */
        let copyText = urlInput;

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        console.log(copyText.value)
    })

})();

/*---------------------------	
        Display Copy Button
    ------------------------------*/
function displayCopyButton(url){
    console.log(url)
    if (url == "") {
        copyUrl.classList.add('d-none');
    }else{
        copyUrl.classList.remove('d-none');
    }
}


