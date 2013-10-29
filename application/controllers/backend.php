?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of backend
 *
 * @author francesco
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backend extends CI_Controller {

    //put your code here
    public function index() {

        $this->load->library('parser');
        $data = array(
            'error' => '',
            
        );
        $this->parser->parse('gioielliitalia_login', $data);
    }

    public function login() {
        $this->load->library('parser');
        $this->load->database();

        $user = htmlspecialchars($_POST["user"]);
        $pass = htmlspecialchars($_POST["pass"]);
        if ($user != "" && $pass != "") {
            $q="SELECT * FROM admin WHERE user= '" . $user . "' AND  pass='" . md5($pass) . "'";
            $query = $this->db->query($q);

            if ($query->num_rows() == 1) {
                session_start();
                $_SESSION['admin'] = true;
                //$this->load->view('gioielliitalia_image'); Call another function
                
            } else {
                $data = array(
                    'error' => 'Login Errato',
                );
                $this->parser->parse('gioielliitalia_login', $data);
            }
        } else {
            $data = array(
                'error' => 'Login Errato',
            );
            $this->parser->parse('gioielliitalia_login', $data);
        }
    }

}

?>
