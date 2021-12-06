@foreach ($userBagItems as $item)

<div>
    {{Cookie::get('symbol')}}
    {{Cookie::get('currency')}}
    {{$item->bagmetaproduct->price}}
    
</div>
    
@endforeach
