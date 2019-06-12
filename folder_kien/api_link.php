<?php
    $_base_link     = 'https://demo-sinvoice.viettel.vn:8443/InvoiceAPI/';
    $api_link = [
        'createInvoice'                 => 'InvoiceWS/createInvoice/',                          // tao hoa don
        'getInvoiceRepresentationFile'  => 'InvoiceUtilsWS/getInvoiceRepresentationFile',       // lay file hoa don
        'getInvoiceFilePortal'          => 'InvoiceUtilsWS/getInvoiceFilePortal',               // Lấy file hoad don với mã số bí mật
        'cancelTransactionInvoice'      => 'InvoiceWS/cancelTransactionInvoice',                // Hủy hóa đơn
        'createExchangeInvoiceFile'     => 'InvoiceWS/createExchangeInvoiceFile',               // Lấy file hóa đơn chuyển đổi
        'getInvoices'                   => 'InvoiceUtilsWS/getInvoices/',                       // Lấy thông tin hóa đơn
        'createOrUpdateInvoiceDraft'    => 'InvoiceWS/createOrUpdateInvoiceDraft/',             // Lưu nháp
        'getCustomFields'               => 'InvoiceWS/getCustomFields',                         // Lấy thông tin trường động
        'createInvoiceDraftPreview'     => 'InvoiceUtilsWS/createInvoiceDraftPreview/',         // Lấy hóa đơn nháp
        'updateTaxDeclaration'          => 'InvoiceUtilsWS/updateTaxDeclaration',               // Cập nhật kê khai thuế
        'getProvidesStatusUsingInvoice' => 'InvoiceUtilsWS/getProvidesStatusUsingInvoice',      // Cung cấp tình hình sử dụng hóa đơn theo dải
        'getListInvoiceDataControl'     => 'InvoiceUtilsWS/getListInvoiceDataControl',          // Cung cấp danh sách hóa đơn theo khoảng thời gian
        'updatePaymentStatus'           => 'InvoiceWS/updatePaymentStatus',                     // Cập nhật trạng thái thanh toán
        'cancelPaymentStatus'           => 'InvoiceWS/cancelPaymentStatus',                     // Hủy trạng thái thanh toán
    ];
?>