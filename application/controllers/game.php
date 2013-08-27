<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {
  function __construct() {
    parent::__construct();
    $this->load->helper('url');
  }

  public function friends() {
    $this->load->library('facebook');

    $user = $this->facebook->getUser();

    if ($user) {
      try {
        if (!isset($_SESSION['score'])) {
          $_SESSION['score'] = 0;
          $_SESSION['total']=0;
        }

        if (strlen($this->input->post('name')) != 0) {
            error_log("sup");
            $_SESSION['total']++;
            error_log($_SESSION['name']);
            if (trim($this->input->post('name')) == trim($_SESSION['name'])) {
              $_SESSION['score'] = $_SESSION['score'] + 1;
            }
          }
          $data['score'] = $_SESSION['score'];

          if (isset($_SESSION['friend_array'])) {
            $this->friend_array = $_SESSION['friend_array'];
          } else {
            $this->full_friends = $this->facebook->api('/me/friends');
            $_SESSION['friend_array'] =  $this->full_friends['data'];
            $this->friend_array = $_SESSION['friend_array'];
          }
          $index_number = array_rand($this->friend_array, 1);
          $user_profile = $this->friend_array[$index_number];
          $_SESSION['name'] = $user_profile['name'];
          $id = $user_profile['id'];
          $picture_json = $this->facebook->api('/'.$id.'/picture',
            array(
              'access_token' => $this->facebook->getAccessToken(), 
              'width' => '400', 
              'redirect' => false
            )
          );
          $data['url']= $picture_json['data']['url'];
          unset($this->friend_array[$index_number]);
          $_SESSION['friend_array'] = array_values($this->friend_array);

          } catch (FacebookApiException $e) {
          $user = null;
        }
      echo json_encode($data);
    }
    else {
      print "no";
    }
    
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
