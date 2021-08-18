<div class="box">
    <div class="content-auth">
        <h3>Register</h3>
        <form action="<?= base_url('Auth/registerPost') ?>" method="POST" id="form-register">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Name" name="nama">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" name="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
            <button type="submit" class="btn btn-block btn-md btn-primary">Register</button>
            <a href="<?= base_url('Auth') ?>" class="box-link">Login</a>
        </form>
    </div>
</div>