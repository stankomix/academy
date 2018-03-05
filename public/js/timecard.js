$(document).ready(function(){
  window.onload = addRowHandlers();
});

function submitReason () {
  var reason = $(".missed_tc_reason option:selected").val();

  $.post('/timecard/submit_reason_missed', {reason: reason})
    .done(function(){
      closeDialog();
      loadDialog("/timecard/add_timecard");
    })
    .fail(function(xhr, status, error){
      notify(error);
    });
}

function timeentry (bMissed) {
  if (bMissed)
    loadDialog("/timecard/missed_timecard");
  else
    loadDialog("/timecard/add_timecard");
}

//requires id
function editentry (tcid) {
  $(".bosdv").load("/timecard/update_timecard/"+tcid, function () {
    $(".trndvds").css({
      left: ($(window).width() - $(".trndvds").width())/2
    });
  });
}

function addRowHandlers() {
    console.log("debug: RowHandlers loaded");

    $('.admin-timecard').click(function () {
      var requestId = $(this).data('request');

      confirmAction(
        'Are you sure you want to add this entry to your timecard?',
        function () {
          approveAdminTimecard(requestId);
        }
      );

    });

    var table = document.getElementById("tcid");
    var rows = table.getElementsByTagName("tr");
    for (i = 0; i < rows.length; i++) {
        var currentRow = table.rows[i];
        var createClickHandler = 
            function(row) 
            {
                return function() { 
                  var id = $(this).closest('tr').attr('id');
                  console.log("id:" + id);
                  if (id) editentry(id);
                };
            };

        currentRow.onclick = createClickHandler(currentRow);
    }
}

/**
 * Loads and shows the turn in form
 */
function showTurnInForm() {
  confirmAction(
      'Have you completed all your work for today? You can not make any changes for this Pay Period once you click submit.',
      function() {
        loadDialog('/timecard/submission_form');
      }
  );
}

function approveAdminTimecard(requestId) {
  closeDialog();

  $.post('/timecard/approve_admin_timecard', {request_id: requestId})
    .done(function(){
      location.reload();
    });
}
