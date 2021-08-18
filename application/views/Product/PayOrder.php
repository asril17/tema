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
                    <h3 class="title">Pay your order</h3>
                    <form action="<?= base_url('Product/updatePayOrder') ?>" method="POST">
                        <input type="hidden" name="id_transaction" value="<?= $data['id_transaction'] ?>">
                        <input type="text" class="form-control" placeholder="Order no" name="order_no" value="<?= $data['order_no'] ?>">
                        <div class="button">
                            <button type="submit" class="btn btn-block btn-md btn-primary">Pay now</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="product-footer"> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>