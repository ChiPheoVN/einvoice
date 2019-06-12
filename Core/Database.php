<?php
    class Database {
        public function __construct()
        {
            extract($GLOBALS);

            $this->_connection = $_connection;
        }

        public $_connection = '';

        // get data base where and join
        function get_data($_table_name, $_where = array(), $_join = array()){
            $_str_where = $this->create_where_string($_where);
            $_str_join  = '';

            if(!empty($_join)){
                $_arr_join = array_map(function($key, $value){
                    return "LEFT JOIN $key ON $value";
                },array_keys($_join), array_values($_join));

                $_str_join  = implode(' ', $_arr_join);
            }

            $sql_com = "SELECT * FROM "."`".$_table_name."`".$_str_join." WHERE ".$_str_where;
            //echo $sql_com;

            return mysqli_query($this->_connection, $sql_com);
        }

        function update_data($_table_name, $_data = array(), $_where = array()){
            $_str_where = $this->create_where_string($_where);
            $_str_set   = '';
            $_arr_set = array();

            foreach ($_data as $key => $value) {
                $_str = "`".$key."`"."="."'".$value."'";
                array_push($_arr_set,$_str);
            }
            $_str_set = implode(",", $_arr_set);
            $_str_com = "UPDATE "."`".$_table_name."`"." SET ".$_str_set." WHERE ".$_str_where;

            $sql = mysqli_query($this->_connection, $_str_com);

            return $sql;
        }

        function create_where_string($_where = array()){
            $_str_where = '1';
            if(!empty($_where)){
                $_arr_where = array_map(function($key, $value){
                    $_key_split = explode(' ', $key);
                    $_con = '=';
                    if(count($_key_split) === 2) $_con = $_key_split[1];

                    return '`'.$_key_split[0].'` '.$_con.' "'.$value.'"';
                }, array_keys($_where), array_values($_where));

                $_str_where = implode(' AND ', $_arr_where);
            }

            return $_str_where;
        }

        // convert result sql to array();
        function to_array($_sqli_result){
            $_result = array();
            if(is_object($_sqli_result) && $_sqli_result->num_rows > 0){
                $_result = array();
                while($_row = mysqli_fetch_assoc($_sqli_result)){
                    $_result[count($_result)] = $_row;
                }
            }

            return $_result;
        }

        public function exist_data($_table_name, $_where = array()){
            return !empty($this->to_array($this->get_data($_table_name, $_where)));
        }

        public function insert_id(){
            return $this->_connection->insert_id;
        }

        function insert_data($table, $field){
            $key1 = array();
            $value1 = array();
            foreach ($field as $key => $value) {
                $value0 = $value;
                array_push($value1,$value0);
            }
            foreach ($field as $key => $value) {
                $key0 = $key;
                array_push($key1,$key0);
            }
            $key = implode('`,`', $key1);
            $value = implode("','", $value1);
            $str_sql = "INSERT into". " "."`".$table."`"." ("."`".$key."`".") "."VALUES("."'".$value."'".")";
            echo $str_sql;die();
            $sql    = mysqli_query($this->_connection, "INSERT into". " "."`".$table."`"." ("."`".$key."`".") "."VALUES("."'".$value."'".")");
            return $sql;
        }

        function delete_data($_table_name = '', $_where = array()){
            $_str_where = $this->create_where_string($_where);

            $_str_com = "DELETE FROM "."`".$_table_name."` WHERE ".$_str_where;

            $sql = mysqli_query($this->_connection, $_str_com);

            return $sql;
        }
    }

    $_DB = new Database();
?>
