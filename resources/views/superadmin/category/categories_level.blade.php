<div>
     <label><b>Select Category Level</b></label>
             <select name="parent_id" id="parent_id" style="width:100%";>
                <option value="0" @if(isset($categoryDetails['parent_id']) && $categoryDetails['parent_id']==0)
                selected="" @endif>Main Category</option>
                  @if(!empty($getCategories))
                  @foreach($getCategories as $category)
                  <option value="{{$category['id']}}" @if(isset($categoryDetails['parent_id']) && $categoryDetails['parent_id']==$category['id'])
                selected="" @endif>{{$category['name']}}</option>
                        @if(!empty($category['subcategories']))
                        @foreach($category['subcategories'] as $subcategory)
                        <option value="{{$subcategory['id']}}">&nbsp;&raquo;&nbsp;{{$subcategory['name']}}</option>
                     
                        @endforeach
                        @endif
                  @endforeach
                  @endif
             </select>
 </div>