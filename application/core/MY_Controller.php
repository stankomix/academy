<?php

/**
 * Common things we need to do in every controller
 *
 * @author jje/sch
 */
class MY_Controller extends CI_Controller {

    protected $arViewData = array();
    private $arLayouts = array();
    protected $arNavbarItems = array();

    protected $isWidgetCall = FALSE;

    public function __construct()
    {
        parent::__construct();

    	//check session, move to login if none
    	if ( $this->session->nrmlkullanici == "" && $this->session->nrmlstatus == "" )
    	{
    		//login page
    		redirect(base_url());
    		exit;
    	}

        $this->arLayouts['default'] = array(
            'pre' => array(
                'common/_header',
                'common/_header_bar',
                    'common/_nav'
            ),
            'post' => array(
                    'common/_footer',
                    'common/_dialogs',
                    'common/_closetags'
            )
        );

		//'name' => (empty($this->session->cfpname)) ? 'signin' : $this->session->cfpname,
        if ( $this->session->is_admin )
        {
            $this->load->model('admin_model');
            $user_tiles = $this->admin_model->user_tiles($this->session->user_id);
        
        } else {
        
            $user_tiles = '';
        
        }
        
        $this->arViewData = array(
            'cfpname' => $this->session->cfpname,
            'is_admin' => $this->session->is_admin,
            'user_tiles' => $user_tiles,
            'currPage' => strtolower(get_class()),
            'currMethod' => strtolower($this->uri->segment(1)),
            // TODO move below items to a config file.
            'page_title' => 'Commercial Fire Protection',
            'link_css' => array(
                // Label is for easy override, if needed.
                'global' => 'skins/css/global.css',
                //'ui' => 'skins/css/ui.css',
                //hardcode temporrily to tims server
                'ui' => 'skins/css/ui.css',
                'font_Varela' => 'http://fonts.googleapis.com/css?family=Varela&v1',
                'font_Wire' => 'http://fonts.googleapis.com/css?family=Wire+One&v1'
            ),
            'script_js' => array(
                // Label is for easy override, if needed.
//should use bower/vendor for autoloading jquery
                'jquery' => 'skins/js/jquery-1.6.2.min.js',
            )
        );

                //$this->_generateNavbar();
    }
    /**
     *
     * @param string|array $contentView one or more view names
     * @param type $strLayout default: default
     */
    protected function _layout($contentView, $strLayout = 'default')
    {
            if (!array_key_exists($strLayout, $this->arLayouts))
            {
                    $strLayout = array_keys($this->arLayouts);
                    $strLayout = $strLayout[0];
            }

            // load pre-views
            if (isset($this->arLayouts[$strLayout]['pre']))
            {
                    foreach ($this->arLayouts[$strLayout]['pre'] as $strPreView)
                    {
                            $this->load->view($strPreView, $this->arViewData);
                    }
            }

            // load content views
            if (is_array($contentView))
            {
                    foreach ($contentView as $strView)
                    {
                            $this->load->view($strView, $this->arViewData);
                    }
            } 
            else
            {
                    $this->load->view($contentView, $this->arViewData);
            }       
                    
            // load post-views
            if (isset($this->arLayouts[$strLayout]['post']))
            {
                    foreach ($this->arLayouts[$strLayout]['post'] as $strPostView)
                    {
                            $this->load->view($strPostView, $this->arViewData);
                    }
            }               
    }  

    protected function _generateNavbar()
    {
            $this->arViewData['navbar'] = '';
            $totnavitems = count($this->arNavbarItems);
            for ($i = 0; $i < $totnavitems; $i++)
            {
                    $arAttributes = array('class' => (($i == 0) ? 'first' : 'last'));
                    $arAttributes['class'] .= ( strpos(current_url(), $this->arNavbarItems[$i]['page']) ? ' selected' : '');
                    $this->arViewData['navbar'] .= anchor($this->arNavbarItems[$i]['page'], $this->arNavbarItems[$i]['label'], $arAttributes) . "\n";
            }
    }

    protected function notify_user($message)
    {
        echo '<script type="text/javascript">notify("' . $message . '");</script>';
    }

    /**
     * Sends a JSON response to the client
     *
     * @param mixed[] $content  Array content to be converted to JSON
     *
     * @return void
     */
    protected function json_response($content = [])
    {
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode(
                $content,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            ))
            ->_display();

        exit;
    }

    /**
     * Sends an error JSON response to the client
     *
     * @param string $error  Error message
     * @param mixed $additionalContent  Additional content to send back with the error
     *
     * @return void
     */
    protected function json_error_response($error, $additionalContent = null)
    {
        $this->output
            ->set_status_header(422, $error)
            ->set_content_type('application/json', 'utf-8');

        if ($additionalContent){
            if (!is_string($additionalContent)) {
                $this->output->set_output(json_encode(
                    $additionalContent,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ));       
            } else {
                $this->output->set_output($additionalContent);
            }
        };

        $this->output->_display();
        exit;
    }

    /**
     * Returns an HTTP 204 (No Content) response to the client
     *
     * @return void
     */
    protected function no_content()
    {
        $this->output->set_status_header(204);
    }
}
