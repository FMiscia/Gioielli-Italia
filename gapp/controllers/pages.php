<?php

/**
 * Description of pages
 *
 * @author francesco
 */
class Pages extends CI_Controller {

    public function index() {
        $this->view();
    }

    /**
     *Routes the pages 
     *
     */
    public function view($page = 'home') {
        $data['title'] = ucfirst($page);
        if (method_exists($this, $page))
            @$this->$page();
        else
            $this->home();
    }

    /**
     * Home page. It loads the images path
     * to give to the template parser
     */
    public function home() {
        $this->load->library('parser');
        $data = array(
            'taufkleider_image_entries' => array(),
            'gold_image_entries' => array(),
            'trauringe_image_entries' => array(),
            'modeschmuck_image_entries' => array(),
            'einladungskarten_image_entries' => array(),
            'bomboniere_image_entries' => array(),
            'taufkleider_image_entries' => array()
        );
        $dirs = array_filter(\glob('assets/img/Immagini/*'), 'is_dir');
        foreach ($dirs as $dir) {
            $foldername = str_replace("assets/img/Immagini/", '', $dir);
            $subdirs = array_filter(\glob('assets/img/Immagini/' . $foldername . '/*'), 'is_dir');
            $images = \glob($dir . "/*.{jpg,png,jpeg,JPEG,JPG}", \GLOB_BRACE);
            foreach ($images as $image) {
                array_push($data [$foldername . '_image_entries'], array('name' => "", 'source' => '/' . $image, 'thumb' => '/' . $image . ".thumb"));
            }
            foreach ($subdirs as $subdir) {
                $simages = \glob($subdir . "/*.{JPEG,jpeg,jpg,png,JPG}", \GLOB_BRACE);
                $subfoldername = str_replace("assets/img/Immagini/" . $foldername . "/", '', $subdir);
                foreach ($simages as $simage) {
                    array_push($data[$foldername . '_image_entries'], array('name' => "", 'source' => '/' . $simage, 'thumb' => '/' . $simage . ".thumb", 'filter' => $subfoldername));
                }
            }
        }
        $this->parser->parse('gioielliitalia_template', $data);
    }

    /**
     * It calls the login templates or the administration page 
     * whether the $_SESSION['admin'] == true
     */
    public function login() {
        session_start();
        $this->load->library('parser');
        if ((isset($_SESSION['admin'])) && ($_SESSION['admin'] == true)) {
            $this->parser->parse('gioielliitalia_image', $this->loadAllImages());
        } else {
            $data = array(
                'error' => '',
            );

            $this->parser->parse('gioielliitalia_login', $data);
        }
    }

    /**
     * Destroy the session
     */
    public function logout() {
        session_start();
        session_destroy();
        $this->home();
    }

   /**
    * Login $_POST input check. 
    * Successful: It calls the administration page
    * Fail: It calls the login page with an error template variable for the parser
    */
    public function checkLogin() {
        $this->load->library('parser');
        $this->load->database();
        $user = $this->input->post('user', TRUE);
        $pass = $this->input->post('pass', TRUE);
        if ($user != false && $pass != false) {
            $q = "SELECT * FROM admin WHERE user= '" . $user . "' AND  pass='" . md5($pass) . "'";
            $query = $this->db->query($q);
            if ($query->num_rows() == 1) {
                session_start();
                $_SESSION['admin'] = true;
                $this->parser->parse('gioielliitalia_image', $this->loadAllImages());
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

    /**
     * Uploads an image and create a thumbnail for it
     * @return array Json result[true,false]
     */
    public function upload() {
        session_start();
        $out = array('result' => false);
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true && isset($_FILES['file']['tmp_name'])) {
            if (($_FILES['file']["size"] < 500000) && $_FILES['file']["type"] == ("image/png" || "image/jpg" || "image/jpeg" || "image/gif")) {
                /**
                 * Path Building
                 */
                $tipo = $_POST['tipo'];
                $imgname = $_POST['name'];
                $imgname = str_replace(" ", "", $imgname);
                $path = explode("-", $tipo);
                $num = (count($path) );
                $counter = -1;
                $pth = "./assets/img/Immagini/";
                while ($num != 0) {
                    $counter++;
                    $pth .= $path[$counter] . "/";
                    $num--;
                }
                if (!(file_exists($pth . $imgname)))
                    move_uploaded_file($_FILES['file']["tmp_name"], $pth . $imgname);
                else {
                    echo json_encode($out);
                    exit;
                }

                /**
                 * Image Configuration
                 */
                $thumb = array();
                $thumb['image_library'] = 'gd2';
                $thumb['source_image'] = $pth . $imgname;
                $thumb['create_thumb'] = TRUE;
                $thumb['maintain_ratio'] = TRUE;
                $thumb['thumb_marker'] = "";
                $thumb['new_image'] = $imgname . ".thumb";
                $thumb['width'] = 150;
                $thumb['height'] = 100;
                $this->load->library('image_lib', $thumb);
                if ($this->image_lib->resize()) {
                    $out = array('result' => true);
                }
            }
        }
        /**
         * JSON
         */
        echo json_encode($out);
        exit;
    }

    /**
     * Loads every thumbnail for the administration page
     * @return array Json result[true,false]
     */
    public function loadAllImages() {

        $data = array(
            'image_entries' => array()
        );
        $dirs = array_filter(\glob('assets/img/Immagini/*'), 'is_dir');
        foreach ($dirs as $dir) {
            $foldername = str_replace("assets/img/Immagini/", '', $dir);
            $subdirs = array_filter(\glob('assets/img/Immagini/' . $foldername . '/*'), 'is_dir');
            $images = \glob($dir . "/*.{JPEG,jpeg,jpg,png,JPG}", \GLOB_BRACE);
            foreach ($images as $image)
                array_push($data ['image_entries'], array('thumb' => '/' . $image . ".thumb"));
            foreach ($subdirs as $subdir) {
                $simages = \glob($subdir . "/*.{JPEG,jpeg,jpg,png,JPG}", \GLOB_BRACE);
                $subfoldername = str_replace("assets/img/Immagini/" . $foldername . "/", '', $subdir);
                foreach ($simages as $simage)
                    array_push($data ['image_entries'], array('thumb' => '/' . $simage . ".thumb"));
            }
        }
        return $data;
    }

    /**
     * Deletes an image given by $_POST
     * @return array Json result[true,false]
     */
    public function deletePhoto() {
        session_start();
        $out = array('result' => false);
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
            $imgpath = $this->input->post('img', TRUE);
            $imgpath = str_replace(".thumb", "", $imgpath);
            $imgpath = str_replace("/assets", "assets", $imgpath);
            if ($imgpath && strstr($imgpath, "Immagini") !== false) {
                unlink($imgpath);
                unlink($imgpath . ".thumb");
                $out = array('result' => true);
            }
        }
        echo json_encode($out);
        exit;
    }

    /**
     * Sends an email to the server. 
     * @return array Json result[true,false]
     */
    public function send() {
        $out = array('result' => false);
        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        $message = $this->input->post('message', TRUE);
        if ($name && $message && $email) {
            $this->load->library('email');

            $this->email->from($email, $name);
            $this->email->to('fra.miscia@gmail.com');

            $this->email->subject('Messaggio da Gioielli-Italia');
            $this->email->message($message);


            if ($this->email->send()) {
                $out = array('result' => true);
            }
        }
        echo json_encode($out);
        exit;
    }

}

?>
