@extends('layouts.adminLayout.admin_design')
 @section('content')
 <div class="admin_content_wrapper">
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
         <h1>Add Items</h1>
</div>
<div class="row">
    <div class="col-md-12">
<form id="items" name="items" action="{{url('page/edit-products/'.$products['id'])}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="box">
<div>
    <label>Select Category</label>
    <select name="category_id" id="category_id" style="width:100%;">
    <option value="">Select</option>
    @foreach($categories as $category)
        <optgroup label="{{$category['name']}}"><optgroup>
        @foreach($category['categories'] as $cat)
            <option value="{{$cat['id']}}" @if(!empty(@old('category_id')) && 
            $cat['id']==@old('category_id')) selected="" 
            @elseif(!empty($products['category_id']) && $products['category_id']==$cat['id']) selected=""
             @endif>&nbsp;->&nbsp;&nbsp;{{$cat['name']}}</option>
            @foreach($cat['subcategories'] as $subcat)
                <option value="{{$subcat['id']}}" @if(!empty(@old('category_id')) && 
            $subcat['id']==@old('category_id')) selected="" @endif>&nbsp;&nbsp; &nbsp;->&nbsp;&nbsp;{{$subcat['name']}}</option>
            @endforeach
        @endforeach
    @endforeach
    </select>
</div>
  <div>  
    <label for="name"><b>Item Name</b></label>
    <input type="text" placeholder="Enter name" name="name" id="name" value="{{$products->name}}" >
</div>
<div>
    <label for="description"><b>Description</b></label>
    <input type="text" placeholder="Enter Description" name="description" id="description"value="{{$products->description}}" >
</div>
<div>
    <label for="price"><b>Price</b></label>
    <input type="text" placeholder="Repeat Price" name="price" id="price" value=" {{$products->price}}">
</div>
<div>
    <label for="color"><b>Color</b></label>
    <input type="text" placeholder="Repeat color" name="color" id="color" value="{{$products->color}}">
</div>
<div>
    <label for="weight"><b>Weight</b></label>
    <input type="text" placeholder="Repeat weight" name="weight" id="weight" value="{{$products->weight}}">
</div>
<div>
    <label for="discount"><b>Discount %</b></label>
    <input type="text" placeholder="Repeat discount" name="discount" id="discount" value="{{$products->Discount}}">
</div>
<div>
    <label for="image"><b>Image</b></label>
                   
     <input type="file"  name="image" id="image" accept="image/*">
     @if(!empty($products->image))
        <input type="hidden"  name="current_image" value="{{$products->image}}">
         <img style="width:80px;height:53px;" src="{{asset('image/product_images/'.$products->image)}}">
     @endif
  </div>
  <div>
    <label for="size"><b>Size</b></label>
    <input type="text" placeholder="Repeat size" name="size" id="size" value="{{$products->size}}">
</div>
<div>
    <label for="style"><b>Style</b></label>
    <input type="text" placeholder="Repeat style" name="style" id="style" value="{{$products->style}}">
</div>
  <div>                   

    <label for="spaciality"><b>Spaciality</b></label>
    <input type="text" placeholder="Enter spaciality" name="spaciality" id="spaciality" value="{{$products->spaciality}}">
</div>
<div>
    <label for="material"><b>Material Used</b></label>
    <input type="text" placeholder="Repeat material" name="material" id="material" value="{{$products->material}}">
  </div>  
  <div>
    <label for="meta_title"><b>Meta Title</b></label>
    <input type="text" placeholder="Repeat meta_title" name="meta_title" id="meta_title" value="{{$products->meta_title}}">
</div>
<div>
    <label for="meta_description"><b>Meta description</b></label>
    <input type="text" placeholder="Repeat meta_description" name="meta_description" id="meta_description" value="{{$products->meta_description}}">
</div>
<div>
    <label for="is_featured"><b>Is Featured</b></label>
    <input type="checkbox" placeholder="Repeat is_featured" name="is_featured" id="is_featured">
</div>
    <button type="submit" class="additembtn">Add</button>
  </div>
  

</form>
</div>
</div>
</div>
 @endsection