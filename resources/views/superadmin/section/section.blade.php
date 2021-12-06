@extends('layouts.superAdminLayout.superadmin_design')
 @section('content')
 <div class="main__container">
     <div> 
     <a class="button" href="{{url('admin/add-section')}}">Add Section</a>
</div>
<table class="styled-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sections as $section)
  <tr>
 
    <td>{{$section->id}}</td>
    <td>{{$section->name}}</td>
    <td>
    @if($section->status==1)
    <a href="#">Active</a>
    @else
    <a href="#">Inactive</a>
    @endif
    </td>
    
   
  </tr>
  @endforeach
      
        <!-- and so on... -->
    </tbody>
</table>

</div>
 @endsection