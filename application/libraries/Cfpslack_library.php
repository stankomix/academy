<?php

/**
 * CFP Slack Library
 *
 * This abstracts calls to the CFPSlack service
 *
 * @author Sam Takunda <sam.takunda@gmail.com>
 * @copyright (c) 2016, CFP.
 * 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

Class Cfpslack_library {

	/**
	 * Reference to CodeIgniter
	 *
	 * @var object
	 */
    protected $CI;

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }

    /**
     * Generic method to send a notification to the managers on Slack
     *
     * @todo Deal with failures somehow
     *
     * @param string $message  Message to send
     *
     * @return bool
     */
    public function notify($message)
    {
        try {

            $response = $this->post('/cfpslack/notify', [
                'message' => $message
            ]);

        } catch (Exception $e) {
            return false;
        }

        return $response->success;
    }

    /**
     * Sends a POST request to cfpslack and returns a Requests response object
     *
     * @see https://github.com/rmccue/Requests/blob/master/docs/usage.md
     *
     * @param string $endpoint  Endpoint to send request to e.g /notify
     * @param array $parameters  Any request parameters to send in the body
     *
     * @return Requests_Response
     */
    public function post($endpoint, array $parameters = [])
    {
    	$url = $this->CI->config->item('cfpslack_url') . $endpoint;

 		$response = Requests::post(
            $url,
            [],
            array_merge(
                $parameters,
                [
                    'token' => $this->CI->config->item('cfpslack_token')
                ]
            )
        );

 		return $response;
    }

    /**
     * Determines if a note has been made today on BlueFolder for this WO
     *
     * @param int $workorder  Work order ID
     *
     * @param int $minimum_comments  (Optional) Minimum number of comments expected
     *
     * @throws Exception
     *
     * @return bool
     */
    public function check_wo_notes($workorder, $minimum_comments = 1)
    {
        if ($workorder === '00000') return true;

        $endpoint = $this->CI->config->item('cfpslack_url') . '/bluefolder/check_wo_notes/' . $minimum_comments;

        $response = Requests::post(
            $endpoint, [],
            [
                'text' => $workorder,
                'token' => $this->CI->config->item('cfpslack_token')
            ],[],
	    [
		'timeout' => 180
	    ]
        );

        if ($response->success) return true;

        // Check if the error is a 404 (means WO could not be found, or with a comment)
        if ($response->status_code === 404) return false;

        throw new \Exception("Unexpected HTTP response from CFPSlack");
    }

    /**
     * Sends an overtime request to CFPSlack
     *
     * @param int       $id         Overtime request ID
     * @param int       $workorder  Work Order ID
     * @param string    $reason     Overtime reason
     *
     * @return bool
     */
    public function request_overtime($id, $workorder, $username, $reason)
    {
        $endpoint = $this->CI->config->item('cfpslack_url') . '/cfpslack/overtime_request';

        try {

            $response = Requests::post(
                $endpoint, [],
                [
                    'request' => $id,
                    'work_order' => $workorder,
                    'assigned_to_user' => $username,
                    'token' => $this->CI->config->item('cfpslack_token'),
                    'overtime_reason' => $reason
                ]
            );

        } catch (\Exception $e) {
            log_message(
                'debug',
                'SLACK /overtime_request > HTTP Exception ' . $e->getMessage()
            );
        }

        if (!$response->success) {
            log_message(
                'debug',
                'SLACK /overtime_request > HTTP ' . $response->status_code .
                ' response. Content: ' . print_r($response->body, true)
            );
        }

        return $response->success;
    }
}
