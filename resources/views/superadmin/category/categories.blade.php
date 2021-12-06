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
     <a class="button" href="{{url('admin/add-category')}}">Add Category</a>
 
</div>
   
<table  class="styled-table">
 <thead>
  <tr>
  <th>Image</th>
  <th>Category</th>
  <th>Parent Category</th>
    <th>Section</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
  @foreach($getCategory as $category)
  @if(!isset($category->parentcategory['name']))
  <?php $parent_category="Root";?>
  @else
  <?php $parent_category=$category->parentcategory['name'];?>
  @endif
  <tr>
 
    <td>{{$category->id}}</td>
    <td>{{$category->name}}</td>
    <td>{{$parent_category}}</td>
    <td>{{$category->sections['name']}}</td>
     <td>
    @if($category->status==1)
    <a href="#">Active</a>
    @else
    <a href="#">Inactive</a>
    @endif
    </td>
    <td>
    
    <a href="{{url('admin/edit-category/'.$category->id)}}">Edit</a>
  
    </td>
   
  </tr>
  @endforeach
</tbody>
</table>
</div>
 @endsection