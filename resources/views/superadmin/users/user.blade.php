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
     <a class="button" href="{{url('admin/add-admins')}}">Add User</a>
 
</div>
<table  class="styled-table">
 <thead>
  <tr>
  <th>Id</th>
  <th>Name</th>
  <th>Email</th>
    <th>Role</th>
    <th>Permisssion</th>
    <th>Action</th>
  </tr>
  </thead>
  @foreach($users as $user)
  <tbody>
  
  <tr>
  
  <td>{{$user->id}}</td>
 <td>{{$user->name}}</td>
 <td>{{$user->email}}</td>
 <td>
      @if ($user->roles->isNotEmpty())
         @foreach ($user->roles as $role)
             <span class="">
                 {{ $role->name }}
            </span>
         @endforeach
     @endif

 </td>
 <td>
       @if ($user->permissions->isNotEmpty())
                                        
          @foreach ($user->permissions as $permission)
             <span class="">
              {{ $permission->name }}                                    
             </span>
         @endforeach
                        
     @endif
 </td>
 <td>
 <a href="{{url('admin/edit-adminuser/'.$user['id'])}}">Edit</a>
 </td>
   
  </tr>
 
</tbody>
@endforeach
</table>
</div>
 @endsection