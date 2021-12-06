@extends('layouts.shop')    

@section('title')
Design Agency
@endsection

@section('content')
<div class="container">
    <div class="row">
        <form action="/switch-currency" method="post" enctype="multipart/form-data" name="currency">
            {{ csrf_field() }}
            <label for="currency">Select a Currecny</label><br>
            <?php $currencyy = \App\Models\Currency::where('status',1)->get();
            $currency= Cookie::get('currency');
            if(Auth::check())
            {
            $userCurrency=\App\Models\UserCurriency::where('user_id',Auth::user()->id)->pluck('currency_code');
          // dd($userCurrency );
            }                 ?>
            <select name="currency" id="currency" onchange="this.form.submit();" >
                @foreach ($currencyy as $cu )
                
                    @if ($currency ==  $cu->currency_code)
                 
                    <option value="{{ $cu->currency_code }}" selected>{{$cu->currency_code}}</option>
               
                    @elseif (Auth::check() && $userCurrency== $cu->currency_code)
                    <option value="{{ $cu->currency_code }}" selected>{{$cu->currency_code}}</option>
                    @else
                    <option value="{{ $cu->currency_code }}">{{$cu->currency_code}}</option>
                @endif
                @endforeach
            </select>
            
            </form>
        </div>
@endsection

