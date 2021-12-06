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
     Product Attribute
 
</div>
<form name="editAttribute" id="editAttribute" action="{{url('admin/edit-attribute/'.$details['id'])}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<table  class="styled-table">
 <thead>
  <tr>
  <th>Size</th>
  <th>Material</th>
  <th>Price</th>
  
    <th>Stock</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
  </thead>
  @foreach($details['attributes'] as $detail)
  <input type="hidden" name="attrId[]" value="{{$detail->id}}">
  <tbody>
  
  <tr>
 
 <td>{{$detail->size}}</td>
 <td>{{$detail->material}}</td>
 <td>
 <input type="number" name="pricee[]" value="{{ $detail['price'] }}"  required/>
 </td>
 
 <td>
 <input type="number" name="stockk[]" value="{{ $detail['stock'] }}" required/>
 </td>
 <td>
    @if($detail->status==1)
    <a href="#">Active</a>
    @else
    <a href="#">Inactive</a>
    @endif
    </td>
 
 <td>
 <a href="{{url('admin/edit-products/'.$detail['id'])}}">Delete</a>
 
 </td>
   
  </tr>
 
</tbody>
@endforeach
<td>
<button>bgg</button></td>
</table>
</form>
</div>
 @endsection