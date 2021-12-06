<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use App\Models\ProductList;
use App\Models\ProductMeta;
use App\Models\SearchKeyword;
use App\Models\Page;
use App\Models\Category;
use App\Models\ProductReview;
use Illuminate\Support\Str;
use Session;
use Auth;
use Cookie;
use Illuminate\Support\Facades\Input;

use DB;

class SearchProductController extends Controller
{

   public function searchAutocomplete(Request $request){

        $keyword=$request->get('term',' ');
        // dd($keyword);
        $stopwords = array('the','then','than','that','a','an','and','I','it','is','do','does','for','from',
        'go' ,'how','etc','here','in','there'
        );
        $searchValues = preg_split('/[^-\w\']+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        $newArray = array_udiff($searchValues, $stopwords, 'strcasecmp');
        //dd($newArray);
        $merged=[];
         if($newArray != null){
             $products= ProductList::where(function ($q) use ($newArray) {
        
              foreach ($newArray as $new) {
                $key = $new.'%';
                $q->where('name', 'LIKE', $key);
              }
              })->where('status','1')->select('name','id')->get();
              $products = collect($products);
              //dd($products);
                $product= ProductList::where(function ($q) use ($newArray) {
                    foreach ($newArray as $new) {
                      $key = '%'.$new.'%';
                    $q->where('name', 'LIKE', $key);
                //->orWhere('description', 'LIKE',$new.'%')
                    }
                })->where('status','1')->select('name','id')->get();
                $product = collect($product);
      //dd($product);
              $pro=$products->merge($product);
              //dd($pro);
              $uniqueProduct=$pro->unique('name');              
            }
           
            $data=[];
            
            foreach($uniqueProduct as $items){
            //dd($items);
              $data[]=[
                'value'=>$items->name,
                'id'=>$items->id,
              ];
            }
            //dd($data);
            if(count($data)){
            // dd($data);
              return $data;
            }
            else{
              return ['value'=>''];
            }   
    }


    
  public function search(Request $request){
  
    //dd($request->all());
    $searchingData=$request->get('search_product');
   //dd($searchingData);
    $session_id=Session::get('session_id');
      if(empty($session_id)){
          $session_id=Session::getId();
          Session::put('session_id',$session_id);
      }
      $getSession=SearchKeyword::where('session_id',$session_id)->select('keyword','hit','id')->get();
      //dd($getSession);
      foreach($getSession as $session){
        $sessionKeyword=$session['keyword'];
        $keywordId=$session['id'];
      }
    // dd($sessionKeyword);
     $keywords=new SearchKeyword;
          if($getSession->isEmpty()){ 
           // dd('a');
            $keywords->session_id=$session_id;
            if(Auth::check()){
              $keywords->user_id=Auth::user()->id;
              }
             $keywords->keyword=$searchingData;
             $keywords->hit=1;
             $keywords->save();
           }
         else if($sessionKeyword==$searchingData){ 
           
                SearchKeyword::where('id',$keywordId)->update([
                'hit'=>$session['hit']+1]);   
          }
           else{ 
            //dd('a');
              $keywords->session_id=$session_id;
              if(Auth::check()){
                $keywords->user_id=Auth::user()->id;
                }
               $keywords->keyword=$searchingData;
               $keywords->hit=1;
               $keywords->save();
            }
         
         
          
         // Cookie::queue(Cookie::forever('keyword', $keywords));
           $products=ProductList::query();
 
  
          
            $page=ProductList::where('name', 'LIKE', '%'.$searchingData.'%')
            ->where('status','1')->pluck('id')->toArray();
            if(!empty($_GET['size'])){
                      // dd($_GET['size']);
                      $slugs=explode('%',$_GET['size']);
                      
                        $cate_ids=ProductMeta::whereIn('product_id',$page)->whereIn('size',$slugs)->pluck('product_id')->toArray();
                    // dd($cate_ids);
                        $products=$products->whereIn('id',$cate_ids)->where(['status'=>1]);
                      // dd($products);
                      //  return $products;
                      // }
                  }
                // dd($products);
                if(!empty($_GET['price'])){
                  // dd(($_GET['price']=='20,000 '));

                  if($_GET['price']=='20,000 '){
                    $slug=str_replace( ',', '', $_GET['price'] );
                  // dd($slug);
                    $products=$products->where(['status'=>1])->where('price','>=',$slug);
                  // dd($products);
                  }
                else{
                    $slug=explode('-',$_GET['price']);
                    $slug=str_replace( ',', '', $slug);
                    // dd($slug);
                  $products=$products->whereBetween('price',$slug);
                  //dd($products);
                }
              
              }

        
      
            if(!empty($_GET['material'])){
                // dd($_GET['material']);
                $slugs=explode('%',$_GET['material']);
                //dd($slugs);
                
                $cate_ids=ProductMeta::whereIn('product_id',$page)->whereIn('material',$slugs)->pluck('product_id')->toArray();
                $products=$products->whereIn('id',$cate_ids)->where(['status'=>1]);
                // return $products;
               // dd($products);
            }
            // dd($_GET['color_hex']);

            if(!empty($_GET['color_hex'])){
                //dd($_GET['color_hex']);
                  $slugs=explode('%',$_GET['color_hex']);
                // dd($slugs);
                  $cate_ids=ProductMeta::whereIn('product_id',$page)->whereIn('colorhex',$slugs)->pluck('product_id')->toArray();
                //dd($cate_ids);
                  $products=$products->whereIn('id',$cate_ids)->where(['status'=>1]);
                  // return $products;
              }
            if(!empty($_GET['ratingUrl'])){
                // dd($_GET['ratingUrl']);
                $slugs=explode('%',$_GET['ratingUrl']);
                  //dd($slugs);
                  $cate_ids=ProductReview::whereIn('product_id',$page)->whereIn('rating',$slugs)->pluck('product_id')->toArray();
                  //dd($cate_ids);
                  $products=$products->whereIn('id',$cate_ids)->where(['status'=>1])->get()->toArray();
                  // dd($products);
              }
            

            
          
            else{
              $products=$products->where('name', 'LIKE', '%'.$searchingData.'%')
              ->where('status','1')->get();
            }
            //dd($products);
            $url=public_path().'/js/filter/materials.json';
            $datas=file_get_contents($url);
            //dd($datas);
            $data=json_decode($datas,true);
          
            //dd($data);
            $urls=public_path().'/js/filter/prices.json';
            $prices=file_get_contents($urls);
          
            $prices=json_decode($prices,true);
          // dd($prices);
            //dd($sizes);
            
            $urls=public_path().'/js/filter/sizes.json';
            $sizes=file_get_contents($urls);
            //dd($datas);
            $sizes=json_decode($sizes,true);
            //dd($sizes);

            $urls=public_path().'/js/filter/ratings.json';
            $ratings=file_get_contents($urls);
            //dd($datas);
            $ratings=json_decode($ratings,true);

      
          return view('search',['page'=>$page,'products'=>$products,
          'sizes'=>$sizes,'data'=>$data,'prices'=>$prices,
          'ratings'=>$ratings,'searchingData'=>$searchingData
      
      
      ]);
  }
  public function searchFilter(Request $request){
    
          $data=$request->all();
          $itemUrl='';
          if(!empty($data['item'])){
              $itemUrl .='?search_product='.$data['item'];
            // dd($itemUrl);
          }
          //filter by sort
          $sortUrl='';
          if(!empty($data['sortBy'])){
              $sortUrl .='&sortBy='.$data['sortBy'];
            // dd($sortUrl);
          }

          $sizeUrl='';
          if(!empty($data['size'])){
        //dd($data['size']);
              foreach($data['size'] as $size){ 
                  if(empty($sizeUrl)){
                      $sizeUrl .='&size='.$size;
                  }
                  else{
                      $sizeUrl .='%'.$size;
                  }
                }
        //dd($sizeUrl);
          }

        //price filter
        $price_range='';
        if(!empty($data['max_price'])){
          //dd($data['max_price']);
          $price_range .='&price='.$data['max_price'];
                
        }

        $materialUrl='';
        if(!empty($data['material'])){
          foreach($data['material'] as $material){ 
              if(empty($materialUrl)){
                  $materialUrl .='&material='.$material;
              }
              else{
                  $materialUrl .='%'.$material;
              }
            }

        }

          $colorhex='';
          if(!empty($data['color_hex'])){
            
                      $colorhex .='&color_hex='.urlencode($data['color_hex']);
              
          }

          $ratingUrl='';
          if(!empty($data['rating'])){
        // dd($data['rating']);
                foreach($data['rating'] as $rating){ 
                    if(empty($ratingUrl)){
                        $ratingUrl .='&ratingUrl='.$rating;
                    }
                    else{
                        $ratingUrl .='%'.$rating;
                    }
                }
            
              
          }
          
        return redirect('search'.$itemUrl.$sortUrl.$sizeUrl.$price_range.$materialUrl.$colorhex.$ratingUrl);
        
}

public function searchStudio(Request $request){
  //dd($request->all());
  $data=$request->get('search-query');
  //dd($data);
  $session_id=Session::get('session_id');
  if(empty($session_id)){
      $session_id=Session::getId();
      Session::put('session_id',$session_id);
  }

    $keywords=new SearchKeyword;
    $keywords->session_id=$session_id;
    if(Auth::check()){
      $keywords->user_id=Auth::user()->id;
      }
      $keywords->keyword=$data ;
      //if(Auth::check() || $keywords->session_id)
      $keywords->hit=1;
      $keywords->save();

      $pages=Page::where('name', 'LIKE', '%'.$data.'%')
      ->where('status','1')->get();
     // dd($pages);

      return view('search_studio',[
        'pages'=>$pages
      ]);
}

  //get search history
  public function searchHistory(){
    $session_id=Session::get('session_id');
    $results=SearchKeyword::where('session_id',$session_id)->select('keyword','id')->get();
    // dd($results);
    
    //$results=Cookie::get('keyword');
    
    
    if($results != false){ 
    if($results->isEmpty()){
      return 0;
    }
    else{ 
      foreach($results as $items){
      //dd($items);
        $result[]=[
          'value'=>$items->keyword,
          'id'=>$items->id,
        ];
      }
      //dd($result);
    return $result;
    }
  }

    //dd($results);
    // return $results;
  }
  //selete browsing data
  public function searchDelete(){
    $keywords = SearchKeyword::get();
    foreach($keywords as $keyword){
    $keyword->delete();
    }
    return back(); 
  }
}
