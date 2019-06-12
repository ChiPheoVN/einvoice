<?php
    // các hàm của database
    function get_data($_table, $_where = []){
        $conn = $GLOBALS['conn'];
        $_str = "SELECT * FROM `$_table` WHERE 1=1";
        if(!empty($_where)){
            foreach ($_where as $key => $value) {
                $_str .= " AND `$key` = '$value'";
            }
        }        
        $_result = mysqli_query($conn, $_str);
        echo $_table;
        print_r($_result);
        $_output = [];
        // if ($_result->num_rows > 0) {
        //     // output data of each row
        //     while($row = mysqli_fetch_assoc($_result)){
        //         $_output[] = $row;
        //     }
        // } else {
        //     echo "0 results";
        // }

        mysqli_close($conn);

        return $_output;
    }

    function insert_data($_table, $_data = []){
        $conn = $GLOBALS['conn'];
        $_str = "INSERT INTO `$_table`";
        if(!empty($_data)){            
            $_str_key = '(';
            $_str_value = 'VALUES (';

            $_arr_key   = array_keys($_data);
            $_arr_value = array_values($_data);

            foreach ($_arr_key as $key => $value) {
                $_str_key .= "`$value`";
                if(isset($_arr_key[$key + 1])) $_str_key.= ",";
            }

            foreach ($_arr_value as $key => $value) {
                $_str_value .= "'$value'";
                if(isset($_arr_value[$key + 1])) $_str_value .= ",";
            }
            
            $_str_key   .= ") ";
            $_str_value .= ") ";
        }

        $_str .= " ".$_str_key.$_str_value;
        $conn->query($_str);
        return mysqli_close($conn);
    }

    function update_data($_table, $_data = [], $_where = []){
        $conn = $GLOBALS['conn'];
        $_str = "UPDATE `$_table`";
        if(!empty($_data)){
            $_str_set = "SET";
            $_arr_key = array_keys($_data);
            foreach ($_arr_key as $key => $value) {
                $_str_set .= "`$value` = ".$_data[$value];
                if(isset($_arr_key[$key + 1])) $_str_set .= ",";
            }
        }
        $_str_where = "WHERE 1 = 1";
        if(!empty($_where)){
            $_arr_key   = array_keys($_where);
            foreach ($_where as $key => $value) {
                $_str_where .= " AND `$key` = '$value'";
            }
        }
        $_str .= " ".$_str_set." ".$_str_where;
        $conn->query($_str);
        return mysqli_close($conn);
    }
?>