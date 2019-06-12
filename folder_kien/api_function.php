<?php
    class api_vt{
        private $_context = '';
        private $_result  = '';
        private $_suplier_tax_code = '0201906443';
        private $_account = ['username' => '0201906443', 'password' => 'Ns!123456'];
        private $_url = '';

        private $_file_type = '';

        private $_data_send = [];

        // Thông tin bên mua
        private $buyerInfo = [
            'buyerName'                 => '',
            'buyerCode'                 => '',
            'buyerLegalName'            => '',
            'buyerTaxCode'              => '',
            'buyerAddressLine'          => '',
            'buyerPhoneNumber'          => '',
            'buyerFaxNumber'            => '',
            'buyerEmail'                => '',
            'buyerBankName'             => '',
            'buyerBankAccount'          => '',
            'buyerDistrictName'         => '',
            'buyerCityName'             => '',
            'buyerCountryCode'          => '',
            'buyerIdNo'                 => '',
            'buyerIdType'               => '',
            'buyerBirthDay'             => ''
        ];

        // Thông tin bên bán
        private $sellerInfo = [
            'sellerLegalName'       => '',
            'sellerTaxCode'         => '',
            'sellerCode'            => '',
            'sellerAddressLine'     => '',
            'sellerPhoneNumber'     => '',
            'sellerFaxNumber'       => '',
            'sellerEmail'           => '',
            'sellerBankName'        => '',
            'sellerBankAccount'     => '',
            'sellerDistrictName'    => '',
            'sellerCityName'        => '',
            'sellerCountryCode'     => '',
            'sellerWebsite'         => ''
        ];

        // Thông tin chung hóa đơn
        private $generalInvoiceInfo = [
            'invoiceType'               => '',
            'templateCode'              => '',
            'invoiceSeries'             => '',
            'invoiceIssuedDate'         => '',
            'currencyCode'              => '',
            'adjustmentType'            => '',
            'adjustmentInvoiceType'     => '',
            'invoiceNo'                 => '',
            'originalInvoiceId'         => '',
            'originalInvoiceIssueDate'  => '',
            'additionalReferenceDesc'   => '',
            'additionalReferenceDate'   => '',
            'paymentStatus'             => '',
            'cusGetInvoiceRight'        => true,
            'transactionUuid'           => '',
            'userName'                  => '',
            'certificateSerial'         => ''
        ];

        // Thông tin 1 hàng hóa
        private $itemInfo   = [
            'lineNumber'                => '',
            'selection'                 => '',
            'itemCode'                  => '',
            'itemName'                  => '',
            'unitCode'                  => '',
            'unitName'                  => '',
            'unitPrice'                 => '',
            'quantity'                  => '',
            'itemTotalAmountWithoutTax' => '',
            'taxPercentage'             => '',
            'taxAmount'                 => '',
            'isIncreaseItem'            => '',
            'itemNote'                  => '',
            'batchNo'                   => '',
            'expDate'                   => '',
            'discount'                  => '',
            'itemDiscount'              => '',
            'itemTotalAmountWithTax'    => ''
        ];

        private $summarizeInfo = [
            'sumOfTotalLineAmountWithoutTax'    =>'',
            'totalAmountWithoutTax'             =>'',
            'totalTaxAmount'                    =>'',
            'totalAmountWithTax'                =>'',
            'discountAmount'                    =>'',
            'settlementDiscountAmount'          =>'',
            'taxPercentage'                     =>''
        ];

        private $payments = [];

        private $payment = [
            'paymentMethodName'         => ''
        ];

        // cai nay ko bat buoc
        private $taxBreakdowns = [
            'taxPercentage'         => '',
            'taxableAmount'         => '',
            'taxAmount'             => '',
            'taxableAmountPos'      => '',
            'taxAmountPos'          => '',
            'taxExemptionReason'    => ''
        ];

        function __construct(){echo 'kien';}
        // function handle
        function set_taxCode($_tax = ''){$this->_suplier_tax_code = $_tax; return $this;}
        function get_taxCode(){return $this->_suplier_tax_code;}

        function set_account($_acc = ['username' => '0201906443', 'password' => 'Ns!123456']){$this->_account = $_acc; return $this;}

        function create_invoice($_data = []){
            $this->_url = $this->get_link_api('createInvoice').$this->_suplier_tax_code;
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            // create context
            return $this->create_context_send_json()->send();
        }

        // lấy file hóa đơn
        function get_Invoice_Representation_File($_data = []){
            $this->_url = $this->get_link_api('getInvoiceRepresentationFile');
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            $this->_file_type = isset($_data['fileType']) ? $_data['fileType'] : 'pdf';            
            // create context
            return $this->create_context_send_json()->send();
        }

        // lấy file hóa đơn vs mã số bí mật
        function get_Invoice_Representation_File_Portal($_data = []){// l
            $this->_url = $this->get_link_api('getInvoiceFilePortal');
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;

            $this->_file_type = isset($_data['fileType']) ? $_data['fileType'] : 'pdf';
            // create context            
            return $this->create_context_send_urlencode()->send();
        }

        // tra cứu hóa đơn
        function get_Invoice($_data = [
            'invoiceNo'         => '',
            'startDate'         => '',
            'endDate'           => '',
            'invoiceType'       => '',
            'rowPerPage'        => '',
            'pageNum'           => '',
            'contractNo'        => '',
            'contractId'        => '',
            'customerId'        => '',
            'buyerIdNo'         => '',
            'templateCode'      => '',
            'invoiceSeri'       => '',
            'getAll'            => ''
        ]){
            $this->_url = $this->get_link_api('getInvoices').$this->_suplier_tax_code;
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;

            // create context
            return $this->create_context_send_json()->send();
        }

        // lập hóa đơn nháp
        function create_Or_Update_Invoice_Draft($_data = []){
            $this->_url         = $this->get_link_api('createOrUpdateInvoiceDraft').$this->_suplier_tax_code;
            $this->_data_send   = !empty($_data) ? $_data : $this->_data_send;

            // create context            
            return $this->create_context_send_json()->send();
        }        
        
        // lấy file hóa đơn chuyển đổi
        function create_Exchange_Invoice_File($_data = [
            'supplierTaxCode'   => '',
            'templateCode'      => '',
            'invoiceNo'         => '',
            'strIssueDate'      => '',  // chua bat buoc
            'exchangeUser'      => ''
        ]){
            $this->_url       = $this->get_link_api('createExchangeInvoiceFile');
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            $this->_file_type = isset($_data['fileType']) ? $_data['fileType'] : 'pdf';

            // create context
            return $this->create_context_send_urlencode()->send();
        }

        function create_Invoice_Draft_Preview($_data = []){
            $this->_url       = $this->get_link_api('createInvoiceDraftPreview').$this->_suplier_tax_code;
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            $this->_file_type = isset($_data['fileType']) ? $_data['fileType'] : 'pdf';

            return $this->create_context_send_json()->send();
        }
        
        // hủy hóa đơn
        function cancel_Transaction_Invoice($_data = [
            'supplierTaxCode'           => '',
            'templateCode'              => '',
            'invoiceNo'                 => '',
            'strIssueDate'              => '',
            'additionalReferenceDesc'   => '',
            'additionalReferenceDate'   => ''
        ]){
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            $this->_url         = $this->get_link_api('cancelTransactionInvoice');
            return $this->create_context_send_urlencode()->send();
        }

        function get_List_Invoice_Data_Control($_data = [
            'supplierTaxCode'       => '',
            'fromDate'              => '',
            'toDate'                => ''
        ]){
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            $this->_url         = $this->get_link_api('getListInvoiceDataControl');
            return $this->create_context_send_json()->send();
        }

        function get_Provides_Status_Using_Invoice($_data = [
            'supplierTaxCode'       => '',
            'templateCode'          => '',
            'serial'                => ''
        ]){
            $this->_url       = $this->get_link_api('getProvidesStatusUsingInvoice');
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;            

            return $this->create_context_send_json()->send();
        }

        // lấy thông tin trường động
        function get_Custom_Fields($_data = [
            'taxCode'           => '',
            'templateCode'      => ''
        ]){
            //$this->_data_send   = !empty($_data) ? $_data : $this->_data_send;
            $this->_url         = $this->get_link_api('getCustomFields').'?templateCode='.$_data['templateCode'].'&taxCode='.$this->get_taxCode();
            $username	= $this->_account['username'];
            $password	= $this->_account['password'];
            $this->_context = stream_context_create(array(
                'http' => array(
                    'method' => "GET",
                    'header'  => "Authorization: Basic " . base64_encode("$username:$password")
                )
            ));
            return $this->send();
        }

        // cập nhật trạng thái thanh toán
        function update_Payment_Status($_data = [
            'supplierTaxCode'   => '',
            'invoiceNo'         => '',
            'buyerEmailAddress' => '',
            'strIssueDate'      => '',
            'paymentType'       => '',
            'paymentTypeName'   => '',
            'cusGetInvoiceRight'=> '',
            'templateCode'      => ''
        ]){
            $this->_url       = $this->get_link_api('updatePaymentStatus');
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;            

            return $this->create_context_send_urlencode()->send();
        }

        // hủy trạng thái thanh toán
        function cancel_Payment_Status($_data = [
            'supplierTaxCode'   => '',
            'invoiceNo'         => '',
            'strIssueDate'      => ''
        ]){
            $this->_url       = $this->get_link_api('cancelPaymentStatus');
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;

            return $this->create_context_send_urlencode()->send();
        }

        // cập nhật kê khai thuế
        function update_Tax_Declaration($_data = [
            'supplierTaxCode'   => '',
            'strIssueDate'      => ''
        ]){
            $this->_data_send = !empty($_data) ? $_data : $this->_data_send;
            $this->_url         = $this->get_link_api('updateTaxDeclaration');

            $username	= $this->_account['username'];
            $password	= $this->_account['password'];

            $_str_json  = $this->get_data_send_json();

            $this->_context = stream_context_create(array(
                'http' => array(
                'method'    => "POST",
                'header'    =>
                    "Authorization: Basic " . base64_encode("$username:$password"). "\r\n" .
                    "Content-type: application/json\r\n",
                'content' => $_str_json
                )
            ));            

            return $this->send();
        }        

        // dung rieng cho ham lay file
        // download file
        function download_file($_filename = ''){
            $_result = $this->result_array();

            $file_name      = $_result['fileName'].'.'.$this->_file_type; //Lấy tên file + Đuôi mở rộng.
            $file_to_bytes  = $_result['fileToBytes'];  //Lấy chuỗi nhị phân của file.
            $binary = base64_decode($file_to_bytes);  //Decode chuỗi ở dạng base64.
            if (!file_exists($file_name)){
                file_put_contents($file_name, $binary); //Viết một chuỗi vào tập tin
            }
            
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'. basename($file_name) . '";');
            header('Content-Type: application/zip');
            readfile($file_name);
            unlink($file_name);

            return true;
        }        

        function get_link_api($_name = ''){ include_once 'api_link.php'; return isset($api_link[$_name]) ? $_base_link.$api_link[$_name] : '';}

        // create context to upload vt
        function create_context($_acc_vt = [], $_data = []){
            $_acc_vt    = !empty($_acc_vt) ? $_acc_vt : $this->_account;
            $_data      = !empty($_data) ? $_data : $this->_data_send;

            $username	= $_acc_vt['username'];
            $password	= $_acc_vt['password'];

            $_str_json  = json_encode($_data);

            $this->_context = stream_context_create(array(
                'http' => array(
                'method' => "POST",
                    'header'  => 
                        "Authorization: Basic " . base64_encode("$username:$password"). "\r\n" .
                        "Content-type: application/json\r\n" .
                        "Accept: application/json\r\n".
                        'Content-Length: ' . strlen($_str_json) . "\r\n",
                    'content' => $_str_json
                )
            ));            

            return $this;
        }

        function create_context_send_json($_acc_vt = [], $_data = []){
            $this->_account     = !empty($_acc_vt) ? $_acc_vt : $this->_account;
            $this->_data_send   = !empty($_data) ? $_data : $this->_data_send;

            $username	= $this->_account['username'];
            $password	= $this->_account['password'];

            $_str_json  = $this->get_data_send_json();

            $this->_context = stream_context_create(array(
                'http' => array(
                'method' => "POST",
                    'header'  =>
                        "Authorization: Basic " . base64_encode("$username:$password"). "\r\n" .
                        "Content-type: application/json\r\n" .
                        "Accept: application/json\r\n".
                        'Content-Length: ' . strlen($_str_json) . "\r\n",
                    'content' => $_str_json
                )
            ));            

            return $this;
        }

        function create_context_send_urlencode($_acc_vt = [], $_data = []){
            $this->_account     = !empty($_acc_vt) ? $_acc_vt : $this->_account;
            $this->_data_send   = !empty($_data) ? $_data : $this->_data_send;

            $username	= $this->_account['username'];
            $password	= $this->_account['password'];

            $_data_send    = $this->get_data_send_urlencode();

            $this->_context = stream_context_create(array(
                'http' => array(
                    'method' => "POST",
                    'header'  => "Authorization: Basic " . base64_encode("$username:$password"). "\r\n" .
                            "Content-type: application/x-www-form-urlencoded\r\n".
                            "Accept: application/json\r\n",
                    'content' => $_data_send
                )
            ));

            return $this;
        }

        function get_data_send_json(){return json_encode($this->_data_send); }

        function get_data_send_urlencode(){ return http_build_query($this->_data_send);}

        function get_data_json($_data = []){ return is_array($this->_data_send) ? json_encode($this->_data_send, true) : $this->_data_send;}

        function get_context(){ return $this->_context;}

        function send($_url = '', $_data = [], $_context = ''){
            $_context       = !empty($_context) ? $_context : $this->_context;
            $_url           = !empty($_url) ? $_url : $this->_url;
            $this->_result  = file_get_contents($_url, false, $_context);
            return $this;
        }

        function set_buyerInfo($_infor = []){
            if(!isset($this->_data_send['buyerInfo'])) $this->_data_send['buyerInfo'] = [];

            foreach ($this->buyerInfo as $key => $value) {                
                if(isset($_infor[$key])){
                    $this->_data_send['buyerInfo'][$key] = $_infor[$key];
                }
            }

            return $this;
        }

        function set_generalInvoiceInfo($_infor = []){
            if(!isset($this->_data_send['generalInvoiceInfo'])) $this->_data_send['generalInvoiceInfo'] = [];

            foreach ($this->generalInvoiceInfo as $key => $value) {                
                if(isset($_infor[$key])){
                    $this->_data_send['generalInvoiceInfo'][$key] = $_infor[$key];
                }
            }

            return $this;
        }

        function set_summarizeInfo($_infor = []){
            if(!isset($this->_data_send['summarizeInfo'])) $this->_data_send['summarizeInfo'] = [];

            foreach ($this->summarizeInfo as $key => $value) {                
                if(isset($_infor[$key])){
                    $this->_data_send['summarizeInfo'][$key] = $_infor[$key];
                }
            }

            return $this;
        }

        function set_sellerInfo($_infor = []){
            foreach ($_infor as $key => $value) {$this->sellerInfo[$key]  =    $value;}

            if(!isset($this->_data_send['sellerInfo'])) $this->_data_send['sellerInfo'] = [];
            
            foreach ($this->sellerInfo as $key => $value) {                
                if(isset($_infor[$key])){
                    $this->_data_send['sellerInfo'][$key] = $_infor[$key];
                }
            }

            return $this;
        }

        function add_itemInfo($_infor = []){
            //foreach ($_infor as $key => $value) {$this->itemInfo[$key]  =    $value;}

            if(!isset($this->_data_send['itemInfo'])) $this->_data_send['itemInfo'] = [];
            $_temp = [];
            foreach ($this->itemInfo as $key => $value) {
                if(isset($_infor[$key])){
                    $_temp[$key] = $_infor[$key];
                }
            }
            $this->_data_send['itemInfo'][] = $_temp;            

            return $this;
        }

        function add_taxBreakdowns($_infor){
            foreach ($_infor as $key => $value) {$this->taxBreakdowns[$key]  =    $value;}

            if(!isset($this->_data_send['taxBreakdowns'])) $this->_data_send['taxBreakdowns'] = [];
            $_temp = [];
            foreach ($this->taxBreakdowns as $key => $value) {                
                if(isset($_infor[$key])){
                    $_temp[$key] = $_infor[$key];
                }
            }
            $this->_data_send['taxBreakdowns'][] = $_temp;

            return $this;
        }

        function calculate_summarizeInfo($_infor = []){
            if(!isset($this->_data_send['summarizeInfo'])){$this->_data_send['summarizeInfo'] = [];}

            if(!isset($this->_data_send['itemInfo']) && !isset($_infor['itemInfo'])) return $this;
            
            $_items_infor = isset($_infor['itemInfo']) ? $_infor['itemInfo'] : $this->_data_send['itemInfo'];   
            
            //print_r($this->_data_send['itemInfo']);die();

            $sumOfTotalLineAmountWithoutTax = 0;
            $totalAmountWithoutTax          = 0;
            $totalTaxAmount                 = 0;
            $totalAmountWithTax             = 0;
            $discountAmount                 = 0;

            // 'totalAmountWithoutTax'             =>'',
            // 'totalTaxAmount'                    =>'',
            // 'totalAmountWithTax'                =>'',
            // 'discountAmount'                    =>'',
            // 'settlementDiscountAmount'          =>'',
            // 'taxPercentage'                     =>''

            foreach ($_items_infor as $key => $value) {
                $sumOfTotalLineAmountWithoutTax += $value['itemTotalAmountWithoutTax'];
                $totalAmountWithoutTax          += $value['itemTotalAmountWithoutTax'];
                $totalTaxAmount                 += $value['taxAmount'];
                $totalAmountWithTax             += $value['itemTotalAmountWithTax'];
                $discountAmount                 += $value['itemDiscount'];
                
            }
            
            return $this->set_summarizeInfo([
                'sumOfTotalLineAmountWithoutTax'        => $sumOfTotalLineAmountWithoutTax,
                'totalAmountWithoutTax'                 => $totalAmountWithoutTax,
                'totalTaxAmount'                        => $totalTaxAmount,
                'totalAmountWithTax'                    => $totalAmountWithTax,
                'discountAmount'                        => $discountAmount
            ]);
        }

        function add_payment($_infor = []){
            foreach ($_infor as $key => $value) {$this->payment[$key]  =    $value;}

            if(!isset($this->_data_send['payments'])) $this->_data_send['payments'] = [];
            $_temp = [];
            foreach ($this->payment as $key => $value) {                
                if(isset($_infor[$key])){
                    $_temp[$key] = $_infor[$key];
                }
            }
            $this->_data_send['payments'][] = $_temp;

            return $this;
        }

        function result(){ return $this->_result;}

        function result_array(){ if(is_string($this->_result)) return json_decode($this->_result, true); return $this->_result;}

        function result_object(){ if(is_string($this->_result)) return json_decode($this->_result); return $this->_result;}

        function set_data_send($_data){ $this->_data_send = $_data; return $this;}
    }
    
?>