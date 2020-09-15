<?php require APPROOT .'/views/partials/header.php'; ?>
<h1 class="display-4 text-uppercase">My Orders</h1>

<!-- modal -->
<div class="modal fade" id="cart-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adding item to cart</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
        </div>
        </div>
    </div>
</div>
<!-- end of modal -->

<div class="row col-xs-12 col-sm-12 col-lg-8 mb-5">

<?php if(count($data['orders']) > 0): ?>
        <?php foreach ($data['orders'] as $item): ?>
            <div class="card w-100">
                <div class="row no-gutters">
                    <div class="col-4">
                    <img src="<?php echo $item['images'][0]['src_small'] != '' ? str_replace('\\', '', $item['images'][0]['src_medium']) : 'https://via.placeholder.com/100x100.png?text=No+Image'; ?>" 
                        class="card-img" 
                        alt="<?php echo $item['images'][0]['alt']; ?>"
                        style="max-height:200px;"
                        />
                    </div>
                    <div class="col-8 justify-content-between" >
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['name']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Last updated: <?php echo $item['updated_at']; ?></h6>
                            <div class="card-text">
                                <div class="container">
                                    <div class="row justify-content-between">
                                        <div class="text-left">Price: RM 24.20</div>
                                        <div class="text-right">Quantity: <?php echo $item['quantity']; ?></div>

                                    </div>
                                </div>
                            </div>
                            <div class="">Status: <i><?php echo $item['order_status']; ?></i></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="">NO ITEM</div>
    <?php endif; ?>
</div>

<!-- jquery scripts -->
<script>
    var urlroot = '<?php echo URLROOT; ?>'
    var orders = <?php echo json_encode($data['orders']); ?>

    $(document).ready(function() {
        // Set quantity
        $('.progress-bar').each(function(index) {
            let order_status = orders[index]['order_status']
            console.log(order_status)
            if(order_status == 'Payment pending') {
                $(this).attr("style", "width: 25%")
                $(this).addClass("bg-warning")

            } else if(order_status == "Processing") {
                $(this).attr("style", "width: 50%")
                $(this).addClass("bg-info")
                

            } else if(order_status == "Shipped") {
                $(this).attr("style", "width: 75%")

            } else if (order_status == "Delivered") {
                $(this).attr("style", "width: 100%");
                $(this).addClass("bg-success")

            } else if (order_status == "Cancelled"){
                $(this).attr("style", "width: 100%");
                $(this).addClass("bg-danger")

            } else {
                $(this).attr("style", "width: 0%");
            }
        })
    })
</script>
<!-- jquery scripts -->

<?php require APPROOT .'/views/partials/footer.php'; ?>