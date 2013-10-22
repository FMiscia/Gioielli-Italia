<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        
        $this->load->library('parser');
        $data = array(
            'image_entries' => array()
        );
        $dirname = "assets/img/prova";
        $images = \glob($dirname."/*.{jpg,png}", \GLOB_BRACE);
        foreach ($images as $image) {
            array_push($data['image_entries'], array('name' => "prova", 'source' => $image));
        }

        $this->parser->parse('gioielliitalia_template', $data);
    }

}

/* End of file welcome.php */
    /* Location: ./application/controllers/welcome.php */