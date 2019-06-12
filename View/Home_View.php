<?php //print_r($invoiceinfor);?>
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Số hóa đơn</th>
            <th>Tên người mua</th>
            <th>Tên người bán</th>
            <th>Trạng thái thanh toán</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($invoiceinfor as $key => $value) {?>
        <tr>
            <td><?=$key + 1;?></td>
            <td><?=$value['invoiceinfo_invoiceno']?></td>
            <td><?=$value['buyerinfo_buyername']?></td>
            <td><?=$value['sellerinfo_sellerlegalname']?></td>
            <td><?=($value['invoiceinfo_paymentstatus'] ? "Đã thanh toán" : 'Chưa thanh toán')?></td>
            <td><?=$value['invoiceinfo_cancel'] ? "Đã hủy" : ($value['invoiceinfo_released'] ? "Đã phát hành" : 'Chưa phát hành')?></td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu">
                        <?php if(!$value['invoiceinfo_released']){?>
                            <a class="dropdown-item" href="create_invoice?id_invoice=<?=$value['invoiceinfo_id']?>">Phát hành hóa đơn</a>
                        <?php }?>
                        <?php if($value['invoiceinfo_released']){?>
                            <?php if(!$value['invoiceinfo_cancel']){?>
                                <a class="dropdown-item" href="cancel_invoice?id_invoice=<?=$value['invoiceinfo_id']?>">Hủy hóa đơn</a>
                            <?php }?>
                            <a class="dropdown-item" href="get_file_invoice?id_invoice=<?=$value['invoiceinfo_id']?>&type=view">Xem file hóa đơn</a>
                            <a class="dropdown-item" href="get_file_invoice?id_invoice=<?=$value['invoiceinfo_id']?>&type=donwload">Tải file hóa đơn</a>
                            <?php if(!$value['invoiceinfo_paymentstatus']){?>
                                <a class="dropdown-item" href="update_payment_status?id_invoice=<?=$value['invoiceinfo_id']?>">Cập nhật trạng thái thanh toán</a>
                            <?php }?>
                            <?php if($value['invoiceinfo_paymentstatus']){?>
                                <a class="dropdown-item" href="cancel_payment_status?id_invoice=<?=$value['invoiceinfo_id']?>">Hủy trạng thái thanh toán</a>
                            <?php }?>
                        <?php }?>
                    </div>
                </div>
            </td>
        </tr>
        <?php }?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
        </tr>
    </tfoot>
</table>