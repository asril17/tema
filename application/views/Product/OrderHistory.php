<div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="box">
            <div class="order">
                <div class="product-header">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-2">
                            <div class="user">
                                <h6>Hello, <?= $this->session->userdata('nama') ?></h6>
                                <a href="<?= base_url('Product/orderHistory') ?>">
                                    <p><strong class="error"><?= $count ?></strong> Unpaid Order</p>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg col-md col-sm">
                            <ul class="nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link active" href="<?= base_url('Product/prepaidBalance') ?>">Prepaid Balance</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('Product/productPage') ?>">Product Page</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="product-body">
                    <h3 class="title">Order History</h3>
                    <form action="<?= base_url('Product') ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search by Order no." id="search">
                        </div>
                        <!-- <button class="btn btn-block btn-default" id="bb">Loading...</button> -->
                        <ul class="list-group list-group-flush" id="list">
                            <?php foreach ($transaction as $row) : ?>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col">
                                            <div class="order-total">
                                                <h6><?= $row['order_no'] ?></h6>
                                                <h6><?= format_rp($row['total']) ?></h6>
                                            </div>
                                            <?php if ($row['transaction_type'] == 'Prepaid Balance') : ?>
                                                <p><?= format_rp($row['value']) ?> for <?= $row['mobile_number'] ?></p>
                                            <?php else : ?>
                                                <p><?= $row['product'] ?> that costs <?= format_rp($row['price']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-3">
                                            <div class="list-button">
                                                <?php if ($row['transaction_type'] == 'Prepaid Balance') : ?>
                                                    <?php if ($row['status'] == 'Created') : ?>
                                                        <a href="<?= base_url('Product/payOrder/') . $row['id_transaction'] ?>" class="btn btn-sm btn-primary">Pay now</a>
                                                    <?php elseif ($row['status'] == 'Success') : ?>
                                                        <h6 class="text-success"><?= $row['status'] ?></h6>
                                                    <?php elseif ($row['status'] == 'Failed') : ?>
                                                        <h6 class="text-orange"><?= $row['status'] ?></h6>
                                                    <?php elseif ($row['status'] == 'Canceled') : ?>
                                                        <h6 class="text-danger"><?= $row['status'] ?></h6>
                                                    <?php else : ?>
                                                        <h6><?= $row['status'] ?></h6>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <?php if ($row['status'] == 'Created') : ?>
                                                        <a href="<?= base_url('Product/payOrder/') . $row['id_transaction'] ?>" class="btn btn-sm btn-primary">Pay now</a>
                                                    <?php elseif ($row['status'] == 'Success') : ?>
                                                        <h6><?= $row['shipping_code'] ?></h6>
                                                    <?php else : ?>
                                                        <h6 class="text-danger"><?= $row['status'] ?></h6>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div id="pag">
                            <?= $this->pagination->create_links(); ?>
                        </div>
                        <!-- <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav> -->
                        <!-- <hr> -->
                        <!-- <div class="button">
                            <button type="submit" class="btn btn-block btn-md btn-primary">Submit</button>
                        </div> -->
                    </form>
                </div>
                <!-- <div class="product-footer"> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>