@extends('layouts.adminLayout.admin_design')
 @section('content')
 <div class=admin_content_wrapper>
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
     <div> 
         <h1>Add Items</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <form id="items" name="items" action="{{url('page/add-order')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
         
               

                
               
               
                
                <div class="field_wrapper" >
                    <input id="color" name="color[]" type="color"  placeholder="Color" style="width:120px;"/>
                    <input type="file"  name="image[]" id="image" accept="image/*" value="">
                    <input multiple="" type="file"  name="dimage[]" id="dimage" accept="image/*" value="" >
                    <input id="size" name="size[]" type="text" value="" placeholder="Size" style="width:120px;"/>
                    <input id="price" name="price[]" type="text" value="" placeholder="Price" style="width:120px;"/>
                    <input id="material" name="material[]" type="text" value="" placeholder="material" style="width:120px;"/>
                
                    <input id="stock" name="stock[]" type="text" value="" placeholder="Stock" style="width:120px;"/>
                    <a href="javascript:void(0);"  class="add_button" title="Add Field">Add</a>

                </div>
            <button type="submit" class="additembtn">Add</button>
        </div>
  

    </form>
</div>
</div>
</div>

<script>
         $(document).ready(function(){
          
            $('#items').on('submit',function(e){
              e.preventDefault();
             $.ajaxSetup({
               headers:{
                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
               }
               });
              var result = ntc.name("color");


            var colorname = "result[1]";
            var obj=$("#color").val();
           var aa=result[1];
           var str=aa;
           
            console.log(str);
               $.ajax({
                type:'post',
                  url:'/page/add-order',
                  data: {str:str},
                
                  success: function(resp){
                    console.log("success");
                  console.log("returned : " + typeof(resp));
                  },error:function(){
                    console.log('Error');
                }
                  });
              });
            });
      </script>
 @endsection