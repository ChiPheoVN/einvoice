<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test hóa đơn điện tử</title>

    <?php include_once 'view/include/header_link.php'?>
    <?php include_once 'global_func/global.php'?>
</head>
<body>
    <div class="container">
        <center><h1>Test api hóa đơn viettel</h1></center>
        <div class="row py-2">
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_invoice.php">Xem hóa đơn</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/create_invoice.php">Tạo hóa đơn</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/create_draft_invoice.php">Tạo hóa đơn nháp</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/cancel_invoice.php">Hủy hóa đơn</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_custom_field.php">Lấy thông tin trường động</a>
            </div>        
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_file_invoice.php">Lấy file hóa đơn</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_file_invoice_portal.php">Lấy file hóa đơn có mã số bí mật</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_file_exchange_invoice.php">Lấy file hóa đơn chuyển đổi</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_file_invoice_draft_preview.php">Xem trước hóa đơn nháp</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/update_tax_declaration.php">Cập nhật kê khai thuế</a>
            </div>
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_status_use_invoice.php">Lấy thông tin tình hình sử dụng</a>
            </div> 
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/get_list_invoice_control.php">Danh sách hóa đơn</a>
            </div> 
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/update_payment_status.php">Cập nhật trạng thái thanh toán</a>
            </div> 
            <div class="col col-sm-6 py-3 col-xl-3">
                <a class="btn btn-primary btn-sm btn-block" href="view/cancel_payment_status.php">Hủy trạng thái thanh toán</a>
            </div> 
        </div>
    </div>
</body>
<?php include_once 'view/include/footer_link.php'?>
</html>