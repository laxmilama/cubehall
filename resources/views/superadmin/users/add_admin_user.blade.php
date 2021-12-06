@extends('layouts.superAdminLayout.superadmin_design')
 @section('content')
 <div class="main__container">
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
         <h1>Add Admin</h1>
</div>
<div class="row">
    <div class="col-md-12">
<form id="items" name="items" action="{{url('admin/add-admins')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="box">   
    <div>
    <label for="name"><b>Admin Name</b></label>
    <input type="text" placeholder="Enter name" name="name" id="name">
    </div>
    <div>
    <label for="email"><b>Admin email</b></label>
    <input type="text" placeholder="Enter email" name="email" id="email">
    </div>
   
    <div>
    
        <label >Password</label>
        <input type="password" id="password" name="password" placeholder="Enter Password">
     </div>
     <div >
         <label for="password_confirm">Confirm Password</label>
         <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirm Password" >
     </div>
    <div>
    <label for="role">Select Role</label>
    <select  name="role" id="role">
            <option value="">Select Role...</option>
            @foreach ($roles as $role)
            <option data-role-id="{{$role->id}}" data-role-slug="{{$role->slug}}" value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
        </select>
    </div>
    <div id="permissions_box" >
        <label for="roles">Select Permissions</label>
        <div id="permissions_ckeckbox_list">
        </div>
    </div>

    

    <button type="submit" class="additembtn">Add</button>
  </div>
  

</form>
</div>
</div>
</div>
<script>
        $(document).ready(function(){
            var permissions_box = $('#permissions_box');
            var permissions_ckeckbox_list = $('#permissions_ckeckbox_list');
            permissions_box.hide(); // hide all boxes
            $('#role').on('change', function() {
                var role = $(this).find(':selected');    
                var role_id = role.data('role-id');
                var role_slug = role.data('role-slug');
                permissions_ckeckbox_list.empty();
                $.ajax({
                    url: "/admin/add-admins",
                    method: 'get',
                    dataType: 'json',
                    data: {
                        role_id: role_id,
                        role_slug: role_slug,
                    }
                }).done(function(data) {
                    
                    console.log(data);
                    
                    permissions_box.show();                        
                    // permissions_ckeckbox_list.empty();
                    $.each(data, function(index, element){
                        $(permissions_ckeckbox_list).append(       
                           '<div class="box" >'+                         
                                '<input type="checkbox" name="permissions[]" id="'+ element.slug +'" value="'+ element.id +'">' +
                                '<label  for="'+ element.slug +'">'+ element.name +'</label>'+
                            '</div>'
                        );
                    });
                });
            });
        });
    </script>
 @endsection