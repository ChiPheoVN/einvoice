<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test hóa đơn điện tử</title>

    <?php include_once 'include/header_link.php'?>
    <?php include_once '../folder_kien/api_function.php'?>
    <?php include_once '../global_func/global.php'?>
</head>

<body>
    <div class="container">
        <?php
        if(!isset($_POST['create_invoice'])){            

            $_api = new api_vt();

            $_generalInvoiceInfo = [
                'invoiceType'           => '01GTKT',        // required
                'templateCode'          => '01GTKT0/001',   // required
                'currencyCode'          => 'VND',           // required
                'adjustmentType'        => '1',             // required
                'paymentStatus'         => false,           // required
                //'paymentType'           => 'TM',
                //'paymentTypeName'       => 'TM',
                //'cusGetInvoiceRight'    => true,
                //'userName'              => 'user 1'
            ];
            
            $_buyerInfo = [
                'buyerName'         =>'Đặng thị thanh tâm',    // required
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
                //'sellerBankName'    =>'vtbank', // required
                //'sellerBankAccount' =>'23423424'// required
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
                ->create_invoice();                
        
                $_result = $_api->result_array();

                print_r($_result);
        }
        ?>
        <center>
            <h1>Test api phát hành hóa đơn viettel</h1>
        </center>
        <div class="row py-3">
            <?php if(isset($_result)) foreach ($_result['result'] as $key => $value) {?>
            <div class="col-6">
                <div class="alert alert-success" role="alert">
                    <?=$key;?> : <?=$value;?>
                </div>
            </div>
            <?php }?>
        </div>
        <form action="" method="post" class="d-none">
        <div class="row py-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tên khách hàng</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="" name="buyerName">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tên đơn vị</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="" name="buyerLegalName">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin người bán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Mã số thuế</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="0201906443" name="sellerTaxCode">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin Hóa đơn</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Kiểu hóa đơn</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="01GTKT">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Mẫu hóa đơn</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="01GTKT0/001">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Đơn vị tiền tệ</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="VND">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Trạng thái điều chỉnh hóa đơn</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="1">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Trạng thái thanh toán</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin tổng hợp</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tổng thành tiền</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tổng tiền chưa thuế</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tổng tiền thuế</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tổng thành tiền sauthuế</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-md-4 col-form-label">Tổng tiền chiết khấu</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="staticEmail" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py3">
            <div class="col">
                <center>
                    <button type="submit" class="btn btn-primary">Tạo hóa đơn</button>
                </center>
            </div>
        </div>
        </form>
    </div>
</body>
<?php include_once 'include/footer_link.php'?>
</html>