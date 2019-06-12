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
        $_api->cancel_Transaction_Invoice([
            'supplierTaxCode'           => $_api->get_taxCode(),
            'templateCode'              => '01GTKT0/001',
            'invoiceNo'                 => 'NS/19E0000008',
            'strIssueDate'              => '20190524152415',
            'additionalReferenceDesc'   => 'Tên văn bản',
            'additionalReferenceDate'   => date('Ymdhis')
        ]);
        print_r($_api->result_array());die();
    ?>
        <center>
            <h1>Hủy hóa đơn viettel</h1>
        </center>
        <div class="row py-3">
        </div>        
    </div>
</body>
<?php include_once 'include/footer_link.php'?>
</html>