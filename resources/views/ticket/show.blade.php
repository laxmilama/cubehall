@extends('layouts.shop')

@section('title')
    Fashion, Furniture, Art, Decor & Inspiration - Shop Online
@endsection

@section('content')
    <div>
        <div class="sm-container">
            <div style="display: inline-block; width:100%;">
                <div>
                    <h1>Tickets</h1>
                </div>

                <div id="app">
                    <tabs-dyna>
                        <tab name="Upcoming">
                                <ticket-show :ticket="{{ $upcoming }}">
                                </ticket-show>
                        </tab>
                        <tab name="Completed">
                            <ticket-completed :ticket="{{ $tickets }}"></ticket-completed>
                        </tab>
                    </tabs-dyna>

                </div>
            </div>

        </div>
    </div>
@endsection
