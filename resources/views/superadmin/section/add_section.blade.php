@extends('layouts.superAdminLayout.superadmin_design')
 @section('content')
 <div class="main__container">
     <div> 
         <h1>Add Category</h1>
</div>
<div class="row">
    <div class="col-md-12">
<form id="items" name="items" action="{{url('admin/add-section')}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="box">   
    
    <label for="name"><b>Section Name</b></label>
    <input type="text" placeholder="Enter name" name="name" id="name" required>

    

    <button type="submit" class="additembtn">Add</button>
  </div>
  

</form>
</div>
</div>
</div>
 @endsection