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
            $_api = new api_vt();
            $_api->get_Provides_Status_Using_Invoice([
                'supplierTaxCode'       =>'0201906443',
                'templateCode'          =>'01GTKT0/001',
                'serial'                => 'NS/19E'
            ]);

            $result = $_api->result_array();            
            print_r($result);
        ?>
        <center>
            <h1>Test api lấy thông tin hóa đơn viettel</h1>
        </center>
        <div class="row py-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="">Mã số thuế doanh nghiệp</label>
                    <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId"
                        value="0201906443" required>
                    <small id="helpId" class="text-muted">Điền mã số thuế</small>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="">Từ ngày</label>
                    <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?=date('Y-m-d')?>" required>
                    <small id="helpId" class="text-muted">Điền mã số thuế</small>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="">Đến ngày</label>
                    <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId"
                        value="<?=date('Y-m-d')?>" required>
                    <small id="helpId" class="text-muted">Điền mã số thuế</small>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="">Mã số thuế doanh nghiệp</label>
                    <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId"
                        value="0201906443" required>
                    <small id="helpId" class="text-muted">Điền mã số thuế</small>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include_once 'include/footer_link.php'?>
</html>