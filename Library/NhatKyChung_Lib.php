<?php // only use in nhat ky chung
    function get_row_title_nkc(){
        $_start_row_title_data = 5;
        $_arr_row_title_data = read_file_excel('Upload/NhatKyChung_Temp.xls', $_start_row_title_data, $_start_row_title_data)[$_start_row_title_data];
        return $_arr_row_title_data;
    }

    function get_nkc_array_col($_return_array = true){
        $file = file_get_contents('Config_file/Nhatkychung.json');

        $file = $_return_array ? json_decode($file, true) : $file;

        return $file;
    }

    function save_config_nkc($_array = array()){
        $_json = json_encode($_array, JSON_UNESCAPED_UNICODE);
        $myfile = fopen("Config_file/Nhatkychung.json", "w") or die("Unable to open file!");
        fwrite($myfile, $_json);
        fclose($myfile);
    }
    function get_nkc_col_excel(){
        
    }
?>
