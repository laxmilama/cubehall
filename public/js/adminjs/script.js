$(document).on('click','.productDelete',function(){
   
    var bagid=$(this).data('bagid');
    var result=confirm("Confirm Delete");
    if(result){
   $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
},
       type:'post',
       url:'delete-bag-product',
       data:{"bagid":bagid},
       success:function(resp){
           console.log("success");
           
           $("#AppendBagItem").html(resp.view);
       },error:function(){
           console.log("Error");
       }
   });
}
});

//product attribute add and remove
var maxField = 10; //Input fields increment limitation
var addButton = $('.add_button'); //Add button selector
var wrapper = $('.field_wrapper'); //Input field wrapper
var fieldHTML = '<div><input id="color" name="color[]" type="color"  placeholder="Color" style="width:120px;"/><input type="file"  name="image[]" class="form-control TheFiles" accept="image/*" ><input multiple="" type="file"  name="dimage[]" class="dfiles" accept="image/*" ><input type="text" name="size[]" value=""placeholder="size" style="width:120px;"/><input type="text" name="price[]" value="" placeholder="price" style="width:120px;"/><input type="text" name="material[]" value="" placeholder="material" style="width:120px;"/><input type="text" name="stock[]" value="" placeholder="stock" style="width:120px;"/><a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
var x = 1; //Initial field counter is 1

//Once add button is clicked
$(addButton).click(function(){
    //Check maximum number of input fields
    if(x < maxField){ 
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html
        
    }
});

//Once remove button is clicked
$(wrapper).on('click', '.remove_button', function(e){
    e.preventDefault();
    $(this).parent('div').remove(); //Remove field html
    x--; //Decrement field counter
});

