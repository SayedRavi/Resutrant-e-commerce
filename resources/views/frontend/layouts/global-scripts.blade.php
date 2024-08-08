<script>
    function showLoader(){
        $('.overlay').addClass('active');
        $('.overlay-container').removeClass('d-none');
    }
    function hideLoader(){
        $('.overlay').removeClass('active');
        $('.overlay-container').addClass('d-none');
    }
   function loadProductCart(productId){
         $.ajax({
            method: 'GET',
            url: '{{route("load-product-modal", ":productId")}}'.replace(":productId", productId),
             beforeSend: function (){
               $('.overlay').addClass('active');
               $('.overlay-container').removeClass('d-none');
             },
            success: function (response){
                $('.load_product_modal').html(response);
                $('#cartModal').modal('show');

            },
            error: function (xhr, status, error){
                console.error(error);
            },
             complete: function (){
                $('.overlay').removeClass('active');
                 $('.overlay-container').addClass('d-none');

             }
        });

   }
   function updateSidebarCart(callback = null){
       $.ajax({
           method: 'GET',
           url: '{{route('get-cart-products')}}',
           success: function (response){
               $('.cart-content').html(response);
               let total = $('#cart-total').val();
               let cartCount = $('#cart-product-count').val();
               $('.cart-subtotal').text("{{currencyPosition(':cartTotal')}}".replace(':cartTotal', total));
               $('.cart-count').text(cartCount);
               if (callback && typeof callback == 'function'){
                   callback();
               }
           },
           error: function (xhr, status, error){

           }
       });
   }
   function removeProductFromCart(rowId){
       $.ajax({
           method: 'GET',
           url: '{{route('remove-cart-product', ":rowId")}}'. replace(":rowId", rowId),
           beforeSend: function (){
               showLoader()
           },
           success: function (response){
               if (response.status === 'success'){
                   updateSidebarCart(function (){
                       toastr.success('Product Removed Successfully');
                       hideLoader()
                   })
               }
           },
           error: function (xhr, status, error){
                let errorMessage  = xhr.responseJSON.message;
                toastr.error(errorMessage);
           }
       })
   }

   // get current cart total amount
    function getCartTotal(){
        return parseInt("{{cartTotal()}}");
    }

</script>
