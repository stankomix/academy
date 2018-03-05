var turnIn = new function () {

    this.initialise = function () {

    	$('#timecardTurnInForm').on('submit', function(e) {
            e.preventDefault();
            formSubmit();
        });

    }

    function formSubmit()
    {
    	var signature  = $('#signature', '#timecardTurnInForm').val();

    	$.post('/admin/timecard/turnin', {signature: signature})
            .done(function () {
                closeDialog();
                $('#btnTurnInTimecard').attr('disabled', 'disabled')
                    .removeClass('turnin_active')
                    .addClass('turnin_disabled');

                notify('Turn in submitted successfully', 'Turn in Timecard');
            })
            .fail(function (xhr, status, error) {
               notify(error);
            });   	
    }

}

turnIn.initialise();
