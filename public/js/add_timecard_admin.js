$(document).ready(function() {

  set_timecard_times();
  loadDialog('/link');

  //# OVERTIME

  $( "#overtime" ).change(function(){

    if( $(this).prop("checked") == true ){
      
      $( ".ot" ).show();

    } else {
      
      $( ".ot" ).hide();

    }

  });

});

  function npstgndr()
  {

    if ( $( '#user_id' ).val() == '0' )
    {
      notify('Select a user');
      $( '#user_id' ).focus();
      return;
    }
    
    if ( isNumeric($("#workorder_id").val()) == false )
    {
      notify('work order must be a number');
      $("#workorder_id").focus();
      return;
    }

    if ($("#overtime_reason").val().trim().length < 3 && $( "#overtime" ).prop("checked") == true )
    {
      notify('Overtime reason is required');
      $("#overtime_reason").focus();
      return;
    }

    if ( $("#hours_limit").val() == '' && $( "#overtime" ).prop("checked") == true){
      notify('Hours limit is required');
      $("#hours_limit").focus();
      return;
    }

    // start time
    if ( $("#timecard_hour").val() == '' && $("#timecard_min").val() == '' ){
      notify('Start time is required');
      return;
    }

    if ( isNumeric( $("#timecard_hour").val() ) == false || isNumeric( $("#timecard_min").val() ) == false ){
      notify('Start time is not valid');
      return;
    }

    if ( $("#timecard_hour").val() > 12 || $("#timecard_min").val() > 59 ){
      notify('Start time is not valid');
      return;
    }

    // stop time

    if ( $("#stop_hour").val() == '' && $("#stop_min").val() == '' ){
      notify('End time is required');
      return;
    }

    if ( isNumeric( $("#stop_hour").val() ) == false || isNumeric( $("#stop_min").val() ) == false ){
      notify('End time is not valid');
      return;
    }

    if ( $("#stop_hour").val() > 12 || $("#stop_min").val() > 59 ){
      notify('End time is not valid');
      return;
    }

    $.ajax({
      type: 'POST',
      url :'/admin/timecard',
      data: $('form#bbform').serialize(),
    })
    .done(function(answer){
      notify('Timecard has been added');
    })
    .fail(function (xhr, status, error) {

      notify(error, 'Error');
   
    });
    
    $( '.rnk.sae.bbsae' ).click(function(){
       location.reload();
    });

  }


  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }
