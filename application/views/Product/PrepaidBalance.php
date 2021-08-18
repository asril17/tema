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
                    <h3 class="title">Prepaid Balance</h3>
                    <?= $this->session->flashdata('message'); ?>

                    <form action="<?= base_url('Product/insertPrepaidBalance') ?>" method="POST" id="form-prepaidBalance">
                        <div class="form-group">

                            <input type="text" class="form-control" placeholder="Mobile Number" name="mobileNumber" id="mobileNumber">
                        </div>
                        <div class="form-group">

                            <select class="form-control" name="value" id="value">
                                <option value="">Choose value...</option>
                                <option value="10000">10.000</option>
                                <option value="50000">50.000</option>
                                <option value="100000">100.000</option>
                            </select>
                        </div>
                        <div class="button">
                            <button type="button" class="btn btn-block btn-md btn-primary" id="sumbitPrepaid">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="product-footer"> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>