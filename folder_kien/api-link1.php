<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
if(!isset($_SESSION['user_id'])){
   header('location: 404error.html');
}
$id_account = $_SESSION["user_id"];
if(file_exists('../common/php/connection.php'))
	require_once '../common/php/connection.php';
// Truy vấn thông tin tài khoản VT
$result 			= mysqli_query(connection(),"SELECT * FROM `account` WHERE `id_account` = $id_account");	//$_SESSION['user_id']
$row 				= mysqli_fetch_array($result);    //Biến kết quả truy xuất tài khoản
$username 			= $row['vtname'];
$password 			= $row['vtpassword'];
$seller_id			= $row['seller_id'];
// Truy vấn thông tin doanh nghiệp
$seller_rs 			= mysqli_query(connection(),"SELECT * FROM `sellerinfo` WHERE `seller_id` = $seller_id");
$seller_row			= mysqli_fetch_array($seller_rs);
$supplierTaxCode	= $seller_row['sellerTaxCode'];
//Lập hóa đơn
$create_invoive = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/createInvoice/'.$supplierTaxCode;
$create_invoive_with_certificate = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/createInvoiceUsbTokenGetHash/'.$supplierTaxCode;
$insert_certificate_to_usb = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/createInvoiceUsbTokenInsertHash/'.$supplierTaxCode;
//Lấy file hóa đơn
$representation_file = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/getInvoiceRepresentationFile/';
//Lấy file có mã bí mật
$file_portal = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/getInvoiceFilePortal/';
//Hóa đơn chuyển đổi
$exchange_file = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/createExchangeInvoiceFile/';
//Hủy hóa đơn
$cancel_invoice = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/cancelTransactionInvoice/';
//Tra cứu hóa đơn
$get_invoices = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/getInvoices/'.$supplierTaxCode;
//Trường động
$custom_fields = 'https://API-sinvoice.viettel.vn:443/InvoiceAPI/InvoiceWS/getCustomFields?taxCode='.$supplierTaxCode;
//Lập hóa đơn nháp
$create_draft = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/createOrUpdateInvoiceDraft/'.$supplierTaxCode;
//Lập hóa đơn theo lô
$create_batch = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceWS/createBatchInvoice/'.$supplierTaxCode;
//Cập nhật kê khai thuế
$update_tax = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/updateTaxDeclaration/';
//Tình hình hóa đơn theo dải
$get_provides_status = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/getProvidesStatusUsingInvoice/';
//Danh sách hóa đơn theo khoảng thời gian
$get_list_by_time = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/getListInvoiceDataControl';
//Gửi mail cho hóa đơn khách hàng
$send_mail = 'https://API-sinvoice.viettel.vn/InvoiceAPI/InvoiceUtilsWS/sendHtmlMailProcess';
?>