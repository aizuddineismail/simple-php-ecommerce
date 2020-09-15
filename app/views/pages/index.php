<?php require APPROOT .'/views/partials/header.php'; ?>
<h1 class="display-4 text-uppercase">WELCOME <?php echo !empty($_SESSION['user_name'])? ', '. $_SESSION['user_name'] : '';?></h1>
<?php require APPROOT .'/views/partials/products.php'; ?>
<?php require APPROOT .'/views/partials/footer.php'; ?>