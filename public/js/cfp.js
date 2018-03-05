/**
 * Loads a dialog from the given url
 */
function loadDialog (url)
{
  $(".bosdv").load(url, function () {

    $(".trndvds").css({
      left: ( $(window).width() - $(".trndvds").width() ) / 2
    });

  });
}

/**
 * Shows a notification overlay with title @title and message @message
 */
function notify(message, title)
{
  if (!title) title = 'TimeCard';

  //Set the title and message
  $('#overlayTitle').html(title);
  $('#overlayMessage').html(message);

  //Dsiplay overlay
  $('#overlay').show();

  //Position the overlay
  $(".trndvds").css({left:($(window).width()-$(".trndvds").width())/2});
}

/**
 * Closes any open notification overlays
 */
function closeOverlay()
{
  $('#overlay').hide();
}

/**
 * Closes any open dialogs
 */
function closeDialog()
{
  $('.bosdv').html('');
}

/**
 * Shows a confirmation overlay with title @title and message @message
 * callback will be called if the user presses 'Ok'
 */
function confirmAction (message, callback, title, confirmButtonTitle)
{
  if (!title) title = 'TimeCard';

  //Set the title and message
  $('#confirmationTitle').html(title);
  $('#confirmationMessage').html(message);

  if (confirmButtonTitle) {
    $('.inptsbt', '#actionConfirmation').val(confirmButtonTitle);
  }

  $('.inptsbt', '#actionConfirmation').click(function () {
    $('#actionConfirmation').hide();
    callback();
  });

  //Dsiplay overlay
  $('#actionConfirmation').show();

  //Position the overlay
  $(".trndvds").css({left:($(window).width()-$(".trndvds").width())/2});
}

/**
 * Display embedded content with id {id}
 */
function embeddedContent (id) {
  loadDialog('/files/embed/' + id);
}

/**
 * Shows an action selection overlay with title @title and message @message.
 * It also has a primary and secondary buttons.
 */
function actionSelection (message, primaryCallback, secondaryCallback, title, primaryActionTitle, secondaryActionTitle)
{
  if (!title) title = 'TimeCard';

  //Set the title and message
  $('#selectionTitle').html(title);
  $('#selectionMessage').html(message);

  if (primaryActionTitle) {
    $('.inptsbt', '#actionSelection').val(primaryActionTitle);
  }

  if (secondaryActionTitle) {
    $('.inptgri', '#actionSelection').val(secondaryActionTitle);
  }

  $('.inptsbt', '#actionSelection').click(function (e) {
    e.preventDefault();

    // Clear listeners
    $('.inptsbt', '#actionSelection').off('click');
    $('.inptgri', '#actionSelection').off('click');
    $('#actionSelection').hide();
    primaryCallback();
  });

  $('.inptgri', '#actionSelection').click(function (e) {
    e.preventDefault();

    // Clear listeners
    $('.inptsbt', '#actionSelection').off('click');
    $('.inptgri', '#actionSelection').off('click');
    $('#actionSelection').hide();
    secondaryCallback();
  });

  //Dsiplay overlay
  $('#actionSelection').show();

  //Position the overlay
  $(".trndvds").css({left:($(window).width()-$(".trndvds").width())/2});
}

function hdrmblac () {
  $(".hmlnklr").css({
    display : "block"
  });
}

function hdrmblkapat () {
  $(".hmlnklr").css({
    display : "none"
  });
}

/**
 * Set/update the hour, minute and AM/PM for timecard forms
 * with the user's local time
 */
function set_timecard_times () {
  var date = new Date();

  var timecardHour = date.getHours();
  var timecardMin = date.getMinutes();
  var timecardPmAm = timecardHour >= 12 ? 'PM' : 'AM';

  timecardHour = timecardHour % 12;
  timecardHour = timecardHour ? timecardHour : 12; // the hour '0' should be '12'
  timecardHour = timecardHour < 10 ? '0' + timecardHour : timecardHour;
  timecardMin = timecardMin < 10 ? '0' + timecardMin : timecardMin;

  // Update labels
  $('#timecard_hour').val(timecardHour);
  $('#timecard_hour_label').text(timecardHour);

  $('#timecard_min').val(timecardMin);
  $('#timecard_min_label').text(timecardMin);

  $('#timecard_pmam').val(timecardPmAm);
  $('#timecard_pmam_label').text(timecardPmAm);
}


$(document).ajaxStart(function () {
  $('.wait-on-submit').prop('disabled', true);
});

$( document ).ajaxComplete(function () {
  $('.wait-on-submit').prop('disabled', false);
});
