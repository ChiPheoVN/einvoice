<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test hóa đơn điện tử</title>

    <?php include_once 'include/header_link.php'?>
    <?php include_once '../folder_kien/api_function.php'?>
</head>

<body>
    <div class="container">
    <?php
        $_api = new api_vt();
        // lay file hoa don
        $_api->get_Invoice_Representation_File_Portal([
            'supplierTaxCode'       =>'0201906443',
            'invoiceNo'             =>'NS/19E0000005',
            'templateCode'          =>'01GTKT0/001',
            'fileType'              =>'zip',
            'reservationCode'       => 'D0EB9JK2YU',
            'strIssueDate'          => '20190523112349'
        ])->download_file();

        $_result = $_api->result_array();
        print_r($_result);
    ?>
        <center>
            <h1>Lấy file hóa đơn</h1>
        </center>
        <div class="row py-3">
        </div>        
    </div>
</body>
<?php include_once 'include/footer_link.php'?>
</html>