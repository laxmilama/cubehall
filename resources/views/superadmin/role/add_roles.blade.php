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
         <h1>Create New Role</h1>
</div>
<div class="row">
    <div class="col-md-12">
<form id="roles" name="roles" action="{{url('admin/add-roles')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="box">   
    <div>
            <label for="user_role"><b>Role Name</b></label>
            <input type="text" placeholder="Enter user_role" name="user_role" id="user_role">
    </div>
    <div>
            <label for="role_slug"><b>Role Slug</b></label>
            <input type="text" placeholder="Enter role_slug" name="role_slug" id="role_slug">
    </div>
    <div>
            <label for="roles_permissions"><b>Add Permission</b></label>
            <input type="text" placeholder="Enter role_permission" name="roles_permissions" id="roles_permissions">
    </div>
    <button type="submit" class="additembtn">Add</button>
  </div>
  

</form>
</div>
</div>
</div>
<script>
    $(document).ready(function(){
        $('#user_role').keyup(function(e){
            var str=$('#user_role').val();
            str=str.replace(/\W+(?!$)/g,'-').toLowerCase();
            $('#role_slug').val(str);
            $('#role_slug').attr('placeholder',str);
        });
    });
    </script>
    
 @endsection