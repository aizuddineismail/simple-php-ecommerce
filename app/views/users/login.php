<?php require APPROOT . '/views/partials/header.php'; ?>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <?php flash('register_success'); ?>
        <?php flash('register_required'); ?>
        <h1 class="display-4 text-uppercase">LOGIN</h1>
        <form action="<?php echo URLROOT; ?>/users/login" method="POST">
            <div class="form-group">
                <label for="email">Email <sup>*</sup></label>
                <input type="email" name="email" value="<?php echo $data['email']; ?>"
                    class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '';?>">
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>
            
            <div class="form-group">
                <label for="password">Password <sup>*</sup></label>
                <input type="password" name="password" value="<?php echo $data['password']; ?>"
                    class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '';?>">
                    
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>

            <div class="row">
                <div class="col">
                    <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-block">Create an account</a>
                </div>
                <div class="col">
                    <input type="submit" value="Login" class="btn btn-primary btn-block">
                </div>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT .'/views/partials/footer.php'; ?>