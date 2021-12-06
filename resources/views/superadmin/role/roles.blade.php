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
     <a class="button" href="{{url('admin/add-roles')}}">Create New Role</a>
 
</div>
<table  class="styled-table">
 <thead>
  <tr>
  <th>Id</th>
  <th>Role</th>
  <th>Slug</th>
    <th>Permisssion</th>
    <th>Action</th>
  </tr>
  </thead>
 @foreach($roles as $role)
  <tbody>
  
  <tr>
  <td>{{$role->id}}</td>
 <td>{{$role->name}}</td>
 <td>{{$role->slug}}</td>
 <td>
 @if ($role->permissions != null)
                                    
         @foreach ($role->permissions as $permission)
            <span class="">
          {{ $permission->name }}                                    
            </span>
        @endforeach
                                
 @endif
 </td>
 <td>
 <a href="{{url('admin/edit-roles/'.$role['id'])}}">Edit</a>
 <a href="{{url('admin/delete-roles/'.$role['id'])}}">Delete</a>
 </td>
   
  </tr>
 
</tbody>
@endforeach
</table>
</div>
 @endsection