<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ProductMeta;
use Illuminate\Http\Request;

class ProductMetaController extends Controller
{
    public function store($request, $product_id, $page_id)
    {
        $metas = json_decode($request, true);

        // return $metas[0];
        // return count($metas);
        for ($i = 0; $i < count($metas); $i++) {
            $meta = new ProductMeta();
            $meta->product_id = $product_id;
            $meta->page_id = $page_id;
            $meta->title = $metas[$i]['title'];
            $meta->colorhex = $metas[$i]['color'];
            $meta->colors = json_encode($metas[$i]['colors'][0]);
            $meta->thumbnail = $metas[$i]['thumbnail'];
            $meta->descriptionimage = json_encode($metas[$i]['images']);
            $meta->price = $metas[$i]['price'];
            $meta->size = $metas[$i]['size'];
            $meta->material = json_encode($metas[$i]['material']);
            $meta->stock = $metas[$i]['stock'];
            $meta->sku = $metas[$i]['SKU'];
            $meta->save();
        }
        return $meta;
    }

    public function destroy($id){
        
    }
}
