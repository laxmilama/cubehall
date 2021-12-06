@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')

<div class="container">

	<div class="row">
	

	<!-- <form method="POST" action="{{ url('/search') }}" enctype="multipart/form-data" autocomplete="off">
         {{ csrf_field() }}
	<span><strong>Default Sort:</strong></span>
	<a href="{{url()->current()}}"><span>All</span></a>
	<a href="{{url()->current()."?sort=Price_ASC"}}"><span>Price: low to high</span></a>
	<a href="{{url()->current()."?sort=Price_DESC"}}"><span>Price: high to low</span></a>
	<a href="{{url()->current()."?sort=Newest"}}"><span>Sort by Latest</span></a>
	<a href="{{url()->current()."?sort=Rating"}}"><span>Sort by Rating</span></a>

	<div id="add">
								
	</div>
</form> -->

    

<aside class="sidebar">
	<form  method="get" action="{{url('/category-filter')}}" enctype="multipart/form-data">
            {{ csrf_field() }}


			<select id="sortBy" name="sortBy" onchange="this.form.submit();" class="form-control" style="width: 200px; float: right">

					<option value="">Default</option>
					<option value="Price_ASC" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Price_ASC') selected @endif>Price: low to high</option>
					<option value="Price_DESC"  @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Price_DESC') selected @endif>Price: high to low</option>
					<option value="Newest"  @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Newest') selected @endif>Sort by Latest</option>
					<option value="Rating"  @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='Rating') selected @endif>Sort by Rating</option>
			</select>
	
		<h1 class="sidebar-heading">
			Filter by
		</h1>

		

		<ul class="filter ul-reset">
		<!-- <li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Price range
					</h1>
					
					@if(!empty($_GET['price']))

					<?php 
						//$filter_price=explode('-',$_GET['price']);
						//dd($filter_price[0]);
					?>
					@endif
				
					
				
					<div class="filter-attribute-list-inner">
						<input type="text" name="max_price" id="max_price"
						placeholder="MAX"
						 value="<?php //if(!empty($filter_price)){ echo $filter_price[0]; } ?>">
						<input type="text" name="min_price" id="min_price"
						 placeholder="MIN" 
						 value="<?php //if(!empty($filter_price)){ echo $filter_price[1]; } ?>">
						 <input type="submit" value="Apply" class="btn btn-primary">
					</div>
					
						
						
				</section>
			</li> -->


			 <li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Size
					</h1>
					<ul class="filter-attribute-list ul-reset">
						<div class="filter-attribute-list-inner">
                        @if(!empty($_GET['size']))
							
                            <?php 
								$filter_size=explode('%',$_GET['size']);
								//dd($filter_size);
                            ?>
                        @endif

                        @if(count($sizes)>0)
							@foreach($sizes as $size)
                          
                      
                           
								<li class="filter-attribute-item">
									<input type="checkbox" @if(!empty($filter_size) && in_array($size['name'],$filter_size)) 
									checked @endif name="size[]" id="{{$size['name']}}" class="form-check-input" 
									value="{{$size['name']}}" onChange="this.form.submit()" >
									<label for="colour-attribute-1" class="filter-attribute-label ib-m">
                                    {{$size['name']}}
									</label>
                                    
								</li>
                       
                            @endforeach
                            @endif
						</div>
					</ul>
				</section>
			</li> 

			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Price
					</h1>
					<ul class="filter-attribute-list ul-reset">
						<div class="filter-attribute-list-inner">
							
						@if(!empty($_GET['price']))
							
							<?php 
							$filter_siz=[];
								$filter_siz=explode('-',$_GET['price']);;
								//dd($filter_siz);
                            ?>
                        @endif

							@if(count($prices)>0)
						
							@foreach($prices as $price)
							
								
								<li class="filter-attribute-item">
									<input type="checkbox" @if(!empty($filter_siz) && in_array($price['name'],$filter_siz))
									checked @endif  id="{{$price['name']}}" name="max_price" class="form-check-input" 
									value="{{$price['name']}}" onChange="this.form.submit()">
									<label for="sizour-attribute-1" class="filter-attribute-label ib-m">
										Rs.{{$price['name']}}
									</label>
									
								</li>
								
								@endforeach
							@endif
						
						</div>
					</ul>
				</section>
			</li>


			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Material
					</h1>
					<ul class="filter-attribute-list ul-reset">
						<div class="filter-attribute-list-inner">
						@if(!empty($_GET['material']))

							<?php 
								$filter_cat=explode('%',$_GET['material']);
								//dd($filter_cat);
							?>
							@endif
						
							@if(count($data)>0)
							
							@foreach($data as $cats)
						
							
								<li class="filter-attribute-item">
									<input type="checkbox" @if(!empty($filter_cat) && in_array($cats['name'],$filter_cat))
									 checked @endif  id="{{$cats['name']}}" name="material[]" class="form-check-input" 
									value="{{$cats['name']}}" onChange="this.form.submit()">
									<label for="colour-attribute-1" class="filter-attribute-label ib-m">
										{{$cats['name']}}
									</label>
								</li>
								
								
								@endforeach
                            @endif
						</div>
					</ul>
				</section>
			</li>

			
			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Color
					</h1>
					<ul class="filter-attribute-list ul-reset">
						<div class="filter-attribute-list-inner">
						<div id="add">
								
								</div>
						</div>
					</ul>
				</section>
			</li>
	

			<li class="filter-item">
				<section class="filter-item-inner">
					<h1 class="filter-item-inner-heading minus">
						Ratings
					</h1>
					<ul class="filter-attribute-list ul-reset">
						<div class="filter-attribute-list-inner">
						@if(!empty($_GET['ratingUrl']))

							<?php 
								$filter_rating=explode('%',$_GET['ratingUrl']);
								//dd($filter_rating);
							?>
							@endif
						
							@if(count($ratings)>0)
							
							@foreach($ratings as $rating)
						
							
								<li class="filter-attribute-item">
									<input type="checkbox"  @if(!empty($filter_rating) && in_array($rating['code'],$filter_rating))
									 checked @endif  id="{{$rating['code']}}" name="rating[]" class="form-check-input" 
									value="{{$rating['code']}}" onChange="this.form.submit()">
									<label for="colour-attribute-1" class="filter-attribute-label ib-m">
										{{$rating['name']}}
									</label>
								</li>
								
								
								@endforeach
                            @endif
						</div>
					</ul>
				</section>
			</li>

		</ul>
	</form>
</aside>

            @if(count($products) > 0)
                @foreach($products as $pro)
			
             
				<div class="span12">
					<h3>{{$pro['name']}}  </h3>
					<small>{{$pro['price']}}</small>
					<hr class="soft"/>
					<small>100 items in stock</small>
					<form class="form-horizontal qtyFrm" action="{{url('add-to-bag')}}" method="POST" >@csrf
						
					
					<input type="hidden" name="product_id" value="{{$pro['id']}}">
						<button type="submit" class="btn btn-large btn-primary pull-right"> Add to Bag <i class=" icon-shopping-cart"></i></button>
					</form>
				
                </div>
               
                @endforeach
                @else
                    <p>No Product found</p>
                    @endif



					<script>
    class Colour {
	/**
	 * Convert HEX to LAB
	 * @param {[string]} hex hex colour value desired to be converted to LAB
	 */
	static HEX2LAB(hex) {
		const [R, G, b, a] = Colour.HEX2RGBA(hex);
		const [X, Y, Z] = Colour.RGB2XYZ(R, G, b, a);
		const [L, A, B] = Colour.XYZ2LAB(X, Y, Z);
		return [L, A, B];
	}
	/**
	 * Convert RGBA to LAB
	 * @param {[Number]} R     Red value from 0 to 255
	 * @param {[Number]} G     Green value from 0 to 255
	 * @param {[Number]} B     Blue value from 0 to 255
	 */
	static RGBA2LAB(R, G, b, a = 1) {
		const [X, Y, Z] = Colour.RGB2XYZ(R, G, b, a);
		const [L, A, B] = Colour.XYZ2LAB(X, Y, Z);
		return [L, A, B];
	}
	/**
	 * Convert LAB to RGBA
	 * @param {[Number]} L
	 * @param {[Number]} A
	 * @param {[Number]} B 
	 */
	static LAB2RGBA(L, A, B) {
		const [X, Y, Z] = Colour.LAB2XYZ(L, A, B);
		const [R, G, b, a] = Colour.XYZ2RGBA(X, Y, Z);
		return [R, G, b, a];
	}
	/**
	 * Convert HEX to RGBA
	 * @param {[string]} hex hex colour value desired to be converted to RGBA
	 */
	static HEX2RGBA(hex) {
		let c;
		if (hex.charAt(0) == "#") {
			c = hex.substring(1).split('');
		}
		if (c.length > 6 || c.length < 3) {
			throw new Error(`HEX colour must be 3 or 6 values. You provided it ${c.length}`);
		}
		if (c.length == 3) {
			c = [c[0], c[0], c[1], c[1], c[2], c[2]];
		}
		c = '0x' + c.join('');
		let R = (c >> 16) & 255;
		let G = (c >> 8) & 255;
		let B = c & 255;
		let A = 1;
		return [R, G, B, A];
	}
	/**
	 * Convert RGB to XYZ
	 * @param {[Number]} R     Red value from 0 to 255
	 * @param {[Number]} G     Green value from 0 to 255
	 * @param {[Number]} B     Blue value from 0 to 255
	 * @param {Number} [A=1] Obacity value from 0 to 1 with a default value of 1 if not sent
	 */
	static RGB2XYZ(R, G, B, A = 1) {
		if (R > 255) {
			console.warn('Red value was higher than 255. It has been set to 255.');
			R = 255;
		} else if (R < 0) {
			console.warn('Red value was smaller than 0. It has been set to 0.');
			R = 0;
		}
		if (G > 255) {
			console.warn('Green value was higher than 255. It has been set to 255.');
			G = 255;
		} else if (G < 0) {
			console.warn('Green value was smaller than 0. It has been set to 0.');
			G = 0;
		}
		if (B > 255) {
			console.warn('Blue value was higher than 255. It has been set to 255.');
			B = 255;
		} else if (B < 0) {
			console.warn('Blue value was smaller than 0. It has been set to 0.');
			B = 0;
		}
		if (A > 1) {
			console.warn('Obacity value was higher than 1. It has been set to 1.');
			A = 1;
		} else if (A < 0) {
			console.warn('Obacity value was smaller than 0. It has been set to 0.');
			A = 0;
		}
		let r = R / 255;
		let g = G / 255;
		let b = B / 255;
		// step 1
		if (r > 0.04045) {
			r = Math.pow(((r + 0.055) / 1.055), 2.4);
		} else {
			r = r / 12.92;
		}
		if (g > 0.04045) {
			g = Math.pow(((g + 0.055) / 1.055), 2.4);
		} else {
			g = g / 12.92;
		}
		if (b > 0.04045) {
			b = Math.pow(((b + 0.055) / 1.055), 2.4);
		} else {
			b = b / 12.92;
		}
		// step 2
		r = r * 100;
		g = g * 100;
		b = b * 100;
		// step 3
		const X = (r * 0.4124) + (g * 0.3576) + (b * 0.1805);
		const Y = (r * 0.2126) + (g * 0.7152) + (b * 0.0722);
		const Z = (r * 0.0193) + (g * 0.1192) + (b * 0.9505);
		return [X, Y, Z];
	}
	/**
	 * Convert XYZ to RGBA
	 * @param {[Number]} X
	 * @param {[Number]} Y
	 * @param {[Number]} Z
	 */
	static XYZ2RGBA(X, Y, Z) {
		let var_X = X / 100;
		let var_Y = Y / 100;
		let var_Z = Z / 100;

		let var_R = (var_X *  3.2406) + (var_Y * -1.5372) + (var_Z * -0.4986);
		let var_G = (var_X * -0.9689) + (var_Y *  1.8758) + (var_Z *  0.0415);
		let var_B = (var_X *  0.0557) + (var_Y * -0.2040) + (var_Z *  1.0570);

		if ( var_R > 0.0031308 ) {
			var_R = 1.055 * Math.pow(var_R, (1 / 2.4) ) - 0.055;
		} else {
			var_R = 12.92 * var_R;
		}
		if ( var_G > 0.0031308 ) {
			var_G = 1.055 * Math.pow(var_G, (1 / 2.4) ) - 0.055;
		} else {
			var_G = 12.92 * var_G;
		}
		if ( var_B > 0.0031308 ) {
			var_B = 1.055 * Math.pow(var_B, (1 / 2.4) ) - 0.055;
		} else {
			var_B = 12.92 * var_B;
		}

		let R = Math.round(var_R * 255);
		let G = Math.round(var_G * 255);
		let B = Math.round(var_B * 255);

		return [R, G, B, 1];
	}
	/**
	 * Convert XYZ to LAB
	 * @param {[Number]} X Value
	 * @param {[Number]} Y Value
	 * @param {[Number]} Z Value
	 */
	static XYZ2LAB(X, Y, Z) {
		// using 10o Observer (CIE 1964)
		// CIE10_D65 = {94.811f, 100f, 107.304f} => Daylight
		const ReferenceX = 94.811;
		const ReferenceY = 100;
		const ReferenceZ = 107.304;
		// step 1
		let x = X / ReferenceX;
		let y = Y / ReferenceY;
		let z = Z / ReferenceZ;
		// step 2
		if (x > 0.008856) {
			x = Math.pow(x, (1 / 3));
		} else {
			x = (7.787 * x) + (16 / 116);
		}
		if (y > 0.008856) {
			y = Math.pow(y, (1 / 3));
		} else {
			y = (7.787 * y) + (16 / 116);
		}
		if (z > 0.008856) {
			z = Math.pow(z, (1 / 3));
		} else {
			z = (7.787 * z) + (16 / 116);
		}
		// step 3
		const L = (116 * y) - 16;
		const A = 500 * (x - y);
		const B = 200 * (y - z);
		return [L, A, B];
	}
	/**
	 * Convert LAB to XYZ
	 * @param {[Number]} L
	 * @param {[Number]} A
	 * @param {[Number]} B
	 */
	static LAB2XYZ(L, A, B) {
		// using 10o Observer (CIE 1964)
		// CIE10_D65 = {94.811f, 100f, 107.304f} => Daylight
		const ReferenceX = 94.811;
		const ReferenceY = 100;
		const ReferenceZ = 107.304;

		let var_Y = ( L + 16 ) / 116;
		let var_X = A / 500 + var_Y;
		let var_Z = var_Y - B / 200;

		if ( Math.pow(var_Y, 3)  > 0.008856 ) {
			var_Y = Math.pow(var_Y, 3);
		} else {
			var_Y = ( var_Y - 16 / 116 ) / 7.787;
		}
		if ( Math.pow(var_X, 3)  > 0.008856 ) {
			var_X = Math.pow(var_X, 3);
		} else {
			var_X = ( var_X - 16 / 116 ) / 7.787;
		}
		if ( Math.pow(var_Z, 3)  > 0.008856 ) {
			var_Z = Math.pow(var_Z, 3);
		} else {
			var_Z = ( var_Z - 16 / 116 ) / 7.787;
		}

		let X = var_X * ReferenceX;
		let Y = var_Y * ReferenceY;
		let Z = var_Z * ReferenceZ;

		return [X, Y, Z];
	}
	/**
	 * The difference between two given colours with respect to the human eye
	 * @param {[type]} l1 Colour 1
	 * @param {[type]} a1 Colour 1
	 * @param {[type]} b1 Colour 1
	 * @param {[type]} l2 Colour 2
	 * @param {[type]} a2 Colour 2
	 * @param {[type]} b2 Colour 2
	 */
	static DeltaE00(l1, a1, b1, l2, a2, b2) {
		// Utility functions added to Math Object
		Math.rad2deg = function(rad) {
			return 360 * rad / (2 * Math.PI);
		};
		Math.deg2rad = function(deg) {
			return (2 * Math.PI * deg) / 360;
		};
		// Start Equation
		// Equation exist on the following URL http://www.brucelindbloom.com/index.html?Eqn_DeltaE_CIE2000.html
		const avgL = (l1 + l2) / 2;
		const C1 = Math.sqrt(Math.pow(a1, 2) + Math.pow(b1, 2));
		const C2 = Math.sqrt(Math.pow(a2, 2) + Math.pow(b2, 2));
		const avgC = (C1 + C2) / 2;
		const G = (1 - Math.sqrt(Math.pow(avgC, 7) / (Math.pow(avgC, 7) + Math.pow(25, 7)))) / 2;

		const A1p = a1 * (1 + G);
		const A2p = a2 * (1 + G);

		const C1p = Math.sqrt(Math.pow(A1p, 2) + Math.pow(b1, 2));
		const C2p = Math.sqrt(Math.pow(A2p, 2) + Math.pow(b2, 2));

		const avgCp = (C1p + C2p) / 2;

		let h1p = Math.rad2deg(Math.atan2(b1, A1p));
		if (h1p < 0) {
			h1p = h1p + 360;
		}

		let h2p = Math.rad2deg(Math.atan2(b2, A2p));
		if (h2p < 0) {
			h2p = h2p + 360;
		}

		const avghp = Math.abs(h1p - h2p) > 180 ? (h1p + h2p + 360) / 2 : (h1p + h1p) / 2;

		const T = 1 - 0.17 * Math.cos(Math.deg2rad(avghp - 30)) + 0.24 * Math.cos(Math.deg2rad(2 * avghp)) + 0.32 * Math.cos(Math.deg2rad(3 * avghp + 6)) - 0.2 * Math.cos(Math.deg2rad(4 * avghp - 63));

		let deltahp = h2p - h1p;
		if (Math.abs(deltahp) > 180) {
			if (h2p <= h1p) {
				deltahp += 360;
			} else {
				deltahp -= 360;
			}
		}

		const delta_lp = l2 - l1;
		const delta_cp = C2p - C1p;

		deltahp = 2 * Math.sqrt(C1p * C2p) * Math.sin(Math.deg2rad(deltahp) / 2);

		const Sl = 1 + ((0.015 * Math.pow(avgL - 50, 2)) / Math.sqrt(20 + Math.pow(avgL - 50, 2)));
		const Sc = 1 + 0.045 * avgCp;
		const Sh = 1 + 0.015 * avgCp * T;

		const deltaro = 30 * Math.exp(-(Math.pow((avghp - 275) / 25, 2)));
		const Rc = 2 * Math.sqrt(Math.pow(avgCp, 7) / (Math.pow(avgCp, 7) + Math.pow(25, 7)));
		const Rt = -Rc * Math.sin(2 * Math.deg2rad(deltaro));

		const kl = 1;
		const kc = 1;
		const kh = 1;

		const deltaE = Math.sqrt(Math.pow(delta_lp / (kl * Sl), 2) + Math.pow(delta_cp / (kc * Sc), 2) + Math.pow(deltahp / (kh * Sh), 2) + Rt * (delta_cp / (kc * Sc)) * (deltahp / (kh * Sh)));

		return deltaE;
	}
	/**
	 * Get darker colour of the given colour
	 * @param {[Number]} R     Red value from 0 to 255
	 * @param {[Number]} G     Green value from 0 to 255
	 * @param {[Number]} B     Blue value from 0 to 255
	 */
	static GetDarkerColour(r, g, b, a = 1, darkenPercentage = 0.05) {
		let [L1, A1, B1] = Colour.RGBA2LAB(r, g, b, a);
		L1 -= L1 * darkenPercentage;
		if (L1 < 0) {
			L1 = 0;
		}
		let [R, G, B, A] = Colour.LAB2RGBA(L1, A1, B1);
		return [R, G, B, A];
	}
	/**
	 * Get brighter colour of the given colour
	 * @param {[Number]} R     Red value from 0 to 255
	 * @param {[Number]} G     Green value from 0 to 255
	 * @param {[Number]} B     Blue value from 0 to 255
	 */
	static GetBrighterColour(r, g, b, a = 1, brighterPercentage = 0.05) {
		let [L1, A1, B1] = Colour.RGBA2LAB(r, g, b, a);
		L1 += L1 * brighterPercentage;
		if (L1 > 100) {
			L1 = 100;
		}
		let [R, G, B, A] = Colour.LAB2RGBA(L1, A1, B1);
		return [R, G, B, A];
	}
}
var preColor = [
		["#83FFCF", "#36CC92", "#008E5B", "#006D43", "#00492D"],
		["#83E8FF", "#38B2CE", "#0696BB", "#076B82", "#00454C"],
		["#80C9FF", "#358FD3", "#2A71B0", "#0F5487", "#053D66"],
		["#8092FF", "#5866B7", "#444E99", "#28347C", "#0A186B"],
		["#CA80FF", "#8B4CC1", "#6D398B", "#4A1C7A", "#2B0054"],
		["#FF80D5", "#D836A2", "#C4037D", "#8E096F", "#660245"],
		["#FF8080", "#EA3B3B", "#E32322", "#991919", "#661010"],
		["#FFA780", "#EF723C", "#EA621F", "#B53716", "#66230C"],
		["#FFC994", "#F7A24D", "#F18E1C", "#BF6819", "#68350C"],
		["#FFECB6", "#FFD664", "#FDC60B", "#CC920E", "#664806"],
		["#FFF5A9", "#F2E03D", "#F4E500", "#CCB800", "#665C00"],
		["#EBFFB3", "#ACD340", "#8CBB26", "#82A521", "#526600"],
		["#F2F2F2", "#CCCCCC", "#888888", "#545454", "#262626"]
	];

	var newColor = "#D08CF3";
	function GetNearestDefinedColor(c){
		var colNewList = {};
		const [L1, A1, B1] = Colour.HEX2LAB(c, 1);

		for(var i=0; i<preColor.length; i++){
			for(var j = 0; j<preColor[i].length; j++){
				const [L2, A2, B2] = Colour.HEX2LAB(preColor[i][j], 2);
				colNewList[preColor[i][j]] = Colour.DeltaE00(L1, A1, B1, L2, A2, B2);
			}
		}
		let key = Object.keys(colNewList).reduce((key, v) => colNewList[v] < colNewList[key] ? v : key);
		return key;
	}

	var t = "";
	
	for(var i=0; i<preColor.length; i++){
		t+="<section>";
			for(var j = 0; j<preColor[i].length; j++){
				
				t+='<div  style="width:max-content; height: 40px;' + ' background:'+ preColor[i][j] +';">'+'<input type="radio" onclick="javscript:this.form.submit();" id="color_hex" name="color_hex"  value="'+preColor[i][j]+'">'+preColor[i][j]+'</div>';
			}
			t+="</section>";
	}

	document.getElementById("add").innerHTML += t;
</script>
           
@endsection

