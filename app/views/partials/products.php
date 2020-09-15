<!-- <div class="row justify-content-end">
    <a class="btn btn-muted"><i class="fa fa-list fa-lg text-muted"></i></a>
    <a class="btn btn-muted"><i class="fa fa-th-large fa-lg text-muted"></i></a>
</div> -->

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

<!-- products -->
<div class="row">
    <?php foreach ($data['products']['body'] as $item): ?>
    <div class="col-md-6 col-lg-3 my-1">
        <div class="card h-100 align-items-stretch">
            <img src="<?php echo $item['images'][0]['src_medium'] != '' ? str_replace('\\', '', $item['images'][0]['src_medium']) : 'https://via.placeholder.com/250x250.png?text=No+Image'; ?>"
                class="card-img-top align-self-center" style="width:250px; height:250px;">
            <div class="card-body align-self-center">
                <h5 class="card-title"><?php echo $item['name']; ?></h5>
            </div>
            <div class="card-footer">
                <div class="row">
                    <button class="cartButton col btn btn-primary" value="<?php echo $item['id'];?>" name="<?php echo $item['name']; ?>">Add to cart</button>
                    <input type="button" class="col btn btn-warning" value="Buy">
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<!-- end of products -->

<!-- pagination -->
<?php if($data['products']['currentPage'] <= $data['products']['totalPages']): ?>
    <div class="row justify-content-end">
        <nav aria-label="Products page navigation">
            <ul class="pagination">

                <?php if($data['products']['currentPage'] > 1) : ?>
                    <li class="page-item">
                        <a class="page-link"
                            href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage'] - 1); ?>">Previous</a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <?php endif; ?>

                <?php if($data['products']['currentPage'] - 2 > 0) : ?>
                <li class="page-item"><a class="page-link"
                        href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage'] - 2); ?>"><?php echo $data['products']['currentPage'] - 2; ?></a>
                </li>
                <?php endif; ?>

                <?php if($data['products']['currentPage'] - 1 > 0) : ?>
                <li class="page-item"><a class="page-link"
                        href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage'] - 1); ?>"><?php echo $data['products']['currentPage'] - 1; ?></a>
                </li>
                <?php endif; ?>

                <li class="page-item active"><a class="page-link"
                        href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage']); ?>"><?php echo $data['products']['currentPage']; ?></a>
                </li>

                <?php if($data['products']['currentPage'] + 1 <= $data['products']['totalPages']): ?>
                <li class="page-item"><a class="page-link"
                        href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage'] + 1); ?>"><?php echo $data['products']['currentPage'] + 1; ?></a>
                </li>
                <?php endif; ?>

                <?php if($data['products']['currentPage'] + 2 <= $data['products']['totalPages']): ?>
                <li class="page-item"><a class="page-link"
                        href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage'] + 2); ?>"><?php echo $data['products']['currentPage'] + 2; ?></a>
                </li>
                <?php endif; ?>

                <?php if($data['products']['currentPage'] < $data['products']['totalPages']) : ?>
                <li class="page-item"><a class="page-link"
                        href="<?php echo URLROOT.'/products/pages/'. ($data['products']['currentPage'] + 1); ?>">Next</a>
                </li>
                <?php else: ?>
                <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>
<!-- end of pagination -->

<!-- jquery scripts -->
<script>
    var urlroot = '<?php echo URLROOT; ?>'

    $(document).ready(function() {

        $(".cartButton").click(function() {
            let item = $(this).attr('name')
            $.ajax({
                type: 'POST',
                url: `${urlroot}/carts`, 
                data: {"productId": $(this).val()},
                success: function(msg) {
                    // alert(msg);
                    if(msg == 'passed') {
                        $('div.modal-body').text(`${item} is added to the cart`)
                        $('#cart-modal').modal('toggle');
                        // alert('Successfully added to cart');
                    } else {
                        $('div.modal-body').text('Please login to continue');
                        $('#cart-modal').modal('toggle');
                        // alert('Failed to add to cart');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert('ERROR');
                }
            })
            //     $.post(, function(data) {
            //         console.log(data);
            //         $('#cart-modal').modal('toggle');
            // })
            })

    })
</script>
<!-- jquery scripts -->