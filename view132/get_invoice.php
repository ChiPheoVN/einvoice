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
            $_api->get_Invoice([
                'rowPerPage'        => 20,
                'startDate'         => '2019-01-12',
                'endDate'           => date('Y-m-d')
            ]);

            $result = $_api->result_array();            
            $_invoices = $result['invoices'];            
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
        <div class="row py-3">
            <div class="col">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Số hóa đơn</th>
                            <th>Số tiền</th>
                            <th>Người mua</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_invoices as $key => $value) {?>
                        <tr>
                            <td><?=$key + 1;?></td>
                            <td><?=$value['invoiceNo']?></td>
                            <td><?=$value['total']?></td>
                            <td><?=$value['buyerName']?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<?php include_once 'include/footer_link.php'?>
</html>