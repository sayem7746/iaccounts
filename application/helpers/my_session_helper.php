class MY_Session extends CI_Session {

    function __construct() {
        parent::__construct();

        $this->tracker();
    }

    function tracker() {
        $this->CI->load->helper('url');

        $tracker =& $this->userdata('_tracker');

        if( !IS_AJAX ) {
            $tracker[] = array(
                'uri'   =>      $this->CI->uri->uri_string(),
                'ruri'  =>      $this->CI->uri->ruri_string(),
                'timestamp' =>  time()
            );
        }

        $this->set_userdata( '_tracker', $tracker );
    }


    function last_page( $offset = 0, $key = 'uri' ) {   
        if( !( $history = $this->userdata('_tracker') ) ) {
            return $this->config->item('base_url');
        }

        $history = array_reverse($history); 

        if( isset( $history[$offset][$key] ) ) {
            return $history[$offset][$key];
        } else {
            return $this->config->item('base_url');
        }
    }
}