//append category level
$('#section_id').change(function(){
    var section_id=$(this).val();
    // alert(section_id);
    $.ajax({
      type:'post',
      url:'/admin/append-categories-level',
      data:{section_id:section_id,"_token": $('#token').val()},
      success:function(resp){
        $("#category_level").html(resp);
      },error:function(){
        alert("Error");
      }
    });
  });