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
            <form id="category" name="category" action="{{url('admin/edit-category/'.$category['id'])}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="box">   
                <div>
                    <label for="name"><b>Category Name</b></label>
                    <input type="text" placeholder="Enter name" name="name" id="name" value="{{$category->name}}">
                </div>
                <div>
                    <label ><b>Select Section</b></label>
                    <select name="section_id" id="section_id" style="width:100%";>
                    <option value="">Select</option>
                    @foreach($getSection as $get)
                    <option value="{{ $get->id }}" @if(!empty($categoryDetails['section_id'])
                         && $categoryDetails['section_id']==$get->id) selected @endif)>
                        {{$get->name}}</option>
                    @endforeach
                    </select>
                </div>
             <div id="category_level">
                @include('superadmin.category.categories_level')
             </div>
                <div>
                    <label for="discount"><b>Discount</b></label>
                    <input type="text" placeholder="Discount" name="discount" id="discount" value="{{$category->discount}}">

                 </div>        
                 <div>
                    <label for="meta_title"><b>Meta Title</b></label>
                    <input type="text" placeholder="Meta title" name="meta_title" id="meta_title" value="{{$category->meta_title}}">

                 </div>  
                

                <button type="submit" class="additembtn">Update</button>
            </div>
            

         </form>
        </div>
     </div>
    </div>
@endsection