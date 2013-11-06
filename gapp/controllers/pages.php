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

    public function view($page = 'home') {
        $data['title'] = ucfirst($page);
        if (method_exists($this, $page))
            @$this->$page();
        else
            $this->home();
    }

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
            $images = \glob($dir . "/*.{jpg,png,JPG}", \GLOB_BRACE);
            foreach ($images as $image) {
                array_push($data [$foldername . '_image_entries'], array('name' => "", 'source' => '/' . $image, 'thumb' => '/' . $image . ".thumb"));
            }
            foreach ($subdirs as $subdir) {
                $simages = \glob($subdir . "/*.{jpg,png,JPG}", \GLOB_BRACE);
                $subfoldername = str_replace("assets/img/Immagini/" . $foldername . "/", '', $subdir);
                foreach ($simages as $simage) {
                    array_push($data[$foldername . '_image_entries'], array('name' => "", 'source' => '/' . $simage, 'thumb' => '/' . $simage . ".thumb", 'filter' => $subfoldername));
                }
            }
        }
        $this->parser->parse('gioielliitalia_template', $data);
    }

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

    public function logout() {
        session_start();
        session_destroy();
        $this->home();
    }

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

    public function upload() {
        session_start();
        $out = array('result' => false);
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == true &&
                isset($_FILES["file"]) && isset($_POST["tipo"]) && $_POST["tipo"] != "") {
            $imgname = $_FILES["file"]['name'];
            /**
             * Path Building
             */
            $tipo = $_POST["tipo"];
            $path = explode("-", $tipo);
            $num = (count($path) );
            $counter = -1;
            $pth = "./assets/img/Immagini/";
            while ($num != 0) {
                $counter++;
                $pth .= $path[$counter] . "/";
                $num--;
            }
            /**
             * Upload configuration
             */
            $config['upload_path'] = $pth;
            $config['allowed_types'] = 'gif|JPG|JPEG|PNG|jpeg|jpg|png';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload("file")) {
                $out = array('result' => true);
            }
            /**
             * Image Configuration
             */
            $config['image_library'] = 'gd2';
            $config['source_image'] = $pth . $imgname;
            $config['create_thumb'] = TRUE;
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = "";
            $config['new_image'] = $imgname . ".thumb";
            $config['width'] = 150;
            $config['height'] = 100;
            $this->load->library('image_lib', $config);
            if (!$this->image_lib->resize()) {
                $out = array('result' => false);
            }
        }
        /**
         * Json 
         */
        echo json_encode($out);
        exit;
    }

    public function loadAllImages() {

        $data = array(
            'image_entries' => array()
        );
        $dirs = array_filter(\glob('assets/img/Immagini/*'), 'is_dir');
        foreach ($dirs as $dir) {
            $foldername = str_replace("assets/img/Immagini/", '', $dir);
            $subdirs = array_filter(\glob('assets/img/Immagini/' . $foldername . '/*'), 'is_dir');
            $images = \glob($dir . "/*.{jpg,png,JPG}", \GLOB_BRACE);
            foreach ($images as $image)
                array_push($data ['image_entries'], array('thumb' => '/' . $image . ".thumb"));
            foreach ($subdirs as $subdir) {
                $simages = \glob($subdir . "/*.{jpg,png,JPG}", \GLOB_BRACE);
                $subfoldername = str_replace("assets/img/Immagini/" . $foldername . "/", '', $subdir);
                foreach ($simages as $simage)
                    array_push($data ['image_entries'], array('thumb' => '/' . $simage . ".thumb"));
            }
        }
        return $data;
    }

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
