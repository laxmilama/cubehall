@extends('layouts.adminLayout.admin_design')
@section('content')


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="AdmCont" class="fullwidth padlft">
        <div class="sm-container">
            <div class="_AL_wrap mt-m">
                <div id="app">
                    <coupon :collections="{{ $pageCategories }}" :products="{{ $products }}"
                        :shoppers="{{ $shoppers }}"></coupon>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(".updateCouponStatus").click(function() {
            var status = $(this).text();
            var coupon_id = $(this).attr("coupon_id");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: '/page/update-coupon-status',
                data: {
                    status: status,
                    coupon_id: coupon_id
                },
                success: function(resp) {
                    if (resp['status'] == 0) {
                        $("#coupon-" + coupon_id).html(
                            "<a class='updateCouponStatus' href='javascript:void(0)'> Inactive</a>");

                    } else if (resp['status'] == 1) {
                        $("#coupon-" + coupon_id).html(
                            "<a class='updateCouponStatus' href='javascript:void(0)'> Active</a>");;
                    }
                },
                error: function() {
                    alert("Error");
                }

            });
        });
    </script>
@endsection
