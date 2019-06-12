<?php // only use excel
    function read_file_excel($_file_path = '', $_start_row = 1, $_end_row = 'end'){
        try {
			$inputFileType   = PHPExcel_IOFactory::identify($_file_path);
			$objReader       = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel     = $objReader->load($_file_path);
		}
		catch(Exception $e) {
			die('Lỗi không thể đọc file "'.pathinfo($_file_path,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		// Lấy sheet hiện tại
		$sheet = $objPHPExcel->getSheet(0);
		// Lấy tổng số dòng của file, trong trường hợp này là 6 dòng
        if($_end_row == 'end'){
            $highestRow = $sheet->getHighestRow();
            $_end_row   = $highestRow;
        }
		// Lấy tổng số cột của file, trong trường hợp này là 12 cột
		$highestColumn = $sheet->getHighestColumn();
		// Khai báo mảng $rowData chứa dữ liệu
		$r = 0;
        $_result = array();
		for ($row = $_start_row; $row <= $_end_row; $row++){
		    // Lấy dữ liệu từng dòng và đưa vào mảng $rowData
			$_result[$row] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE,FALSE)[0];
		}

        return $_result;
    }

    function str_col($_index_col = 1, $_index_row = ''){
        $_str_a = 64;
        return $_index_col > 26 ? chr($_str_a + 1).str_col($_index_col - 26, $_index_row) : chr($_str_a + $_index_col).$_index_row;
    }
    function cell_coordinates($_col_name = ''){
        $_row = preg_replace('/^[A-Z]*/', '', $_col_name);
        $_col = preg_replace('/[0-9]*$/', '', $_col_name);

        return array(
            'column'        => $_col,
            'row'           => $_row
        );
    }
    function to_array_col_str($_data = array(), $_index_row = ''){
        foreach ($_data as $key => $value) {
            $_data[str_col($key + 1, $_index_row)] = $value;
            unset($_data[$key]);
        }
        return $_data;
    }
?>
