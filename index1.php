<?php
    include_once 'folder_kien/api_function.php';
    $_api = new api_vt();
    $_generalInvoiceInfo = [
        'invoiceType'           => '01GTKT',
        'templateCode'          => '01GTKT0/001',
        'currencyCode'          => 'VND',
        'adjustmentType'        => '1',
        'paymentStatus'         => true,
        'paymentType'           => 'TM',
        'paymentTypeName'       => 'TM',
        'cusGetInvoiceRight'    => true,
        'userName'              => 'user 1'
    ];
    
    $_buyerInfo = [
        'buyerName'         => 'Đặng thị thanh tâm 765781426767',
        'buyerLegalName'    => '',
        'buyerTaxCode'      => '',
        'buyerAddressLine'  => 'HN VN',
        'buyerPhoneNumber'  => '11111',
        'buyerEmail'        => '',
        'buyerIdNo'         => '123456789',
        'buyerIdType'       => '1'
    ];

    $_sellerInfo = [
        'sellerLegalName'   => 'Đặng thị thanh tâm',
        'sellerTaxCode'     => '0100109106-501',
        'sellerAddressLine' => 'test',
        'sellerPhoneNumber' => '0123456789',
        'sellerEmail'       => 'PerformanceTest1@viettel.com.vn',
        'sellerBankName'    => 'vtbank',
        'sellerBankAccount' => '23423424'
    ];

    $_item_infor = [
        'lineNumber'                =>  1,
        'itemCode'                  =>  'ENGLISH_COURSE',
        'itemName'                  =>  'Khóa học tiếng anh',
        'unitName'                  =>  'khóa học',
        'unitPrice'                 =>  3500000.0,
        'quantity'                  =>  10.0,
        'itemTotalAmountWithoutTax' =>  35000000,
        'taxPercentage'             =>  10.0,
        'taxAmount'                 =>  0.0,
        'discount'                  =>  0,
        'itemDiscount'              =>  0,
        'itemTotalAmountWithTax'    =>  35000000.0
    ];

    $_summarizeInfo = [
        'sumOfTotalLineAmountWithoutTax'    => 35000000,
        'totalAmountWithoutTax'             => 35000000,
        'totalTaxAmount'                    => 3500000.0,
        'totalAmountWithTax'                => 38500000,
        'discountAmount'                    => 0.0,
        'settlementDiscountAmount'          => 0.0,
        'taxPercentage'                     => 10.0
    ];

    $_taxBreakdowns = [
        'taxPercentage'     => 10.0,
        'taxableAmount'     => 35000000,
        'taxAmount'         => 3500000.0
    ];

    $_api->set_generalInvoiceInfo($_generalInvoiceInfo)
        ->set_buyerInfo($_buyerInfo)
        ->set_sellerInfo($_sellerInfo)
        ->add_payment(['paymentMethodName'  => 'TM'])
        ->add_itemInfo($_item_infor)
        ->add_itemInfo($_item_infor)
        //->set_summarizeInfo($_summarizeInfo)
        ->calculate_summarizeInfo()
        //->create_invoice()
        ->create_Or_Update_Invoice_Draft();

        print_r($_api->result_array());

        // phát hành hóa đơn và lưu nháp giống nhau

    // lay file hoa don
    // $_api->get_Invoice_Representation_File([
    //     'supplierTaxCode'       =>'0201906443',
    //     'invoiceNo'             =>'NS/19E0000005',
    //     'templateCode'          =>'01GTKT0/001',
    //     'fileType'              =>'PDF'
    // ])->download_file();

        // echo $_api->set_data_send([
        //     'supplierTaxCode'       =>'0201906443',
        //     'invoiceNo'             =>'NS/19E0000005',
        //     'templateCode'          =>'01GTKT0/001',
        //     'reservationCode'       =>'D0EB9JK2YU',
        //     'fileType'              =>'PDF'
        // ])->get_data_json();
        // echo '<br>';
        // $_api->get_Invoice_Representation_File_Portal([
        //     'supplierTaxCode'       =>'0201906443',
        //     'invoiceNo'             =>'NS/19E0000005',
        //     'templateCode'          =>'01GTKT0/001',
        //     'reservationCode'       =>'D0EB9JK2YU',
        //     'fileType'              =>'PDF'
        // ]);

?>