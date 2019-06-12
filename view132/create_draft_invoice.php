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
        if(isset($_POST['create_draft'])){
            $_api = new api_vt();

            $_generalInvoiceInfo = [
                'invoiceType'           => '01GTKT',    // required
                'templateCode'          => '01GTKT0/001',// required
                'currencyCode'          => 'VND',       // required
                'adjustmentType'        => '1',         // required
                'paymentStatus'         => false,       // required
                //'paymentType'           => 'TM',
                //'paymentTypeName'       => 'TM',
                //'cusGetInvoiceRight'    => true,
                //'userName'              => 'user 1'
            ];
            
            $_buyerInfo = [
                'buyerName'         =>'Đặng thị thanh tâm 765781426767',    // required
                'buyerLegalName'    =>'',                                   // required
                //'buyerTaxCode'      =>'',
                //'buyerAddressLine'  =>'HN VN',
                //'buyerPhoneNumber'  =>'11111',
                //'buyerEmail'        =>'',
                //'buyerIdNo'         =>'1203456789',
                //'buyerIdType'       =>'1'
            ];
        
            $_sellerInfo = [
                //'sellerLegalName'   =>'Đặng thị thanh tâm',
                //'sellerTaxCode'     =>'0100109106-501',
                //'sellerAddressLine' =>'test',
                //'sellerPhoneNumber' =>'0123456789',
                //'sellerEmail'       =>'PerformanceTest1@viettel.com.vn',
                'sellerBankName'    =>'vtbank', // required
                'sellerBankAccount' =>'23423424'// required
            ];
        
            $_item_infor = [
                'lineNumber'                =>  1,  // required
                //'itemCode'                  =>  'ENGLISH_COURSE',
                'itemName'                  =>  'Khóa học tiếng anh',
                //'unitName'                  =>  'khóa học',
                //'unitPrice'                 =>  3500000.0,
                //'quantity'                  =>  10.0,
                'itemTotalAmountWithoutTax' =>  35000000,   // required
                //'taxPercentage'             =>  10.0,
                'taxAmount'                 =>  0.0,    // required
                //'discount'                  =>  0,
                //'itemDiscount'              =>  0,
                //'itemTotalAmountWithTax'    =>  35000000.0
            ];
        
            $_summarizeInfo = [
                'sumOfTotalLineAmountWithoutTax'    =>35000000,     // required
                'totalAmountWithoutTax'             =>35000000,     // required
                'totalTaxAmount'                    =>3500000.0,
                'totalAmountWithTax'                =>38500000,
                'discountAmount'                    =>0.0,
                //'settlementDiscountAmount'          =>0.0,
                //'taxPercentage'                     =>10.0
            ];
        
            $_taxBreakdowns = [
                'taxPercentage'     => 10.0,
                'taxableAmount'     => 35000000,
                'taxAmount'         => 3500000.0
            ];
        
            $_api->set_generalInvoiceInfo($_generalInvoiceInfo)
                ->set_buyerInfo($_buyerInfo)
                ->set_sellerInfo($_sellerInfo)
                //->add_payment(['paymentMethodName'  => 'TM'])
                ->add_itemInfo($_item_infor)                
                ->set_summarizeInfo($_summarizeInfo)
                ->create_Or_Update_Invoice_Draft();
        
            $_result = $_api->result_array();

            print_r($_result);
        }
        ?>
        <center>
            <h1>Test api tạo hóa đơn nháp viettel</h1>
        </center>
        <div class="row">
            <div class="col">
                <?php if(isset($_result) && empty($_result['errorCode'])){?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <strong>Lập hóa đơn nháp thành công</strong> 
                    </div>
                    
                    <script>
                      $(".alert").alert();
                    </script>
                <?php }?>
            </div>
        </div>
        <div class="row py-3">
            <div class="col">
                <form action="" method="post">
                    <center><button type="submit" class="btn btn-primary" name="create_draft">Lưu nháp</button></center>
                </form>
            </div>
        </div>        
    </div>
</body>
<?php include_once 'include/footer_link.php'?>

</html>