<?php use App\Models\Bag;?>
<?php use App\Models\ProductList;?>
<?php use App\Models\ProductMeta;?>
@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')

<div class="row">

  <div class="col-md-6">
    <div class="container">
    <fieldset v-if="step == 1">
      <form action="{{url('/checkout')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
  
            <div class="row">
        
            <h3>Delivery Address</h3>
           
            <label for="country">Country</label>
            <input type="text" @if(!empty($deliveryDetails['country']))
                                 value="{{$deliveryDetails['country']}}" @endif id="country" name="country" v-model="country" placeholder="Country">
            <label for="fname">Full Name</label>
            <input type="text" @if(!empty($deliveryDetails['name']))
                                 value="{{$deliveryDetails['name']}}" @endif id="name" name="name" v-model="name" placeholder="Name">
            <label for="adr">Address</label>
            <input type="text" @if(!empty($deliveryDetails['address']))
                                 value="{{$deliveryDetails['address']}}" @endif id="address" name="address" v-model="address" placeholder="Address">
            <label for="landmark">Nearest Landmark</label>
            <input type="text" @if(!empty($deliveryDetails['landmark']))
                                 value="{{$deliveryDetails['landmark']}}" @endif id="landmark" name="landmark"v-model="landmark" placeholder="landmark">
            <label for="province"> state/province</label>
            <input type="text" @if(!empty($deliveryDetails['province']))
                                 value="{{$deliveryDetails['province']}}" @endif id="province" name="province" v-model="province" placeholder="Province">
            <label for="city"> City</label>
            <input type="text" @if(!empty($deliveryDetails['city']))
                                 value="{{$deliveryDetails['city']}}" @endif id="city" name="city" v-model="city" placeholder="City">
         </div>
         <button @click.prevent="next()" class="btn btn-primary">Save</button>
      </form>
      </fieldset>
      <?php $totalPrice=0;
          
     ?>
          
      @foreach($userBagItems as $bag)
      <?php 
       $name=ProductMeta::where('id',$bag['productmeta_id'])->first();
    //    dd($name);
    
       $productPrice=Bag::getProductMetaPrice($bag['productmeta_id']);
        //dd($productPrice);
  
	?> 
      <?php 
                $totalPrice=$totalPrice + ($productPrice*$bag['quantity']);
            // dd($totalPrice);
           
                ?>
      @endforeach
      <fieldset v-if="step == 2">
        <button id="payment-button" class="khalti btn btn-primary" name="khalti">Pay with Khalti</button>
        <input type="hidden" value="{{$totalPrice}}" name="totalPrice">
     </fieldset>
 

    </div>
  </div>
  
</div>
<div id="app">
    <checkout :userid="{{Auth::user()->id}}" :items="{{$userBagItems}}"/>
</div>

<script>
 var config = {
            // replace the publicKey with yours
            "publicKey": "test_public_key_b4e6e360329b4c1685dcee51f8aa83ff",
            "productIdentity": "1234567890",
            "productName": "Dragon",
            "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
            "eventHandler": {
                onSuccess (payload) {
                    // console.log(payload); //response from khalti to client
                    
                    // hit merchant api for initiating verfication
                    // var am=payload.amount/100;
                    // console.log(am);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:"{{url('/payment/verification')}}",
                        type: 'POST',
                        data:{
                            amount : payload.amount,
                            trans_token : payload.token,
                            
                            
                        },
                        success: function(res)
                        {
                            console.log("transaction succedd"); // you can return to success page
                            window.location.href = "/thanks";
                        },
                        error: function(error)
                        {
                            console.log("transaction failed");
                        }
                    })
                },
                onError (error) {
                    console.log(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);
        var btn = document.getElementById("payment-button");
        btn.onclick = function () {
            checkout.show({
                    amount: {{$totalPrice*10}}
                    });
        }
</script>
<script >
   var app = new Vue({
     el: '#app',
     data: {
           step:1,
           city:'',
           country:'',
           name:'',
           address:'',
           landmark:'',
           province:'',
       },
   methods:{
       prev() {
           this.step--;
       },
       next() {
           this.step++;
       },  
       submit() {
           alert('Form Is Submitted.');      
       }   
   }  
    })
</script>
@endsection