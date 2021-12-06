@extends('layouts.shop')    

@section('title')
Library
@endsection

@section('content')
<div>
    <div class="container">
        <div class="pt30">
            <div class="flex-box lb-hd">
                <h2 class="typography-headline5">Boards</h2>
                <button>Create New</button>
            </div>
            <div class="">
                <div class="SO_grd">
                    @foreach ($boards as $board)
                        <div class="SO_board_card round_c_m">
                            <a class="_BD" href="{{route('board.show', $board->slug)}}">
                            <div class="SO_c_holder">
                                
                                    <div class="SO_b_content">
                                    @if(!is_null($board->thumb))
                                        @if($board->thumb->type == "ShowOff")
                                        <img class="SO_b_img" src="{{asset('images/showoff/small/'.$board->thumb->media)}}" alt="{{$board->name}}">
                                        
                                        @elseif ($board->thumb->type == "ProductList")
                                        <img class="SO_b_img" src="{{asset('images/product/small/'.$board->thumb->image)}}" alt="{{$board->name}}">
                                        @endif
                                    @else
                                        <img class="SO_b_img" src="{{asset('assets/16738501011556105330-128.png')}}" alt="{{$board->name}}">
                                    @endif
                                    </div>
                               
                            </div>
                            
                                    
                            <div class="flex-box _BD_title">
                                @if ($board->private =="true")
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="_BD_ico"
                                    >
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>                                    
                                @endif
                                <h3>{{$board->name}}</h3>
                                
                                
                            </div>
                        </a>
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection