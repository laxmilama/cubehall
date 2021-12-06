@extends('layouts.adminLayout.admin_design')
@section('content')
    <style>
        ._admODR_wrap {
            display: flex;
            justify-content: space-between;
        }

        ._OD_Grid_ {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            border-top: 1px solid var(--gray-medium);
            border-right: 1px solid var(--gray-medium);
        }

        ._OD_Grid_ div {
            padding: 8px 4px;
            border-left: 1px solid var(--gray-medium);
            border-bottom: 1px solid var(--gray-medium);
        }

    </style>
    <div id="AdmCont" class="admin_content_wrapper padlft">
        <div class="container">
            <div class="row">
                <div class="box-bound margin10px padding10px ct12 space_betwwen">
                    <h3>Orders</h3>
                </div>
            </div>
            <div class="row">
                <div class="_OD_Grid_">
                    <div>
                        Product
                    </div>
                    <div>
                        Price
                    </div>
                    <div>
                        Quantity
                    </div>
                    <div>
                        Ordered Date
                    </div>
                    <div>
                        Status
                    </div>
                    <div>
                        Action
                    </div>
                </div>
                <div class="_OD_Grid_">
                    @foreach ($orders as $order)
                        <div>
                            @if (!empty($order->thumbnail))

                                <img img class="list-img"
                                    src="{{ 'http://192.168.1.85/images/product/thumb/' . $order->thumbnail }}">
                            @endif
                        </div>
                        <div>
                            {{ $order->currency }} {{ $order->price * $order->quantity }}
                        </div>
                        <div>
                            {{ $order->quantity }}
                        </div>
                        <div>
                            {{ $order->created_at }}
                        </div>
                        <div>
                            {{ $order->status }}
                        </div>
                        <div>
                            <a href="{{ route('orderDetails', $order['id']) }}">View Details</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>




@endsection
