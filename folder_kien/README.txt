thư viện được viết dưới dang class

// include file
$_api = new api_vt();

Mẫu dữ liệu để phát hành hóa đơn hoặc tạo hóa đơn nháp

$_generalInvoiceInfo = [
    'invoiceType'           => '01GTKT',        // mã loại hóa đơn
    'templateCode'          => '01GTKT0/001',   // ký hiệu mẫu hóa đơn
    'currencyCode'          => 'VND',           // Mã đơn vị tiền tệ
    'adjustmentType'        => '1',             // Trạng thái [1 : hóa đơn gốc, 3 : Hóa đơn thay thế, 5 : Hóa đơn điều chỉnh]
    'paymentStatus'         => true,            // trạng thái thanh toán hóa đơn [true : đã thanh toán, false : chưa thanh toán]
    'paymentType'           => 'TM',            
    'paymentTypeName'       => 'TM',
    'cusGetInvoiceRight'    => true,
    'userName'              => 'user 1'
];

// thông tin ng mua
$_buyerInfo = [
    'buyerName'         =>'Đặng thị thanh tâm 765781426767',
    'buyerLegalName'    =>'Tên cơ quan',
    'buyerTaxCode'      =>'Mã số thuế',
    'buyerAddressLine'  =>'HN VN',
    'buyerPhoneNumber'  =>'11111',
    'buyerEmail'        =>'',
    'buyerIdNo'         =>'123456789',
    'buyerIdType'       =>'1'
];

// thông tin người bán
$_sellerInfo = [
    'sellerLegalName'   =>'Đặng thị thanh tâm',
    'sellerTaxCode'     =>'0100109106-501',
    'sellerAddressLine' =>'test',
    'sellerPhoneNumber' =>'0123456789',
    'sellerEmail'       =>'PerformanceTest1@viettel.com.vn',
    'sellerBankName'    =>'vtbank',
    'sellerBankAccount' =>'23423424'
];

// thông tin hàng hóa
$_item_infor = [
    'lineNumber'                =>  1,                  
    'itemCode'                  =>  'ENGLISH_COURSE',
    'itemName'                  =>  'Khóa học tiếng anh',
    'unitName'                  =>  'khóa học',
    'unitPrice'                 =>  3500000.0,              // đơn giá
    'quantity'                  =>  10.0,                   // số lượng
    'itemTotalAmountWithoutTax' =>  35000000,
    'taxPercentage'             =>  10.0,
    'taxAmount'                 =>  0.0,
    'discount'                  =>  0,
    'itemDiscount'              =>  0,
    'itemTotalAmountWithTax'    =>  35000000.0
];

// thống kê tổng
$_summarizeInfo = [
    'sumOfTotalLineAmountWithoutTax'    =>35000000,
    'totalAmountWithoutTax'             =>35000000,
    'totalTaxAmount'                    =>3500000.0,
    'totalAmountWithTax'                =>38500000,
    'discountAmount'                    =>0.0,
    'settlementDiscountAmount'          =>0.0,
    'taxPercentage'                     =>10.0
];

Phát hành hóa đơn

$_api->set_generalInvoiceInfo($_generalInvoiceInfo)
        ->set_buyerInfo($_buyerInfo)
        ->set_sellerInfo($_sellerInfo)
        ->add_payment(['paymentMethodName'  => 'TM'])
        ->add_itemInfo($_item_infor)        
        ->set_summarizeInfo($_summarizeInfo)
        ->create_invoice();

hoặc
$_api->create_invoice([
    'generalInvoiceInfo'        => $_generalInvoiceInfo,
    'sellerInfo'                => $_sellerInfo,
    'buyerInfo'                 => $_buyerInfo,
    'payments'                  => [
        ['paymentMethodName'  => 'TM']
    ],
    'itemInfo'                  => [
        $_item_infor
    ],
    'summarizeInfo'             => $_summarizeInfo,
]);

tương tự thì tạo hóa đơn nháp

thay create_invoice = create_Or_Update_Invoice_Draft

// hủy hóa đơn
$_api->cancel_Transaction_Invoice([
    'supplierTaxCode'           => $_api->get_taxCode(),    // mã số thuế
    'templateCode'              => '01GTKT0/001',           // tên mẫu hóa đơn
    'invoiceNo'                 => 'NS/19E0000008',         // số hóa đơn
    'strIssueDate'              => '20190524152415',        // ngày lập hóa đơn (định dạng yyymmddhhmmss) (chỉ cần đúng ngày tháng năm)
    'additionalReferenceDesc'   => 'Tên văn bản',           // Tên văn bản thỏa thuận hủy hóa đơn
    'additionalReferenceDate'   => date('Ymdhis')           // Ngày thỏa thuận
]);



// lấy kết quả trả về
$_result = $_api->result();
or
$_result = $_api->result_array();
or
$_result = $_api->result_object();

// hủy hóa đơn
