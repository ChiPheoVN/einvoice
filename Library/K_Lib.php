<?php
    // time to milliseconds
    function milliseconds_encoder($_year = 2000, $_month = 1, $_day = 1, $_hour = 0, $_minute = 0, $_second = 0){
        return mktime($_hour, $_minute, $_second, $_month, $_day, $_year);
    }
    
    function milliseconds_decoder($_miliseconds){
        $date = getdate($_miliseconds);

        return array(
            'seconds'           => $date['seconds'],
            'minutes'           => $date['minutes'],
            'hours'             => $date['hours'],
            'day_in_month'      => $date['mday'],
            'day_in_week'       => $date['wday'],
            'month_num'         => $date['mon'],
            'year'              => $date['year'],
            'day_in_year'       => $date['yday'],
            'weekday'           => $date['weekday'],
            'month_str'         => $date['month'],
            'miliseconds'       => $date[0]
        );
    }
    function remove_cell_array_null($_array = array()){
        $_result = array_filter($_array, function($_val){
            return !empty($_val);
        });
        return $_result;
    }

    function to_time_string($_miliseconds, $_format = 'dd-mm-yyyy'){
        $date = milliseconds_decoder($_miliseconds);

        $_result = $_format;
        $_result = str_replace('dd', $date['day_in_month'], $_result);
        $_result = str_replace('mm', $date['month_num'], $_result);
        $_result = str_replace('yyyy', $date['year'], $_result);

        return $_result;
    }

    function get_current_time(){
        $date = getdate(microtime(true))[0];
        return $date;
    }

    // get data base where and join
    function get_data($_table_name, $_where = array(), $_join = array()){
        extract($GLOBALS);

        $_str_where = create_where_string($_where);
        $_str_join  = '';

        if(!empty($_join)){
            $_arr_join = array_map(function($key, $value){
                return "JOIN $key ON $value";
            },array_keys($_join), array_values($_join));

            $_str_join  = implode(' ', $_arr_join);
        }

        $sql_com = "SELECT * FROM "."`".$_table_name."`".$_str_join." WHERE ".$_str_where;

        return mysqli_query($_connection, $sql_com);
    }

    function update_data($_table_name, $_where = array(), $_data = array()){
        extract($GLOBALS);
        $_str_where = create_where_string($_where);
        $_str_set   = '';
        $_arr_set = array();

        foreach ($_data as $key => $value) {
            $_str = "`".$key."`"."="."'".$value."'";
            array_push($_arr_set,$_str);
        }
        $_str_set = implode(",", $_arr_set);
        $_str_com = "UPDATE "."`".$_table_name."`"." SET ".$_str_set." WHERE ".$_str_where;

        $sql=mysqli_query($_connection,$_str_com);

        return $sql;
    }

    function create_where_string($_where = array()){
        extract($GLOBALS);
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
        extract($GLOBALS);
        $_result = array();
        if($_sqli_result->num_rows > 0){
            $_result = array();
            while($_row = mysqli_fetch_assoc($_sqli_result)){
                $_result[count($_result)] = $_row;
            }
        }

        return $_result;
    }

    function exist_data($_table_name, $_where = array()){
        return !empty(to_array(get_data($_table_name, $_where)));
    }

    function base_url($_url = ''){
        extract($GLOBALS);

        return $_base_url.$_url;
    }
    function cur_url(){
        extract($GLOBALS);

        return $current_url;
    }

    // trước khi dùng hãy chắc chắn ràng ko còn hàm print nào cả
    function redirect($_url){
        header('Location: '.$_url);
        exit;
    }

    function load_view($_view_name = '', $_data = array()){
        extract($GLOBALS);
        if(!empty($_data)) extract($_data);
        require 'View/'.$_view_name.'_View.php';
    }

    // show alert in anywhere
    function show_notify($_title = '', $_content = '', $_type = '', $_setting = array()){
        $_key_session       = 'notify';
        $_key_title         = 'notify_title';
        $_key_content       = 'notify_content';
        // can use danger success
        $_key_type          = 'notify_type';

        if(isset($_SESSION[$_key_session])){
            array_push($_SESSION[$_key_session], array(
                $_key_content   => $_content,
                $_key_type      => empty($_type) ? 'success' : $_type,
                $_key_title     => $_title
            ));
        }else{
            $_SESSION[$_key_session][0] = array(
                $_key_content   => $_content,
                $_key_type      => empty($_type) ? 'success' : $_type,
                $_key_title     => $_title
            );
        }
    }
?>
