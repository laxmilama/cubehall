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
         <h1>Edit Category</h1>
</div>
<div class="row">
        <div class="col-md-12">
            <form id="roles" name="roles" action="{{url('admin/edit-roles/'.$roleDetails['id'])}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="box1">   
            <div>
                <label for="user_role"><b>Role Name</b></label>
                <input type="text" placeholder="Enter user_role" name="user_role" id="user_role" value="{{$roleDetails['name']}}">
         </div>
         <div>
                <label for="role_slug"><b>Role Slug</b></label>
                <input type="text" placeholder="Enter role_slug" name="role_slug" id="role_slug" value="{{$roleDetails['slug']}}">
        </div>
        <div>
                <label for="roles_permissions"><b>Add Permission</b></label>
                <input type="text" placeholder="Enter role_permission" name="roles_permissions" id="roles_permissions"
                value="@foreach ($roleDetails->permissions as $permission)
            {{$permission->name. ","}}
        @endforeach">
        </div> 
                

        <button type="submit" class="additembtn">Update</button>
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