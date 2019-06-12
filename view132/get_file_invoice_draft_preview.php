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
                'buyerName'         =>'Đặng thị thanh tâm 765781426767',
                'buyerLegalName'    =>'',
                'buyerTaxCode'      =>'',
                'buyerAddressLine'  =>'HN VN',
                'buyerPhoneNumber'  =>'11111',
                'buyerEmail'        =>'',
                'buyerIdNo'         =>'123456789',
                'buyerIdType'       =>'1'
            ];
        
            $_sellerInfo = [
                'sellerLegalName'   =>'Đặng thị thanh tâm',
                'sellerTaxCode'     =>'0100109106-501',
                'sellerAddressLine' =>'test',
                'sellerPhoneNumber' =>'0123456789',
                'sellerEmail'       =>'PerformanceTest1@viettel.com.vn',
                'sellerBankName'    =>'vtbank',
                'sellerBankAccount' =>'23423424'
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
                'sumOfTotalLineAmountWithoutTax'    =>35000000,
                'totalAmountWithoutTax'             =>35000000,
                'totalTaxAmount'                    =>3500000.0,
                'totalAmountWithTax'                =>38500000,
                'discountAmount'                    =>0.0,
                'settlementDiscountAmount'          =>0.0,
                'taxPercentage'                     =>10.0
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
                ->set_summarizeInfo($_summarizeInfo)
                ->create_Invoice_Draft_Preview();
        
            $_result = $_api->download_file();
        }
        ?>
        <center>
            <h1>Test api tạo hóa đơn nháp viettel</h1>
        </center>
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