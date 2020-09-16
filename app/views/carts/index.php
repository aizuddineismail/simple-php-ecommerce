<?php require APPROOT .'/views/partials/header.php'; ?>
<h1 class="display-4 text-uppercase">My cart</h1>

<?php flash('order_placed'); ?>
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

<div class="row col-xs-12 col-sm-12 col-lg-8"">
    <?php if(count($data['products']) > 0): ?>
        <?php foreach ($data['products'] as $item): ?>
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
                            <p class="card-text">Price: RM 24.20</p>
                            <nav aria-label="Quantity counter">
                                <ul class="pagination">
                                    <div class="mr-3">Quantity: </div>
                                    <!-- <li class="page-item <?php echo $item['quantity'] == 1 ? 'disabled' : '' ?>"> -->
                                    <li class="page-item">
                                        <a class="minusQuantity page-link" value="<?php echo $item['product_id']; ?>" style="cursor: pointer;">-</a>
                                    </li>
                                    <li class="page-item disabled">
                                        <a id="<?php echo $item['product_id']; ?>" class="quantity page-link"></a>
                                    </li>
                                    <li class="page-item"><a class="addQuantity page-link" value="<?php echo $item['product_id']; ?>" style="cursor: pointer;">+</a></li>
                                </ul>
                            </nav>
                            <button class="removeProduct btn btn-danger" value="<?php echo $item['product_id']; ?>"><i class="fa fa-trash fa-lg"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="ml-auto my-3">
            <div class="">
                <form id="proceedForm" class="form-inline" action="<?php echo URLROOT; ?>/orders" method="POST">
                    <button type="button" id="saveButton" class="btn btn-primary">Save</button>
                    <button type="button" id="proceedButton" class="btn btn-success">Proceed checkout</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="">NO ITEM</div>
    <?php endif; ?>
    
</div>

<!-- jquery scripts -->
<script>
    var urlroot = '<?php echo URLROOT; ?>'
    var products = <?php echo json_encode($data['products']); ?>

    $(document).ready(function() {
        // Set quantity
        $('.quantity').each(function(index) {
            $(this).text(products[index]['quantity']);
        })
        
        function save(callback) {
            items = [];
            
            $('.quantity').each(function(index) {
                items.push({
                    'productId': $(this).attr('id'),
                    'quantity': $(this).text()
                })
            })

            $.ajax({
                url: `${urlroot}/carts/save`,
                data: JSON.stringify(items),
                type: 'PUT',
                success: function(msg) {
                        $('div.modal-body').text(msg);
                        callback()
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Failed to save');
                    console.log(errorThrown);
                }
            })
        }

        function proceed() {
            $.ajax({
                url: `${urlroot}/orders`,
                type: 'POST',
                success: function(msg) {
                    $('#proceedForm').submit();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('Failed to save');
                    console.log(errorThrown);
                }
            })
        }

        $('.minusQuantity').click(function() {
            let product_code = $(this).attr('value');
            let currentQuantity = $(`a[id='${product_code}']`).text()
            let newQuantity = parseInt(currentQuantity) - 1
            if (newQuantity > 0) {
                $(`a[id='${product_code}']`).text(newQuantity)
            }
            // $.ajax({
            //     url: `${urlroot}/carts/minus`,
            //     data: $(this).attr('value'),
            //     type: 'PUT',
            //     success: function(result) {
            //         location.reload()
            //     }
            // })
        })

        $('.addQuantity').click(function() {
            let product_code = $(this).attr('value');
            let currentQuantity = $(`a[id='${product_code}']`).text()
            let newQuantity = parseInt(currentQuantity) + 1
            $(`a[id='${product_code}']`).text(newQuantity)

            // $(this).text();
            // $.ajax({
            //     url: `${urlroot}/carts/add`,
            //     data: $(this).attr('value'),
            //     type: 'PUT',
            //     success: function(result) {
            //         location.reload()
            //     }
            // })
        })

        $('.removeProduct').click(function() {
            $.ajax({
                url: `${urlroot}/carts/delete`,
                data: $(this).attr('value'),
                type: 'DELETE',
                success: function(result) {
                    location.reload()
                }
            })
        })

        $('#saveButton').click(function(){
            save(function(){console.log('Saving')})
            $('#cart-modal').modal('toggle');
            });
            // function() {
            // items = [];

            // $('.quantity').each(function(index) {
            //     items.push({
            //         'productId': $(this).attr('id'),
            //         'quantity': $(this).text()
            //     })
            // })

            // $.ajax({
            //     url: `${urlroot}/carts/save`,
            //     data: JSON.stringify(items),
            //     type: 'PUT',
            //     success: function(msg) {
            //             $('div.modal-body').text(msg);
            //             $('#cart-modal').modal('toggle');
            //     },
            //     error: function(XMLHttpRequest, textStatus, errorThrown) {
            //         alert('Failed to save');
            //         console.log(errorThrown);
            //     }
            // })
        // })

        
        $('#proceedButton').click(function() {
            save(proceed);

            // $.ajax({
            //     url: `${urlroot}/orders`,
            //     type: 'POST',
            //     success: function(msg) {
            //         $('#proceedForm').submit();
            //     },
            //     error: function(XMLHttpRequest, textStatus, errorThrown) {
            //         alert('Failed to save');
            //         console.log(errorThrown);
            //     }
            // })
        })
    })
</script>
<!-- jquery scripts -->

<?php require APPROOT .'/views/partials/footer.php'; ?>