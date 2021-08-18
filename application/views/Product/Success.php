<div class="row justify-content-center">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="box">
            <div class="content-product">
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
                    <h3 class="title">Success!</h3>
                    <div class="form-group row">
                        <h6 for="staticEmail" class="col">Order no</h6>
                        <div class="col-sm">
                            <h6 for="staticEmail" class="col text-right"><?= $detail['order_no'] ?></h6>
                        </div>
                    </div>
                    <div class="form-group row">
                        <h6 for="staticEmail" class="col">Total</h6>
                        <div class="col-sm">
                            <h6 for="staticEmail" class="col text-right"><?= format_rp($detail['total']) ?></h6>
                        </div>
                    </div>
                    <br>
                    <?php if ($detail['transaction_type'] == 'Prepaid Balance') : ?>
                        <p>Your mobile phone number <?= $detail['mobile_number'] ?> will receive <?= format_rp($detail['value']) ?></p>

                    <?php else : ?>

                        <p><?= $detail['product'] ?> that cost <?= format_rp($detail['price']) ?> will be shipped to:</p>
                        <p><?= $detail['shipping_address'] ?></p>
                        <p>only after you pay</p>
                    <?php endif; ?>
                    <div class="button">
                        <a href="<?= base_url('Product/payOrder/') . $detail['id_transaction'] ?>" class="btn btn-block btn-md btn-primary">Pay now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>