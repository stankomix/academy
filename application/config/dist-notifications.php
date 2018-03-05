<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Enable SMS notifications
|--------------------------------------------------------------------------
|
| This determines whther or not SMS' will be sent out.
|
*/
$config['enable_sms'] = true;

/*
|--------------------------------------------------------------------------
| Twilio account credentials as they are provided you
|--------------------------------------------------------------------------
|
| twilio_sid 	- Your Account SID from www.twilio.com/console
| twilio_token 	- Your Auth Token from www.twilio.com/console
| twilio_from 	- Your Twilio inbound/outbound SMS phone number
|
*/
$config['twilio_sid'] = '';
$config['twilio_token'] = '';
$config['twilio_from'] = '';

/*
|--------------------------------------------------------------------------
| Set the notification type Id (for the notification_types table) for SMS
| notifications
|--------------------------------------------------------------------------
|
*/
$config['sms_notification_id'] = 1;

/*
|--------------------------------------------------------------------------
| SMS sent for 5th hour reminders for the first timecard in a work order
|--------------------------------------------------------------------------
|
*/
$config['fifth_hour_sms'] = "TIMECARD ALERT: you have not clocked out for lunch, this is a state mandated requirement";
$config['fifth_hour_admin'] = "%s did not clock out for lunch. Work order: %s. Timesheet %s";

/*
|--------------------------------------------------------------------------
| SMS sent 5 minutes before a timecard should be clocked out
|--------------------------------------------------------------------------
|
*/
$config['clockout_first_warning'] = "TIMECARD NOTICE: You must receive manager approval for overtime";

/*
|--------------------------------------------------------------------------
| SMS sent on the dot for timecard that should be clocked out.
| _admin Is the eqivalent message sent to the managers on Slack.
|--------------------------------------------------------------------------
|
*/
$config['clockout_final_warning'] = "TIMECARD NOTICE: Your timecard will close automatically in 5 minutes";
$config['clockout_final_warning_admin'] = "%s did not clock out for work order %s after %s hours. In 5 minutes, the timesheet (%s) will be closed automatically";

/*
|----------------------------------------------------------------------------------------------
| SMS sent for 5 minutes after expected clockout when a timecard has been closed automatically
| _admin Is the eqivalent message sent to the managers on Slack.
|----------------------------------------------------------------------------------------------
|
*/
$config['clockout_timesheet_closed'] = "TIMECARD NOTICE: Your timecard has been closed. You must receive manager approval for overtime";
$config['clockout_timesheet_closed_admin'] = "%s did not clock out for work order %s after %s hours. The timesheet (%s) has been closed automatically";
$config['clockout_timesheet_closed_admin_no_note'] = "%s did not clock out for work order %s after %s hours. The timesheet (%s) has been closed automatically. No BlueFolder note was detected.";

/*
|-------------------------------------------------------------------------------------
| The secret key used to generate the signature hash when posting to the Slack service
|-------------------------------------------------------------------------------------
|
| This is used in the overtime request/approval
|
*/
$config['slack_secret_key'] = '';

/*
|--------------------------------------------------------------------------
| SMS sent to the managers when a request for overtime has been placed
|--------------------------------------------------------------------------
|
*/
$config['overtime_request_manager_sms'] = "%s requested to work overtime on work order %s.";

/*
|--------------------------------------------------------------------------
| SMS sent when a request for overtime has been approved
|--------------------------------------------------------------------------
|
*/
$config['overtime_approval_sms'] = "Your OT has been approved for up to %s hours. If you work longer than this, you will need to create another timecard and submit another OT request.";
$config['overtime_approval_manager_sms'] = "OT for %s has been approved for up to %s hours.";

/*
|--------------------------------------------------------------------------
| SMS sent when a request for overtime has been denied
|--------------------------------------------------------------------------
|
*/
$config['overtime_denial_sms'] = "OT denied for Workorder:";
$config['overtime_denial_manager_sms'] = "OT request by %s has been denied.";

/*
|---------------------------------------------------------------------------------------------------------
| Notification sent to the manager when a user signs with a name different to what we have in the database
|---------------------------------------------------------------------------------------------------------
|
*/
$config['wrong_turn_in_signature'] = "%s signed their timecard turn-in with unexpected signature %s";
