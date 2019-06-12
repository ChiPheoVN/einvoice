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
        $_api->update_Payment_Status([
            'supplierTaxCode'       => '0201906443',
            'invoiceNo'             => 'NS/19E0000019',
            'templateCode'          => '01GTKT0/001',            
            'strIssueDate'          => '20190529160520',
            'paymentType'           => 'TM',
            'paymentTypeName'       => 'TM',
            'cusGetInvoiceRight'    => true
        ]);

        print_r($_api->result_array());
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