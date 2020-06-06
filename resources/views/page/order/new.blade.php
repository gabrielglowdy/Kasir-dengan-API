@extends('layouts.app-full')

@section('title', 'New Order')
@section('content')
<form action="/order/ordering" method="post">
    @csrf
    <div id="order-list">
        <input type="hidden" id="counter" name="counter" value="0">
    </div>
    <div class="row justify-content-center">
        <div class="col-7">
            <div class="row" id="res">
                @foreach($categories as $value)
                <div class="col-md-3 mx-2 my-3 bg-white bulat card-body text-center" onclick="find('{{$value->id}}', '{{$value->name}}')">
                    <h5 class="font-weight-bold mb-0">{{$value->name}}</h5>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-4">
            <div class="bg-white bulat card-body">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <h5>Checkout</h6>
                            <hr>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-2 text-center">
                        <h6>QTY</h6>
                    </div>
                    <div class="col-6">
                        <h6>NAMA PRODUK</h6>
                    </div>
                    <div class="col-4 text-center">
                        <h6>HARGA</h6>
                    </div>
                </div>
                <hr class="my-1">
                <div class="justify-content-center" id="product-list">

                </div>
                <div class="row justify-content-center" id="button"></div>
            </div>
        </div>
    </div>

    @section('js')
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/swall.js')}}"></script>
    <script defer>
        var swal;

        function find(id, category) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/api/product/list') }}",
                method: 'get',
                data: {
                    category: id,
                    // type: jQuery('#type').val(),
                    // price: jQuery('#price').val()
                },
                success: function(result) {

                    var res = JSON.parse(result);
                    var products = res.products;
                    // if (products.length > 3) {
                    // var string = '<div class="row justify-content-center">';
                    // } else {
                    var string = '<div class="row">';
                    // }
                    // console.log(products);
                    for (let i = 0; i < products.length; i++) {
                        string +=
                            '<div class="col-md-3 px-2 my-3">' +
                            '<div class="bg-abu bulat card-body text-center" onclick="choose(' + products[i].id + ')">' +
                            '<h5 class="font-weight-bold">' + products[i].name + ' ' + products[i].size + '</h5>' +
                            '<h6 class="mb-0 ">' + products[i].price + '</h6>' +
                            '</div>' +
                            '</div>';
                    }
                    string += '</div>';
                    Swal.fire({
                        title: '<strong>' + category + ' </strong>',
                        // icon: 'info',
                        width: '80vw',
                        html: string,
                        showCloseButton: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        focusConfirm: false,
                    })
                    // }
                }
            });
        }
    </script>
    <script defer>
        var counter = 0;

        function choose(id) {

            for (let index = 0; index < counter; index++) {
                var order = document.getElementById("order-" + (index + 1));

                // if (order != null) {
                if (order.value == id) {
                    Swal.fire({
                        title: '<strong> Product Already picked ! </strong>',
                        icon: 'error',
                        showCancelButton: false,
                        focusConfirm: false,
                    });
                    return;
                } else {
                    // console.log(order.value);

                }
                // }
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/api/product/get') }}",
                method: 'get',
                data: {
                    id: id,
                    // type: jQuery('#type').val(),
                    // price: jQuery('#price').val()
                },
                success: function(result) {

                    var res = JSON.parse(result);
                    console.log(res);

                    //Add to Check Out
                    var input_qty = document.createElement("INPUT");
                    var input_order = document.createElement("INPUT");
                    counter++;
                    document.getElementById("counter").value = counter;
                    input_qty.type = "text";
                    input_order.type = "hidden";

                    input_order.id = "order-" + counter;
                    input_qty.id = "input-" + counter;

                    input_order.name = "order-" + counter;
                    input_qty.name = "input-" + counter;

                    input_qty.className = 'form-control';
                    input_qty.value = 1;

                    input_order.value = res.id;

                    var div_row = document.createElement("div");
                    var div_qty = document.createElement("div");
                    var div_product = document.createElement("div");
                    var div_price = document.createElement("div");

                    div_row.className = "row my-2 align-items-center";
                    div_qty.className = "col-2 text-center align-items-center";
                    div_product.className = "col-6 align-items-center";
                    div_price.className = "col-4 text-center align-items-center";

                    var h6_product = document.createElement("H6");
                    var h6_price = document.createElement("H6");

                    h6_product.innerText = res.name + ' ' + res.size;
                    h6_price.innerText = res.price;

                    h6_product.className = "mb-0";
                    h6_price.className = "mb-0";

                    var hr = document.createElement("hr");
                    div_qty.appendChild(input_qty);
                    div_product.appendChild(h6_product);
                    div_price.appendChild(h6_price);

                    div_row.appendChild(div_qty);
                    div_row.appendChild(div_product);
                    div_row.appendChild(div_price);

                    document.getElementById("product-list").appendChild(div_row);
                    document.getElementById("order-list").appendChild(input_order);


                    if (counter == 1) {
                        var button = document.createElement("input");
                        button.type = "submit";
                        button.className = "btn btn-success w-100";

                        var div = document.createElement("div");
                        div.className = "col-12 text-center";

                        div.appendChild(button);

                        document.getElementById("button").appendChild(div);
                    }

                    swal.close();









                }
            });
        }
    </script>
    <script>

    </script>
    @endsection
</form>
@endsection
