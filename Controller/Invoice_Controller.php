<?php
    class Invoice_Controller extends MY_Controller{
        function __construct(){
            parent::__construct();
        }

        function index(){
            $_infor = $this->db->get_data('tbl_invoiceinfo',[],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
                                                    
            $_infor = $this->db->to_array($_infor);
            $this->load_view('Master', array(
                'main_View'         => 'Home',
                'invoiceinfor'      => $_infor
            ));
        }

        function create_invoice(){
            if(isset($_GET['id_invoice'])){
                $_id_invoice = $_GET['id_invoice'];
                // lấy thông tin bảng hóa đơn
                $_infor = $this->db->get_data('tbl_invoiceinfo',
                                            ['invoiceinfo_id'   => $_id_invoice],
                                            [
                                                'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                                'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                                'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                            ]);
                // to array
                $_infor = $this->db->to_array($_infor);

                $_infor = !empty($_infor) ? $_infor[0] : array();            

                //print_r($_infor);            

                $_generalInvoiceInfo = [
                    'invoiceType'           => $_infor['templateinfo_invoicetype'],         // required
                    'templateCode'          => $_infor['templateinfo_templatecode'],        // required
                    'currencyCode'          => $_infor['invoiceinfo_currencycode'],         // required
                    'adjustmentType'        => 1,       // required
                    'paymentStatus'         => $_infor['invoiceinfo_paymentstatus'] ? true : false,        // required
                    //'paymentType'           => $_infor['invoiceinfo_paymenttype'],
                    //'paymentTypeName'       => $_infor['invoiceinfo_paymenttypename']
                ];

                $_buyerInfo = [
                    'buyerName'             => $_infor['buyerinfo_buyername'],              // required
                    'buyerLegalName'        => $_infor['buyerinfo_buyerlegalname'],         // required
                    'buyerTaxCode'          => $_infor['buyerinfo_buyertaxcode'],
                    'buyerAddressLine'      => $_infor['buyerinfo_buyeraddressline'],
                    'buyerPhoneNumber'      => $_infor['buyerinfo_buyerphonenumber'],
                    'buyerEmail'            => $_infor['buyerinfo_buyeremail'],
                    'buyerIdNo'             => $_infor['buyerinfo_buyeridno'],
                    'buyerIdType'           => $_infor['buyerinfo_buyeridtype']
                ];

                $_sellerInfo = [
                    'sellerLegalName'       => $_infor['sellerinfo_sellerlegalname'],
                    'sellerTaxCode'         => $_infor['sellerinfo_sellertaxcode'],
                    'sellerAddressLine'     => $_infor['sellerinfo_selleraddressline'],
                    'sellerPhoneNumber'     => $_infor['sellerinfo_sellerphonenumber'],
                    'sellerEmail'           => $_infor['sellerinfo_selleremail'],
                    'sellerBankName'        => $_infor['sellerinfo_sellerbankname'],
                    'sellerBankAccount'     => $_infor['sellerinfo_sellerbankaccount']
                ];

                // get item base invoice id
                $_items = $this->db->get_data('tbl_iteminvoiceinfo',['iteminvoiceinfo_invoice_id'   => $_id_invoice],
                                            ['tbl_iteminfo' => 'tbl_iteminfo.iteminfo_id = tbl_iteminvoiceinfo.iteminvoiceinfo_item_id']);

                $_items_info = [];
                foreach ($_items as $key => $value) {
                    $_items_info[] = [
                        'lineNumber'                => (empty($value['iteminvoiceinfo_linenumber']) || $value['iteminvoiceinfo_linenumber'] == 0) ? $key + 1 : $value['iteminvoiceinfo_linenumber'],
                        'itemCode'                  => $value['iteminfo_itemcode'],
                        'itemName'                  => $value['iteminfo_itemname'],
                        'unitName'                  => $value['iteminfo_unitname'],
                        'unitPrice'                 => $value['iteminvoiceinfo_unitprice'],
                        'quantity'                  => $value['iteminvoiceinfo_quantity'],
                        'itemTotalAmountWithoutTax' => $value['iteminvoiceinfo_itemtotalamountwithouttax'],
                        'taxPercentage'             => $value['iteminvoiceinfo_taxpercentage'],
                        'taxAmount'                 => $value['iteminvoiceinfo_taxamount'],
                        'discount'                  => $value['iteminvoiceinfo_discount'],
                        'itemDiscount'              => $value['iteminvoiceinfo_itemdiscount'],
                        'itemTotalAmountWithTax'    => $value['iteminvoiceinfo_itemtotalamountwithtax']
                    ];
                }
                
                // caculate sumazi
                $_summarizeInfo = [
                    'sumOfTotalLineAmountWithoutTax'    => 0,     // required
                    'totalAmountWithoutTax'             => 0,     // required
                    'totalTaxAmount'                    => 0,
                    'totalAmountWithTax'                => 0,
                    'discountAmount'                    => 0,
                    //'settlementDiscountAmount'          =>0.0,
                    //'taxPercentage'                     =>10.0
                ];

                foreach ($_items_info as $key => $value) {
                    $_summarizeInfo['sumOfTotalLineAmountWithoutTax']   += $value['itemTotalAmountWithoutTax'];
                    $_summarizeInfo['totalAmountWithoutTax']            += $value['itemTotalAmountWithoutTax'];
                    $_summarizeInfo['totalTaxAmount']                   += $value['taxAmount'];
                    $_summarizeInfo['totalAmountWithTax']               += $value['itemTotalAmountWithTax'];
                    $_summarizeInfo['discountAmount']                   += $value['itemDiscount'];
                }

                foreach ($_items_info as $key => $value) {
                    $this->api->add_itemInfo($value);
                }

                $this->api
                    ->set_generalInvoiceInfo($_generalInvoiceInfo)
                    ->set_buyerInfo($_buyerInfo)
                    ->set_sellerInfo($_sellerInfo)                                
                    ->set_summarizeInfo($_summarizeInfo)
                    ->create_invoice();                
            
                $_result = $this->api->result_array();

                print_r($_result);
                if(empty($_result['errorCode'])){
                    $_result = $_result['result'];
                    $this->db->update_data('tbl_invoiceinfo',[
                        'invoiceinfo_suppliertaxcode'       => isset($_result['supplierTaxCode']) ? $_result['supplierTaxCode'] : 'NULL',
                        'invoiceinfo_invoiceno'             => isset($_result['invoiceNo']) ? $_result['invoiceNo'] : 'NULL',
                        'invoiceinfo_transactionid'         => isset($_result['transactionID']) ? $_result['transactionID'] : 'NULL',
                        'invoiceinfo_reservationcode'       => isset($_result['reservationCode']) ? $_result['reservationCode'] : 'NULL',
                        'invoiceinfo_released'              => true,
                        'invoiceinfo_releasedtime'          => time(),
                        'invoiceinfo_cancel'                => false,
                        'invoiceinfo_adjustmenttype'        => 1
                    ],['invoiceinfo_id'   => $_id_invoice]);
                }
            }
        }

        function create_draft_invoice(){
            $_id_invoice = 3;
            // lấy thông tin bảng hóa đơn
            $_infor = $this->db->get_data('tbl_invoiceinfo',
                                        ['invoiceinfo_id'   => $_id_invoice],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
            // to array
            $_infor = $this->db->to_array($_infor);

            $_infor = !empty($_infor) ? $_infor[0] : array();            

            //print_r($_infor);

            $_generalInvoiceInfo = [
                'invoiceType'           => $_infor['templateinfo_invoicetype'],         // required
                'templateCode'          => $_infor['templateinfo_templatecode'],        // required
                'currencyCode'          => $_infor['invoiceinfo_currencycode'],         // required
                'adjustmentType'        => $_infor['invoiceinfo_adjustmenttype'],       // required
                'paymentStatus'         => $_infor['invoiceinfo_paymentstatus'] ? true : false,        // required
                //'paymentType'           => $_infor['invoiceinfo_paymenttype'],
                //'paymentTypeName'       => $_infor['invoiceinfo_paymenttypename']                
            ];

            $_buyerInfo = [
                'buyerName'             => $_infor['buyerinfo_buyername'],              // required
                'buyerLegalName'        => $_infor['buyerinfo_buyerlegalname'],         // required
                'buyerTaxCode'          => $_infor['buyerinfo_buyertaxcode'],
                'buyerAddressLine'      => $_infor['buyerinfo_buyeraddressline'],
                'buyerPhoneNumber'      => $_infor['buyerinfo_buyerphonenumber'],
                'buyerEmail'            => $_infor['buyerinfo_buyeremail'],
                'buyerIdNo'             => $_infor['buyerinfo_buyeridno'],
                'buyerIdType'           => $_infor['buyerinfo_buyeridtype']
            ];

            $_sellerInfo = [
                'sellerLegalName'       => $_infor['sellerinfo_sellerlegalname'],
                'sellerTaxCode'         => $_infor['sellerinfo_sellertaxcode'],
                'sellerAddressLine'     => $_infor['sellerinfo_selleraddressline'],
                'sellerPhoneNumber'     => $_infor['sellerinfo_sellerphonenumber'],
                'sellerEmail'           => $_infor['sellerinfo_selleremail'],
                'sellerBankName'        => $_infor['sellerinfo_sellerbankname'],
                'sellerBankAccount'     => $_infor['sellerinfo_sellerbankaccount']
            ];

            // get item base invoice id
            $_items = $this->db->get_data('tbl_iteminvoiceinfo',['iteminvoiceinfo_invoice_id'   => $_id_invoice],
                                        ['tbl_iteminfo' => 'tbl_iteminfo.iteminfo_id = tbl_iteminvoiceinfo.iteminvoiceinfo_item_id']);

            $_items_info = [];
            foreach ($_items as $key => $value) {
                $_items_info[] = [
                    'lineNumber'                => (empty($value['iteminvoiceinfo_linenumber']) || $value['iteminvoiceinfo_linenumber'] == 0) ? $key + 1 : $value['iteminvoiceinfo_linenumber'],
                    'itemCode'                  => $value['iteminfo_itemcode'],
                    'itemName'                  => $value['iteminfo_itemname'],
                    'unitName'                  => $value['iteminfo_unitname'],
                    'unitPrice'                 => $value['iteminvoiceinfo_unitprice'],
                    'quantity'                  => $value['iteminvoiceinfo_quantity'],
                    'itemTotalAmountWithoutTax' => $value['iteminvoiceinfo_itemtotalamountwithouttax'],
                    'taxPercentage'             => $value['iteminvoiceinfo_taxpercentage'],
                    'taxAmount'                 => $value['iteminvoiceinfo_taxamount'],
                    'discount'                  => $value['iteminvoiceinfo_discount'],
                    'itemDiscount'              => $value['iteminvoiceinfo_itemdiscount'],
                    'itemTotalAmountWithTax'    => $value['iteminvoiceinfo_itemtotalamountwithtax']
                ];
            }
            
            // caculate sumazi
            $_summarizeInfo = [
                'sumOfTotalLineAmountWithoutTax'    => 0,     // required
                'totalAmountWithoutTax'             => 0,     // required
                'totalTaxAmount'                    => 0,
                'totalAmountWithTax'                => 0,
                'discountAmount'                    => 0,
                //'settlementDiscountAmount'          =>0.0,
                //'taxPercentage'                     =>10.0
            ];

            foreach ($_items_info as $key => $value) {
                $_summarizeInfo['sumOfTotalLineAmountWithoutTax']   += $value['itemTotalAmountWithoutTax'];
                $_summarizeInfo['totalAmountWithoutTax']            += $value['itemTotalAmountWithoutTax'];
                $_summarizeInfo['totalTaxAmount']                   += $value['taxAmount'];
                $_summarizeInfo['totalAmountWithTax']               += $value['itemTotalAmountWithTax'];
                $_summarizeInfo['discountAmount']                   += $value['itemDiscount'];
            }

            foreach ($_items_info as $key => $value) {
                $this->api->add_itemInfo($value);
            }

            $this->api
                ->set_generalInvoiceInfo($_generalInvoiceInfo)
                ->set_buyerInfo($_buyerInfo)
                ->set_sellerInfo($_sellerInfo)                                
                ->set_summarizeInfo($_summarizeInfo)
                ->create_Or_Update_Invoice_Draft();
        
            $_result = $this->api->result_array();

            print_r($_result);
        }

        function create_replace_invoice(){
            $_id_invoice = 3;
            $_id_from = 3;
            
            // laasy thong tin hoa don goc
            $_infor_from = $this->db->get_data('tbl_invoiceinfo',
                                        ['invoiceinfo_id'   => $_id_from],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
            // to array
            $_infor_from = $this->db->to_array($_infor_from);

            $_infor_from = !empty($_infor_from) ? $_infor_from[0] : array();  

            // lấy thông tin bảng hóa đơn
            $_infor = $this->db->get_data('tbl_invoiceinfo',
                                        ['invoiceinfo_id'   => $_id_invoice],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
            // to array
            $_infor = $this->db->to_array($_infor);

            $_infor = !empty($_infor) ? $_infor[0] : array();            

            //print_r($_infor);      
            //echo $_infor_from['invoiceinfo_invoiceno'];

            $_generalInvoiceInfo = [
                'invoiceType'           => $_infor['templateinfo_invoicetype'],         // required
                'templateCode'          => $_infor['templateinfo_templatecode'],        // required
                'currencyCode'          => $_infor['invoiceinfo_currencycode'],         // required
                'adjustmentType'        => 3,       // required
                'originalInvoiceId'     => $_infor_from['invoiceinfo_invoiceno'],
                'originalInvoiceIssueDate'  => $_infor_from['invoiceinfo_releasedtime']*1000,
                'paymentStatus'         => $_infor['invoiceinfo_paymentstatus'] ? true : false,        // required
                //'paymentType'           => $_infor['invoiceinfo_paymenttype'],
                //'paymentTypeName'       => $_infor['invoiceinfo_paymenttypename']
            ];

            $_buyerInfo = [
                'buyerName'             => $_infor['buyerinfo_buyername'],              // required
                'buyerLegalName'        => $_infor['buyerinfo_buyerlegalname'],         // required
                'buyerTaxCode'          => $_infor['buyerinfo_buyertaxcode'],
                'buyerAddressLine'      => $_infor['buyerinfo_buyeraddressline'],
                'buyerPhoneNumber'      => $_infor['buyerinfo_buyerphonenumber'],
                'buyerEmail'            => $_infor['buyerinfo_buyeremail'],
                'buyerIdNo'             => $_infor['buyerinfo_buyeridno'],
                'buyerIdType'           => $_infor['buyerinfo_buyeridtype']
            ];

            $_sellerInfo = [
                //'sellerLegalName'       => $_infor['sellerinfo_sellerlegalname'],
                'sellerTaxCode'         => $_infor['sellerinfo_sellertaxcode'],
                'sellerAddressLine'     => $_infor['sellerinfo_selleraddressline'],
                'sellerPhoneNumber'     => $_infor['sellerinfo_sellerphonenumber'],
                'sellerEmail'           => $_infor['sellerinfo_selleremail'],
                'sellerBankName'        => $_infor['sellerinfo_sellerbankname'],
                'sellerBankAccount'     => $_infor['sellerinfo_sellerbankaccount']
            ];

            // get item base invoice id
            $_items = $this->db->get_data('tbl_iteminvoiceinfo',['iteminvoiceinfo_invoice_id'   => $_id_invoice],
                                        ['tbl_iteminfo' => 'tbl_iteminfo.iteminfo_id = tbl_iteminvoiceinfo.iteminvoiceinfo_item_id']);

            $_items_info = [];
            foreach ($_items as $key => $value) {
                $_items_info[] = [
                    'lineNumber'                => (empty($value['iteminvoiceinfo_linenumber']) || $value['iteminvoiceinfo_linenumber'] == 0) ? $key + 1 : $value['iteminvoiceinfo_linenumber'],
                    'itemCode'                  => $value['iteminfo_itemcode'],
                    'itemName'                  => $value['iteminfo_itemname'],
                    'unitName'                  => $value['iteminfo_unitname'],
                    'unitPrice'                 => $value['iteminvoiceinfo_unitprice'],
                    'quantity'                  => $value['iteminvoiceinfo_quantity'],
                    'itemTotalAmountWithoutTax' => $value['iteminvoiceinfo_itemtotalamountwithouttax'],
                    'taxPercentage'             => $value['iteminvoiceinfo_taxpercentage'],
                    'taxAmount'                 => $value['iteminvoiceinfo_taxamount'],
                    'discount'                  => $value['iteminvoiceinfo_discount'],
                    'itemDiscount'              => $value['iteminvoiceinfo_itemdiscount'],
                    'itemTotalAmountWithTax'    => $value['iteminvoiceinfo_itemtotalamountwithtax']
                ];
            }
            
            // caculate sumazi
            $_summarizeInfo = [
                'sumOfTotalLineAmountWithoutTax'    => 0,     // required
                'totalAmountWithoutTax'             => 0,     // required
                'totalTaxAmount'                    => 0,
                'totalAmountWithTax'                => 0,
                'discountAmount'                    => 0,
                //'settlementDiscountAmount'          =>0.0,
                //'taxPercentage'                     =>10.0
            ];

            foreach ($_items_info as $key => $value) {
                $_summarizeInfo['sumOfTotalLineAmountWithoutTax']   += $value['itemTotalAmountWithoutTax'];
                $_summarizeInfo['totalAmountWithoutTax']            += $value['itemTotalAmountWithoutTax'];
                $_summarizeInfo['totalTaxAmount']                   += $value['taxAmount'];
                $_summarizeInfo['totalAmountWithTax']               += $value['itemTotalAmountWithTax'];
                $_summarizeInfo['discountAmount']                   += $value['itemDiscount'];
            }

            foreach ($_items_info as $key => $value) {
                $this->api->add_itemInfo($value);
            }

            $this->api
                ->set_generalInvoiceInfo($_generalInvoiceInfo)
                ->set_buyerInfo($_buyerInfo)
                ->set_sellerInfo($_sellerInfo)                                
                ->set_summarizeInfo($_summarizeInfo)
                ->create_invoice();                
        
            $_result = $this->api->result_array();

            echo $this->api->get_data_send_json();

            print_r($_result);
            if(empty($_result['errorCode'])){
                $_result = $_result['result'];
                $this->db->update_data('tbl_invoiceinfo',[
                    'invoiceinfo_suppliertaxcode'       => isset($_result['supplierTaxCode']) ? $_result['supplierTaxCode'] : 'NULL',
                    'invoiceinfo_invoiceno'             => isset($_result['invoiceNo']) ? $_result['invoiceNo'] : 'NULL',
                    'invoiceinfo_transactionid'         => isset($_result['transactionID']) ? $_result['transactionID'] : 'NULL',
                    'invoiceinfo_reservationcode'       => isset($_result['reservationCode']) ? $_result['reservationCode'] : 'NULL',
                    'invoiceinfo_released'              => true,
                    'invoiceinfo_releasedtime'          => time(),
                    'invoiceinfo_adjustmenttype'        => 1
                ],['invoiceinfo_id'   => $_id_invoice]);

                // update trang thai hoa don thay thês
                $this->db->update_data('tbl_invoiceinfo',[
                    'invoiceinfo_replaced'                          => true,
                    'invoiceinfo_replaceby'                         => $_id_invoice,
                    'invoiceinfo_replacetime'                       => time(),
                    'invoiceinfo_adjustmenttype'                    => 3
                ],['invoiceinfo_id'   => $_id_from]);
            }
        }

        function cancel_invoice(){
            if(isset($_GET['id_invoice'])){
                $_id_invoice = $_GET['id_invoice'];
                // lấy thông tin bảng hóa đơn
                $_infor = $this->db->get_data('tbl_invoiceinfo',
                                            ['invoiceinfo_id'   => $_id_invoice],
                                            [
                                                'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                                'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                                'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                            ]);
                // to array
                $_infor = $this->db->to_array($_infor);

                $_infor = !empty($_infor) ? $_infor[0] : array();            

                $this->api->cancel_Transaction_Invoice([
                    'supplierTaxCode'           => $_infor['invoiceinfo_suppliertaxcode'],
                    'templateCode'              => $_infor['templateinfo_templatecode'],
                    'invoiceNo'                 => $_infor['invoiceinfo_invoiceno'],
                    'strIssueDate'              => date('YmdHis', $_infor['invoiceinfo_releasedtime']),
                    'additionalReferenceDesc'   => $_infor['invoiceinfo_additionalreferencedesc'],
                    'additionalReferenceDate'   => !empty($_infor['invoiceinfo_additionalreferencetime']) ? date('YmdHis', $_infor['invoiceinfo_additionalreferencetime']) : date('YmdHis', strtotime(date('d-m-Y')))
                ]);

                $_result = $this->api->result_array();
                if(empty($_result['errorCode'])){
                    echo 'Xoa hoa don thanh cong';
                    // cap nhat trang thai
                    $this->db->update_data('tbl_invoiceinfo',[
                        'invoiceinfo_cancel'        => true,
                        'invoiceinfo_canceltime'    => time()
                    ],['invoiceinfo_id'   => $_id_invoice]);
                }else{
                    print_r($_result);
                }
            }
        }

        function cancel_payment_status(){
            if(isset($_GET['id_invoice'])){
                $_id_invoice = $_GET['id_invoice'];
                // lấy thông tin bảng hóa đơn
                $_infor = $this->db->get_data('tbl_invoiceinfo',
                                            ['invoiceinfo_id'   => $_id_invoice],
                                            [
                                                'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                                'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                                'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                            ]);
                // to array
                $_infor = $this->db->to_array($_infor);

                $_infor = !empty($_infor) ? $_infor[0] : array();
                $this->api->cancel_Payment_Status([
                    'supplierTaxCode'       => $_infor['invoiceinfo_suppliertaxcode'],
                    'invoiceNo'             => $_infor['invoiceinfo_invoiceno'],            
                    'strIssueDate'          => date('YmdHis',$_infor['invoiceinfo_releasedtime'])
                ]);
    
                $_result = $this->api->result_array();
                if(empty($_result['errorCode']) && $_result['result']){
                    echo 'Hủy trạng thái thanh toán thanh cong';
                    // cap nhat trang thai
                    $this->db->update_data('tbl_invoiceinfo',[
                        'invoiceinfo_paymentstatus'        => false                        
                    ],['invoiceinfo_id'   => $_id_invoice]);
                }else{
                    print_r($_result);
                }
            }
        }

        function get_file_invoice(){
            if(isset($_GET['id_invoice'])){
                $_id_invoice = $_GET['id_invoice'];
                $type = isset($_GET['type']) ? $_GET['type'] : 'view';

                // lấy thông tin bảng hóa đơn
                $_infor = $this->db->get_data('tbl_invoiceinfo',
                                            ['invoiceinfo_id'   => $_id_invoice],
                                            [
                                                'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                                'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                                'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                            ]);
                // to array
                $_infor = $this->db->to_array($_infor);

                $_infor = !empty($_infor) ? $_infor[0] : array();
                // lay file hoa don
                $this->api->get_Invoice_Representation_File([
                    'supplierTaxCode'       => $_infor['invoiceinfo_suppliertaxcode'],
                    'invoiceNo'             => $_infor['invoiceinfo_invoiceno'],
                    'templateCode'          => $_infor['templateinfo_templatecode'],
                    'fileType'              =>'pdf'
                ]);

                if($type == 'view')
                    $this->api->view_file();
                else $this->api->download_file();
            }
        }
        
        function get_status_use_invoice(){
            $_id_invoice    = 3;
            $_temp_id       = 1;
            $_supplier_id   = 1;

            // get infor temp
            $_infor_temp    = $this->db->get_data('tbl_templateinfo', ['templateinfo_id'   => $_temp_id]);
            $_infor_temp    = $this->db->to_array($_infor_temp);
            $_infor_temp    = !empty($_infor_temp) ? $_infor_temp[0] : array();

            // get infor supplier
            $_supplier_infor    = $this->db->get_data('tbl_supplierinfo', ['supplierinfo_id'   => $_supplier_id]);            
            $_supplier_infor    = $this->db->to_array($_supplier_infor);
            $_supplier_infor    = !empty($_supplier_infor) ? $_supplier_infor[0] : array();

            print_r($_supplier_infor);

            $this->api->get_Provides_Status_Using_Invoice([
                'supplierTaxCode'       =>  $_supplier_infor['supplierinfo_taxcode'],
                'templateCode'          =>  $_infor_temp['templateinfo_templatecode'],
                'serial'                =>  $_infor_temp['templateinfo_serial']
            ]);

            $result = $this->api->result_array();            
            print_r($result);
        }

        function get_invoice(){
            $_id_invoice = 3;
            // lấy thông tin bảng hóa đơn
            $_infor = $this->db->get_data('tbl_invoiceinfo',
                                        ['invoiceinfo_id'   => $_id_invoice],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
            // to array
            $_infor = $this->db->to_array($_infor);

            $_infor = !empty($_infor) ? $_infor[0] : array();

            $this->api->get_Invoice([
                'rowPerPage'        => 20,
                'startDate'         => '2019-01-12',
                'endDate'           => date('Y-m-d'),
                'invoiceNo'         => $_infor['invoiceinfo_invoiceno']
            ]);

            $result = $this->api->result_array();            
            print_r($result);
        }

        function get_file_invoice_draft_preview(){
            $_id_invoice = 3;
            // lấy thông tin bảng hóa đơn
            $_infor = $this->db->get_data('tbl_invoiceinfo',
                                        ['invoiceinfo_id'   => $_id_invoice],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
            // to array
            $_infor = $this->db->to_array($_infor);

            $_infor = !empty($_infor) ? $_infor[0] : array();            

            //print_r($_infor);

            $_generalInvoiceInfo = [
                'invoiceType'           => $_infor['templateinfo_invoicetype'],         // required
                'templateCode'          => $_infor['templateinfo_templatecode'],        // required
                'currencyCode'          => $_infor['invoiceinfo_currencycode'],         // required
                'adjustmentType'        => $_infor['invoiceinfo_adjustmenttype'],       // required
                'paymentStatus'         => $_infor['invoiceinfo_paymentstatus'] ? true : false,        // required
                //'paymentType'           => $_infor['invoiceinfo_paymenttype'],
                //'paymentTypeName'       => $_infor['invoiceinfo_paymenttypename']                
            ];

            $_buyerInfo = [
                'buyerName'             => $_infor['buyerinfo_buyername'],              // required
                'buyerLegalName'        => $_infor['buyerinfo_buyerlegalname'],         // required
                'buyerTaxCode'          => $_infor['buyerinfo_buyertaxcode'],
                'buyerAddressLine'      => $_infor['buyerinfo_buyeraddressline'],
                'buyerPhoneNumber'      => $_infor['buyerinfo_buyerphonenumber'],
                'buyerEmail'            => $_infor['buyerinfo_buyeremail'],
                'buyerIdNo'             => $_infor['buyerinfo_buyeridno'],
                'buyerIdType'           => $_infor['buyerinfo_buyeridtype']
            ];

            $_sellerInfo = [
                'sellerLegalName'       => $_infor['sellerinfo_sellerlegalname'],
                'sellerTaxCode'         => $_infor['sellerinfo_sellertaxcode'],
                'sellerAddressLine'     => $_infor['sellerinfo_selleraddressline'],
                'sellerPhoneNumber'     => $_infor['sellerinfo_sellerphonenumber'],
                'sellerEmail'           => $_infor['sellerinfo_selleremail'],
                'sellerBankName'        => $_infor['sellerinfo_sellerbankname'],
                'sellerBankAccount'     => $_infor['sellerinfo_sellerbankaccount']
            ];

            // get item base invoice id
            $_items = $this->db->get_data('tbl_iteminvoiceinfo',['iteminvoiceinfo_invoice_id'   => $_id_invoice],
                                        ['tbl_iteminfo' => 'tbl_iteminfo.iteminfo_id = tbl_iteminvoiceinfo.iteminvoiceinfo_item_id']);

            $_items_info = [];
            foreach ($_items as $key => $value) {
                $_items_info[] = [
                    'lineNumber'                => (empty($value['iteminvoiceinfo_linenumber']) || $value['iteminvoiceinfo_linenumber'] == 0) ? $key + 1 : $value['iteminvoiceinfo_linenumber'],
                    'itemCode'                  => $value['iteminfo_itemcode'],
                    'itemName'                  => $value['iteminfo_itemname'],
                    'unitName'                  => $value['iteminfo_unitname'],
                    'unitPrice'                 => $value['iteminvoiceinfo_unitprice'],
                    'quantity'                  => $value['iteminvoiceinfo_quantity'],
                    'itemTotalAmountWithoutTax' => $value['iteminvoiceinfo_itemtotalamountwithouttax'],
                    'taxPercentage'             => $value['iteminvoiceinfo_taxpercentage'],
                    'taxAmount'                 => $value['iteminvoiceinfo_taxamount'],
                    'discount'                  => $value['iteminvoiceinfo_discount'],
                    'itemDiscount'              => $value['iteminvoiceinfo_itemdiscount'],
                    'itemTotalAmountWithTax'    => $value['iteminvoiceinfo_itemtotalamountwithtax']
                ];
            }
            
            // caculate sumazi
            $_summarizeInfo = [
                'sumOfTotalLineAmountWithoutTax'    => 0,     // required
                'totalAmountWithoutTax'             => 0,     // required
                'totalTaxAmount'                    => 0,
                'totalAmountWithTax'                => 0,
                'discountAmount'                    => 0,
                //'settlementDiscountAmount'          =>0.0,
                //'taxPercentage'                     =>10.0
            ];

            foreach ($_items_info as $key => $value) {
                $_summarizeInfo['sumOfTotalLineAmountWithoutTax']   += $value['itemTotalAmountWithoutTax'];
                $_summarizeInfo['totalAmountWithoutTax']            += $value['itemTotalAmountWithoutTax'];
                $_summarizeInfo['totalTaxAmount']                   += $value['taxAmount'];
                $_summarizeInfo['totalAmountWithTax']               += $value['itemTotalAmountWithTax'];
                $_summarizeInfo['discountAmount']                   += $value['itemDiscount'];
            }

            foreach ($_items_info as $key => $value) {
                $this->api->add_itemInfo($value);
            }

            $this->api
                ->set_generalInvoiceInfo($_generalInvoiceInfo)
                ->set_buyerInfo($_buyerInfo)
                ->set_sellerInfo($_sellerInfo)
                ->set_summarizeInfo($_summarizeInfo)
                ->create_Invoice_Draft_Preview();
        
            $_result = $this->api->view_file();
            //print_r($_result);
        }

        function get_file_exchange_invoice(){
            $_id_invoice = 3;
            // lấy thông tin bảng hóa đơn
            $_infor = $this->db->get_data('tbl_invoiceinfo',
                                        ['invoiceinfo_id'   => $_id_invoice],
                                        [
                                            'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                            'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                            'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id'
                                        ]);
            // to array
            $_infor = $this->db->to_array($_infor);

            $_infor = !empty($_infor) ? $_infor[0] : array();

            echo $_infor['invoiceinfo_invoiceno'];

            $this->api->create_Exchange_Invoice_File([
                'supplierTaxCode'       =>  $_infor['invoiceinfo_suppliertaxcode'],
                'invoiceNo'             =>  $_infor['invoiceinfo_invoiceno'],
                'templateCode'          =>  $_infor['templateinfo_templatecode'],
                'strIssueDate'          =>  date('YmdHis',$_infor['invoiceinfo_releasedtime']),
                'exchangeUser'          => 'Nguyễn văn A'
            ]);
    
            print_r($this->api->view_file());
        }

        function update_payment_status(){
            if(isset($_GET['id_invoice'])){
                $_id_invoice = $_GET['id_invoice'];            
                // lấy thông tin bảng hóa đơn
                $_infor = $this->db->get_data('tbl_invoiceinfo',
                                            ['invoiceinfo_id'   => $_id_invoice],
                                            [
                                                'tbl_buyerinfo'     =>  'tbl_invoiceinfo.invoiceinfo_buyerinfo_id = tbl_buyerinfo.buyerinfo_id',
                                                'tbl_sellerinfo'    =>  'tbl_invoiceinfo.invoiceinfo_sellerinfor_id = tbl_sellerinfo.sellerinfo_id',
                                                'tbl_templateinfo'  =>  'tbl_invoiceinfo.invoiceinfo_template_id = tbl_templateinfo.templateinfo_id']);
                // to array
                $_infor = $this->db->to_array($_infor);

                $_infor = !empty($_infor) ? $_infor[0] : array();

                $this->api->update_Payment_Status([
                    'supplierTaxCode'       => $_infor['invoiceinfo_suppliertaxcode'],
                    'invoiceNo'             => $_infor['invoiceinfo_invoiceno'],
                    'templateCode'          => $_infor['templateinfo_templatecode'],            
                    'strIssueDate'          => date('YmdHis',$_infor['invoiceinfo_releasedtime']),
                    'paymentType'           => 'TM',
                    'paymentTypeName'       => 'TM',
                    'cusGetInvoiceRight'    => true
                ]);

                // update trạng thái thanh toán
                $_result = $this->api->result_array();
                if(empty($_result['errorCode']) && $_result['result']){
                    echo 'Cập nhật trạng thái thanh toán thành công';
                    //$_result = $_result['result'];
                    $this->db->update_data('tbl_invoiceinfo',[
                        'invoiceinfo_paymentstatus'     => true
                    ],['invoiceinfo_id'   => $_id_invoice]);
                }else{
                    print_r($this->api->result_array());
                }
            }
        }
    }
?>