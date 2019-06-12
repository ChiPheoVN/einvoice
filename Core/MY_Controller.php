<?php
    class MY_Controller extends MY_Core{
        public $db = '';
        public function __construct(){
            parent::__construct();
            extract($GLOBALS);

            $this->db = $_DB;
        }
    }
?>
