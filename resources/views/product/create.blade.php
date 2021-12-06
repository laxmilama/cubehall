@extends('layouts.adminLayout.admin_design')

@section('title')
	Dashboard
@endsection
 @section('content')  

 <div id="AdmCont" class="admin_content_wrapper" >
		<div class="sm-container">
			<div class="review">
                <div>
                   <a href="{{url()->previous()}}">Back</a>
                </div>                
                <div>
                    <div>
                        <h1>List Your Product</h1>

                    </div>
                    <div>
                        <p>Choose “Single” if you want your product to be one of a kind or "Variant" if you want to have variation of same items.</p>
                        <div class="flex-box">
                            <div>
                                <a href="{{route('product.single')}}">
                                <div>
                                    Single                                 
                                </div>
                                </a>

                            </div>
                            <div>
                                <a href="{{route('product.variant')}}">
                                    <div>
                                        Variant                                 
                                    </div>
                                    </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>  
  @endsection   
    

