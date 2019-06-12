<?php
    class MY_Core{
        public $db = '';
        public $_url_view = '';
        public $_status = array(
            'deleted'       => -1,
            'banned'        => -2
        );
        public function __construct(){
            extract($GLOBALS);

            $this->db = new Database();
            $this->api = new api_vt();

            $this->_url_view = base_url();
        }
        public function get_permission(){
            $_admin_infor = $this->get_infor_admin();
            $_parent_id = $_admin_infor['parent_id'];
            $_id_admin  = $_admin_infor['id'];
            $_id_group  = $_admin_infor['group_permiss'];

            if($_id_group == -1 || $_parent_id == -1){
                $_permiss   = $this->db->get_data('tbl_permission');
            }else{
                $_permiss   = $this->db->get_data('tbl_group_permission', array(
                    'tbl_group_permission_id'     => $_id_group
                ), array(
                    'tbl_group_permission_connect_permission'       => 'tbl_group_permission_connect_permission.tbl_group_permission_connect_permission_group = tbl_group_permission.tbl_group_permission_id',
                    'tbl_permission'                                => 'tbl_group_permission_connect_permission.tbl_group_permission_connect_permission_permission = tbl_permission.tbl_permission_id'
                ));
            }

            $_permiss = $this->db->to_array($_permiss);
            return $_permiss;
        }
        public function get_all_permiss(){
            $_all_permiss = $this->db->get_data('tbl_permission', array('tbl_permission_status'  => true));
            $_all_permiss = $this->db->to_array($_all_permiss);

            return $_all_permiss;
        }
        public function check_permiss($_name = '', $_permiss = array()){
            if(empty($_permiss))
                $_permiss = $this->get_permission();
            return !empty(array_filter($_permiss, function($_per)use($_name){return $_per['tbl_permission_name'] == $_name;}));
        }
        function reload_view($_url = ''){
            if(empty($_url)) $_url = $this->_url_view;

            redirect(base_url($_url));
        }
        function load_view($_view_name = '', $_data = array()){
            if(!empty($_data)) extract($_data);
            require 'View/'.$_view_name.'_View.php';
        }
    }
?>
