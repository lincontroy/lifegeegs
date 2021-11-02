(function() {
    'use strict';

    /*----------------------------	
      		Copy to clipboard
    	------------------------------*/
    let copy = document.getElementById('copy')
    let formData = document.getElementById('formData')
    let formInput = document.getElementById('form')

    formData.addEventListener('submit', function(e) {
        e.preventDefault()
        let data = new FormData(this)
        let formHTML = renderForm(data);
        formInput.innerText = formHTML
        displayCopyButton(formHTML)
    })

    copy.addEventListener('click', function(e) {
        e.preventDefault()
        var range = document.createRange();
        range.selectNode(document.getElementById("form"));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        Sweet('success', 'Successfully Copied!');
    })

})();

/*----------------------------	
        Dsplay Copy Button
    ------------------------------*/
function displayCopyButton(url) {
    if (url == "") {
        copy.classList.add('d-none');
    } else {
        copy.classList.remove('d-none');
    }
}

/*---------------------	
        Render Form
    -----------------------*/
function renderForm(data) {
    var url = document.getElementById('url').value;
    var public_key = document.getElementById('public_key').value;

    var form = `<form action="${url}" method="post">`;
    form += `<input type="hidden" name="public_key" class="form-control" value="${public_key}"> `
    form += `<div class="form-group">
                <input type="hidden" name="currency" class="form-control" value="${data.get('currency_value')}">
            </div>`
    form += `<div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" min="1" name="amount" class="form-control" value="${data.get('amount_value')}">
            </div>`
    form += `<div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="${data.get('email_value')}">
            </div>`

    form += `<div class="form-group">
                <label for="">Phone</label>
                <input type="text" name="phone" class="form-control" value="${data.get('phone_value')}">
            </div>`

    form += `<div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control" value="${data.get('name_field_value')}">
            </div>`

    form += `<div class="form-row">
                <div class="col-6">
                    <div class="form-group">
                        <input type="hidden" id="is_fallback" name="is_fallback" value="${data.get('is_fallback_value')}" ${data.get('is_fallback_value') ? 'checked' : '' }>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <input type="hidden" id="is_test"  name="is_test" value="${data.get('is_test_value')}" ${data.get('is_test_value') ? 'checked' : ''}>
                    </div>
                </div>
            </div>`
    form += `<div class="form-group">
                <input type="hidden" name="fallback_url" value="${data.get('fallback_url_value')}" class="form-control">
            </div>`
    form += `<div class="form-group">
                <label for="">Purpose</label>
                <input type="text" name="purpose" value="${data.get('purpose_value')}" class="form-control">
            </div>`
    form += `<div class="form-group">
                <input type="submit" value="SUBMIT" class="btn btn-dark">
                </div>`
    form += `</form>`;

    return form
}