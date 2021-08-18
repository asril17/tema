<div class="box">
    <div class="content-auth">
        <?= $this->session->flashdata('message'); ?>
        <h3>Login</h3>
        <form action="<?= base_url('Auth') ?>" method="POST" id="form-login">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>
            <div class="form-group">

                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <button type="submit" class="btn btn-block btn-md btn-primary">Login</button>
            <a href="<?= base_url('Auth/register') ?>" class="box-link">Register</a>
        </form>
    </div>
</div>