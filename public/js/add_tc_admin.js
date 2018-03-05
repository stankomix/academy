$(document).ready(function() {

  set_timecard_times();

  $('select').selectric();

  $(".tklmaln").css({width:$("body").width(),height:$("body").height()});
  $(".tklmaln").click(function(){nwpstkpt();});
  embedegore();

});

$(window).resize(embedegore);

function embedegore(){
  $(".bosdv,.tklmaln").css({width:"100%"});
  $(".rndvds").css({left:($(window).width()-$(".rndvds").width())/2});
}

function nwpstkpt(){$(".bosdv").html("");}

function toggle_endtime(){
  $("#end_time").hide();
}

function npstgndr()
{
  if ( isNumeric($("#workorder_id").val()) == false )
  {
    notify('work order must be a number');
    return;
  }

  $.ajax({
    type: 'POST',
    url :'/admin/timecard/create_timecard',
    data: $('form#bbform').serialize(),
  })
  .done(function(answer){
     if ( answer.error ){

       if (answer.error === 'MAX_WORK_ORDER_LIMIT' || answer.error === 'EIGHT_HOURS') {

          var ot_admin = $( "#ot_admin" ).val();
          setOtVars(ot_admin);

          $('#bbform').attr('onsubmit', ot_submit);

          $('#submit').css({
            'padding-left': '10px',
            'padding-right': '10px',
            'width': 'auto'
          });

          //$('#submit').val('Request overtime');
          $('#overtimeReasonForm').show();

          if (answer.error === 'MAX_WORK_ORDER_LIMIT') {
            notify(mwol);
          }

          if (answer.error === 'EIGHT_HOURS') {
            notify(eht);
          }

          return;
       }

       notify(answer.error, 'Error');
       return;
     }
     location.reload();
  })
  .fail(function (xhr, status, error) {

    workorder = $('#workorder_id').val();

    if (error == 'DRIVING_TIME') {

        actionSelection(
          'Were you driving from WO #' + xhr.responseText + '?' ,
          function() { add_driving_time(true); },
          function() { add_driving_time(false); },
          'TimeCard'
        );

       return;
    }

    if (error == 'LUNCH_TIME') {

      actionSelection(
          'Did you take a lunch?' ,
          function() {

            $('#add_lunch_time').val('yes');
            submitFormAgain();

          },
          function() { 

            $('#add_lunch_time').val('no');
            submitFormAgain();

          },
          'TimeCard'
      );

      return;
    }

    if (error == 'HAS_OPEN_TIMECARD') {

      var promptLunch = (xhr.responseJSON.ageInMinutes > 30);

      if (promptLunch) {

        var callback = function() { prompt_lunch_break(workorder, promptLunch); };

      } else {

        var callback = function() { close_open_timecard_and_start_new(workorder, false); };

      }

      confirmAction(
        'You have a timecard open for WO# ' + xhr.responseJSON.workorderId + '. Do you want to auto-close it?',
        callback,
        'TimeCard',
        'Yes, submit my end time for WO #' + xhr.responseJSON.workorderId + ' as now'
      );

      return;
    }

    notify(error, 'Error');
 
  }); 
}

function add_driving_time(result) {
    // Modify the form
    if (result) {
      $('#add_driving_time').val('yes');
    } else {
      $('#add_driving_time').val('no');
    }

    submitFormAgain();
}

function prompt_lunch_break(workorder)
{
  actionSelection(
      'Did you take a 30 min lunch?' ,
      function() { 

        close_open_timecard_and_start_new(workorder, true);

      },
      function() { 

        close_open_timecard_and_start_new(workorder, false);

      },
      'TimeCard'
  );
}

function close_open_timecard_and_start_new(workorder, tookLunchBreak) {
    $.post(
      '/admin/timecard/close_open_timecard',
      {
          workorder_id: workorder,
          took_lunch_break: tookLunchBreak,
          timecard_hour: $('#timecard_hour').val(),
          timecard_min: $('#timecard_min').val(),
          timecard_pmam: $('#timecard_pmam').val()
      })
      .done(function () {
          submitFormAgain();
      })
      .fail(function (xhr, status, error) {
          notify(error);
      });
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function submitOvertimeRequest()
{
  if ( isNumeric($("#workorder_id").val()) == false )
  {
    notify('Work order must be a number');
    $("#workorder_id").focus();
    return;
  }

  if ($("#overtime_reason").val().trim().length < 3) {
    notify('Overtime reason is required');
    $("#overtime_reason").focus();
    return;
  }

  $.ajax({
    type: 'POST',
    url :'/admin/timecard/create_overtime_request',
    data: $('form#bbform').serialize(),
  })
  .done(function(answer){
     //Close the form
     nwpstkpt();
     notify('Your request has been submitted. We will update you via SMS', 'Success');
  })
  .fail(function(xhr, status, error){
     notify(error, 'Error');
  }); 
}

function submitFormAgain()
{
  // Update the times
  set_timecard_times();

  // Submit the form again
  npstgndr();
}

function setOtVars(admin_ot = null)
{
  if (admin_ot != 'yes') {
    
    mwol = 'The Work Order limit is 2 timecards per day. Please submit an overtime request below if you wish to continue';
    eht = 'You have clocked over 8 hours today. Please submit an overtime request below if you wish to continue';
    ot_submit = 'submitOvertimeRequest()';

  } else {
    mwol = 'The Work Order limit is 2 timecards per day. Using your admin, priviledges create an overtime timecard if you wish to continue';
    eht = 'You have clocked over 8 hours today. Using your admin, create an overtime timecard if you wish to continue';
    ot_submit = 'submitOvertimeCard()';
  }
}

function submitOvertimeCard()
{

  if ( isNumeric($("#workorder_id").val()) == false )
  {
    notify('Work order must be a number');
    $("#workorder_id").focus();
    return;
  }

  if ($("#overtime_reason").val().trim().length < 3) {
    notify('Overtime reason is required');
    $("#overtime_reason").focus();
    return;
  }

  $.ajax({
    type: 'POST',
    url :'/admin/timecard/create_overtime_card',
    data: $('form#bbform').serialize(),
  })
  .done(function(answer){
     //Close the form
     nwpstkpt();
     location.reload();
     //notify('Overtime timecard has been created.');
  })
  .fail(function(xhr, status, error){
     notify(error, 'Error');
  });
}
