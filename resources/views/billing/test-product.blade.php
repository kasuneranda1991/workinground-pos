<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title> {{ Auth::user()->shop->shop_name }} | Workinground.com | POS Billing Dashboard </title>
    <!-- Favicon-->
</head>
<body>

    <div id="productss">
        
    </div>

    <!-- Jquery Core Js -->
    <script src="billing/plugins/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#productss').empty();
                $.ajax({
                    type: "get",
                    url: '/testyear',
                    success:function(data)
                    {
                        $.each(data.products,function(index,details){
                            console.log(details.type);
                            $('#productss').append('<input id="'+details.product_id+'" class="clickclass" type="button" value="'+details.type+'" >');
                            $('#'+details.product_id).click(function(){
                                alert(details.display_name);
                            });
                        });
                    }
                });

                
        });
    </script>
</body>
</html>
