<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page\ProductListController;
use App\Http\Controllers\SearchProductController;
use App\Http\Controllers\ParlorController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ImpressionController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\Page\StudioCoverController;
use App\Http\Controllers\Page\StudioCustomize;
use App\Http\Controllers\Page\StudioProfileController;
use App\Http\Controllers\ShowOffController;
use App\Http\Controllers\Page\ReviewsController;
use App\Http\Controllers\Page\CouponController;
use App\Http\Controllers\Page\OrderController;
use App\Http\Controllers\Page\ProductAnalytics;
use App\Http\Controllers\StudioController;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', 'HomeController@show')->name('home');

Route::get('delivery', 'TestController@deliveries');
Route::get('/delivery/orders', 'TestController@getOrders');
Route::get('/delivery/order/{id}', 'TestController@getOrder');
Route::get('/delivery/order/track/{id}', 'TestController@track');
Route::get('delivery/post/order', 'TestController@postOrder');
Route::get('delivery/get/orders', 'TestController@store');
Route::get('delivery/status', 'TestController@status');
Route::match(['get', 'post'],'delivery/post', 'TestController@postDelivery');

Auth::routes();
Route::get('/verify',[App\Http\Controllers\Auth\RegisterController::class, 'verifyUser']);

Route::post('/login',[App\Http\Controllers\Auth\LoginController::class,'loginUser'])->name('login'); 

Route::get('/get/showoffs', 'HomeController@showoff');
Route::get('/get/home/parlor', 'ExploreController@topParlor');


//chat message
Route::get('messages', 'MessageController@testfollow');
Route::get('contacts', 'MessageController@testget');
Route::get('conversation/{id}', 'MessageController@getConversation');
Route::post('conversation/send', 'MessageController@saveConversation');
Route::post('message/upload/image', 'MessageController@saveImage');


//google signup
Route::match(['get', 'post'],'auth/google', 'Auth\GoogleController@redirectToGoogle')->name('google');
Route::match(['get', 'post'],'auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
Route::match(['get', 'post'],'auth/google1/callback', 'Auth\GoogleController@handleGoogle1Callback')->name('google1.callback');
//search product
Route::get('/search-autocomplete', [SearchProductController::class, 'searchAutocomplete'])->name('searchAutocomplete');
Route::get('/s', [SearchProductController::class, 'search'])->name('search');
Route::get('/search', [SearchProductController::class, 'show']);
Route::get('/search-filter', [SearchProductController::class, 'searchFilter'])->name('search/filter');
Route::get('/search/studio', [SearchProductController::class, 'searchStudio'])->name('search/studio');
Route::get('/search-history', [SearchProductController::class, 'searchHistory'])->name('searchHistory');
Route::get('/search-trend', [SearchProductController::class, 'trendingSearch'])->name('searchTrend');
Route::get('/delete-search', [SearchProductController::class, 'searchDelete'])->name('searchDelete');

// categories Filter
Route::get('/cat/products', [CategoryController::class, 'all'])->name('category.all');
Route::get('/cat/{category}', [CategoryController::class, 'showPrimary'])->name('category.primary');
Route::get('/cat/{category}/{subcategory}', [CategoryController::class, 'showSecondary'])->name('category.secondary');

Route::get('/api/cat/{category}', [CategoryController::class, 'primary']);
Route::get('/api/cat/{category}/{subcategory}', [CategoryController::class, 'secondary']);


//apply coupon
Route::post('/apply-coupon-code',[ProjectController::class,'applyCouponCode'])->name('applyCouponCode');
Route::post('coupon/apply', 'BagController@applyCoupon');

//product details
Route::get('/product_details/{product_detail}', [ProjectController::class, 'productDetail'])->name("productDetail");
//get product price
Route::post('/get-product-price', [ProjectController::class, 'productPrice'])->name("productPrice");
//add to bag
Route::match(['get', 'post'], '/add-to-bag', [ProjectController::class, 'addtoBag'])->name("addtoBag");
Route::match(['get', 'post'], '/bag', [ProjectController::class, 'bag'])->name("bag");
//increase and decrease quantity of the bags
Route::post('/update-bag-quantity', [ProjectController::class, 'productQuantity'])->name("productQuantity");
//delete bag product
Route::post('/delete-bag-product', [ProjectController::class, 'productBagDelete'])->name("productBagDelete");
//checkout
Route::match(['get', 'post'], '/checkout', [ProjectController::class, 'checkout'])->name("checkout");
Route::post('payment/verification', [ProjectController::class,'verification']);
//color
Route::get('/color', [SearchProductController::class, 'color']);

Route::get('/color', function(){
    return view('colr');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('account/settings', 'AccountController@show')->name('account.settings');
    Route::get('account/settings/personal-info', 'AccountController@personal')->name('account.personal');
    Route::post('account/update/name', 'AccountController@updateName');
    Route::get('account/settings/gov', 'AccountController@gov')->name('account.kyc');
    Route::post('account/uploader/image', 'KYCController@upload');
    Route::post('account/post/kyc', 'KYCController@store');
    Route::post('account/payment/save', 'PaymentController@store');
    Route::delete('account/payment/delete/{payment}', 'PaymentController@destroy');
    Route::get('account/settings/payment', 'PaymentController@show')->name('account.payment');   
    

    Route::post('account/post/bio', 'UserBioController@store');

    Route::post('account/validate/handle', 'AccountController@validateHandle');
    Route::post('account/update/handle', 'AccountController@updateHandle');

    Route::post('/account/profile/upload','UserProfileController@store');

    Route::get('account/settings/security', 'UserSettingController@security')->name('account.security');
    // Change Password
    Route::post('account/security/changepassword', 'UserSettingController@changePassword');  

    // Phone Number
    Route::post('account/post/number', 'UserPhoneNumberController@store');
    Route::post('account/update/number', 'UserPhoneNumberController@update');

    Route::get('get/addresses', 'DeliveryAddressController@index');
    Route::post('/deliveryaddress/store', 'DeliveryAddressController@store');
    Route::post('/address/shipping/select', 'DeliveryAddressController@selectnew');

    // ticket index
    Route::get('/ticket', 'ParlorBookController@index');

    // review
    Route::post('parlor/rating', 'ParlorReviewController@store');
    Route::post('product/rating', 'ProductReviewController@store');

    // Orders
    Route::get('orders', 'UserOrderController@show');
    Route::get('orders/completed', 'UserOrderController@completed');
    Route::get('orders/upcoming', 'UserOrderController@upcoming');

    Route::get('get/ticket/{parlorTicket}/{bookedId}', 'ParlorTicketController@show');
});

//currency change
Route::get('settings/preferences', 'UserSettingController@currency')->name('setting.preferences');
Route::post('/switch-currency', 'UserSettingController@saveCurrency')->name('save.currency');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/permission-denied', 'Page\PageController@permissionDenied')->name('user');
    // Route::post('/create-page','UserController@admin');

    Route::get('/markAsRead',function(){
        auth()->user()->unreadNotifications->markAsRead();
        });

    // Notifications
    Route::get('/notifications/unread', 'UserNotificationController@unread');
    Route::get('/notifications/all', 'UserNotificationController@all');
    
    Route::prefix('/studio')->namespace('Page')->group(function () {
        

        Route::get('/dash', function(){
            return view('dasboard');
        });


        Route::get('/create', function (){
            return view('page.pages');
        })->name('studio.create');
        Route::post('create', 'PageController@createPage')->name('createStudio');
        

        Route::get('product/create', function(){
            return view('product.variant');
        })->name('product.create');
        Route::get('product/create/single', function(){
            return view('product.single');
        })->name('product.single');

        // Finance

        Route::get('finance', 'FinanceController@index')->name('studio.finance');

        Route::get('product/{product}/edit', 'ProductListController@edit')->name('product.edit');

        //Route::group(['middleware'=>['page']],function(){
        Route::get('/', 'AdminController@admin')->name('dashboard'); 
        //Route::get('/dashboardd','AdminController@dashboardd');
        Route::get('/product-list', [ProductListController::class, 'studioProducts'])->name('ProductList');
        Route::post( '/list/create', [ProductListController::class, 'addProduct'])->name('aproducts');

        // Product Thumb Upload
        Route::post('product/thumb/upload', 'ProductListController@thumbUpload');
        Route::post('product/details/upload', 'ProductListController@uploadDetails');
        Route::delete('product/delete/{productid}/{studio_id}', 'ProductListController@destroy');

        Route::get('/aproducts', [ProductListController::class, 'create'])->name('createList');
        Route::match(['get', 'post'], '/edit-products/{product}', 'ProductListController@editProduct');
        Route::match(['get', 'post'], '/product-details/{id}', 'ProductListController@productDetails');
        //edit attribute
        Route::post('/edit-attribute/{id}', 'ProductListController@editAttribute');
        //add admins to edit pages
        Route::match(['get', 'post'], '/add-pageadmins/{page}', 'PageUserController@addPageUser');
        //order
        Route::match(['get', 'post'], '/add-order', 'ProductListController@addOrder');

        // Studio Customization
        Route::get('customize', [StudioCustomize::class, 'show'])->name('studio.customize');
        Route::post('handle/validation', [StudioCustomize::class, 'validateHandle']);
        Route::post('handle/update', [StudioCustomize::class, 'updateHandle']);
        Route::post('name/update', [StudioCustomize::class, 'updateName']);
        Route::post('about/update', [StudioCustomize::class, 'updateAbout']);
        Route::post('profile/upload', [StudioProfileController::class, 'store']);
        Route::post('cover/upload', [StudioCoverController::class, 'store']);
        Route::post('color/update', [StudioCustomize::class, 'storeColor']);


        Route::get('reviews', [ReviewsController::class, 'index'])->name('studio.review');

        // studio data
        Route::get('get/dashboard/data', 'DashboardController@dashboard');

        // Analytics
        Route::get('analytics', 'AnalyticsController@show')->name('studio.analytics');

        Route::get('get/analytics/impression', 'AnalyticsController@impression');
        Route::get('get/analytics/orders', 'AnalyticsController@ordersByDays');

        Route::get('/product/analytics/{product}', 'ProductAnalytics@show')->name('product.analytics');
        Route::get('/product/analytics/{product}/impression', 'ProductAnalytics@impressions');

        // Reviews
        Route::get('/product/reviews/{product}', 'ProductReviews@show')->name('product.review');
        Route::get('/product/get/{product}/reviews', 'ProductReviews@reviews');


        // collection or category
        Route::post('/post/collection', 'PageCategoryController@addStudioCategory');
        Route::post('/collection/update/{pagecategory}', 'PageCategoryController@update');
        Route::post('/collection/status/update/{pagecategory}', 'PageCategoryController@updateStatus');
        Route::get('/get/collection', 'PageCategoryController@index');
        Route::delete('/collection/delete/{pagecategory}', 'PageCategoryController@destroy');



        // Orders & customers
        // Route::get('orders')

        //coupons
        Route::get('coupons',[CouponController::class,'coupon'])->name('studio.coupon');
        Route::post('update-coupon-status',[CouponController::class,'updateCoupon'])->name('updateCoupon');
        Route::match(['get', 'post'],'add-coupon',[CouponController::class,'addCoupon'])->name('addCoupon');
        Route::match(['get', 'post'],'edit-coupon/{coupon}',[CouponController::class,'editCoupon'])->name('editCoupon');
        Route::get('/get/coupons', [CouponController::class, 'index']);
        //orders and shipping
        Route::get('orders',[OrderController::class,'order'])->name('order');
        Route::get('order-details/{id}',[OrderController::class,'orderDetails'])->name('orderDetails');
        Route::match(['get', 'post'],'order-status-update',[OrderController::class,'orderStatus'])->name('orderStatus');

        //});
    });
});

// Public reviews
Route::get('/get/product/{product}/reviews', 'PublicReviewsController@product');
Route::get('/studio/get/collection/{studio}', 'ProductSectionController@index');

// Discover Creators
Route::get('/get/creators/discover', 'DiscoverCreatorController@index');
Route::get('/get/people/discover', 'DiscoverPeopleController@index');


Route::get('bag/items', 'BagController@count');
Route::post('bag/checkout', 'BagController@checkout');
Route::post('bag/verify', 'BagController@verify');

// ticket
Route::get('studio/ticket/{parlor}/upcoming', 'ParlorTicketController@upcoming');

// About COmpany
Route::get('/about', function(){
    return view("about");
})->name('about');
Route::get('/about/leadership/yeden-sherpa', function(){
    return view('leadership.yeden');
})->name('leadership.yeden');
Route::get('/about/leadership/laxmi-tamang', function(){
    return view('leadership.laxmi');
})->name('leadership.laxmi');

Route::get('/brand', function(){
    return view("brand");
})->name('brand');

// categories
Route::get('categories', 'CategoryController@indexSection');
Route::get('categories/{id}', 'CategoryController@indexCategories');
Route::get('categories/{id}/sub', 'CategoryController@indexSubcategories');

Route::get('/get/product/section/available', 'ProductSectionController@available');

// Stories
Route::post('post/story', 'StoryController@store');
Route::post('post/story/media', 'StoryController@media');
Route::get('get/stories', 'StoryController@index');
Route::get('get/stories/{id}', 'StoryController@indexbyid');
Route::post('post/story/seen', 'StoryController@viewed');


// associate
Route::post('post/associate', 'AssociateController@store');
Route::get('/associates', function(){
    return view('associate.program');
})->name('program.associate');

Route::get('/p/showoff', function(){
    return view('showoff.program');
})->name('program.showoff');

Route::get('/program/parlor', function(){
    return view('Parlor.host');
})->name('program.parlor');

// Parlor
Route::get('/studio/parlors', 'ParlorController@index')->name('studio.parlors');
Route::get('/studio/parlors/{parlor}', 'ParlorController@detail')->name('studio.parlors.show');
Route::get('/parlor/create', 'ParlorController@create')->name('createParlor');
Route::get('/parlor/{parlor}', 'ParlorController@show')->name('parlor.show');
Route::post('/parlor/cover/upload', 'ParlorController@uploadCover');
Route::post('/parlor/cover/details', 'ParlorController@uploadDetails');
Route::post('/parlor/add', 'ParlorController@store');

Route::post('/parlor/ticket/book', 'ParlorBookController@store');



Route::post('/ticket/create', 'ParlorTicketController@store');

// Parlors Explore
Route::get('/explore/parlors', 'ParlorExploreController@show')->name('explore.parlors');
Route::get('/explore/parlors/filter', 'ParlorExploreController@filtered');
Route::get('/get/parlor/section', 'ParlorSectionController@index');
Route::get('/get/parlor/section/available', 'ParlorSectionController@available');
Route::get('/get/parlor/search', 'ParlorExploreController@filter');
Route::get('/get/parlor/all', 'ParlorExploreController@allParlors');

Route::get('get/explore/trending', 'ExploreController@trending');

// reaction
Route::get('/get/reacts', 'ReactController@index');
Route::post('/post/reaction', 'ReactionsController@store');
Route::delete('/story/{id}', 'ReactionsController@destroy');

// story
Route::post('post/story', 'StoryController@store');
Route::get('get/stories', 'StoryController@index');
Route::get('get/stories/{id}', 'StoryController@indexbyid');
Route::post('post/story/seen', 'StoryController@viewed');

// Story Comments
Route::get('/get/comments/{id}', "StoryController@comments");
Route::post('/post/comment', "CommentController@store");

Route::delete('/delete/comment/{comment}', 'CommentController@destroy');

Route::get('/get/comments/reply/{id}', "CommentController@replies");
Route::post('/post/comment/reply', "CommentController@storeReply");

Route::post('/post/comment/react', "CommentReactController@store");
Route::delete('/delete/comment/react/{id}', "CommentReactController@destroy");

// WebPush
Route::post('/push','PushController@store');
Route::get('/push','PushController@push')->name('push');

// Followings
Route::get('following/', 'FollowingFeedController@getProductsFeed')->name('following.all');
Route::get('following/product', 'FollowingFeedController@Products')->name('following.product');
Route::get('following/parlor', 'FollowingFeedController@Parlors')->name('following.parlor');
Route::get('following/showoff', 'FollowingFeedController@Showoffs')->name('following.showoff');
Route::get('following/user/{user}', 'FollowingFeedController@user')->name('following.user');
Route::get('following/studio/{studio}', 'FollowingFeedController@studio')->name('following.studio');
Route::get('get/following/feed', 'FollowingFeedController@getFollowingFeed');

// follow Studio
Route::post('follow/studio', 'FollowController@follow');
Route::delete('/unfollow/studio/{pageId}', 'FollowController@unfollow');

Route::post('follow/user', 'FollowUserController@store');
Route::delete('/unfollow/user/{pageId}', 'FollowUserController@destroy');

// Bag
Route::post('bag/add/item', 'BagController@store');
Route::post('bag/update', 'BagController@update');
Route::delete('bag/remove/{item}', 'BagController@destroy');

// Temporary Routes

Route::get("/list/{product}",'Page\ProductListController@show')->name('list');

Route::post('/test-post', 'ImpressionController@store');

Route::get('/test', 'TestController@view');

Route::get('/explore', [ExploreController::class, 'index'])->name('ExploreIndex');

Route::get("/studio/open", function () {
    return view("studio.open");
})->name('OpenStudio');

Route::get('/clr', function(){
    return view("color");
});

Route::get('/formtest', function(){
    return view('formtest');
});

Route::get('/json', function(){
    return view('json');
});


// User Profile
Route::get('/@{userProfile}', 'UserProfileController@show')->name('user.show');
Route::get('/@{userProfile}/board', 'UserProfileController@board')->name('user.board');
Route::post('follow/user', 'FollowUserController@store');
Route::delete('unfollow/user/{id}', 'FollowUserController@destroy');

// create show off
Route::get('/create/showoff', 'ShowOffController@create')->name('showoff.create');
Route::get('/user/get/list', 'ShowOffController@getList')->name('showoff.list');
Route::post('/user/showoff/upload', 'ShowOffController@uploadImage')->name('showoff.upload');
Route::post('/user/showoff/save', 'ShowOffController@store');
Route::get('/showoff/{showOff}', 'ShowOffController@show')->name('showoff.show');

// Delete Showoff
Route::delete('showoff/delete/{showOff}', 'ShowOffController@destroy');

Route::post('/post/showoff/react', 'ShowOffReactionController@store');
Route::post('/showoff/unreact', 'ShowOffReactionController@destroy');

// showoff comments
Route::get('/get/s/comments/{id}', 'ShowOffCommentController@index');
Route::post('/post/s/comment', "ShowOffCommentController@store");
Route::get('/get/s/comments/reply/{id}', "ShowOffCommentController@replies");
Route::post('/post/s/comment/reply', "ShowOffCommentController@storeReply");
Route::delete('/delete/s/comment/{comment}', 'ShowOffCommentController@destroy');

// Associate
Route::post('post/associate', 'AssociateController@store');

Route::get('/associate', 'AssociateController@show')->name('associate');
Route::get('/a/{url}', 'AssociateVisitController@visit');

// MoodBoards

Route::post('/board/save', "BoardController@store");
Route::post('/showoff/save/board', 'SaveController@store');
Route::get('/get/boards', 'BoardController@index');
Route::post('unsave/board/item', 'SaveController@destroy');


Route::get('board/{board}', 'BoardController@show')->name('board.show');
Route::post('board/update/{board}', 'BoardController@update');
Route::delete('board/delete/{board}', 'BoardController@destroy');
// Litrary
Route::get('/library', 'LibraryController@index')->name('feed.library');
Route::get('/feed/history', 'HistoryController@index');
Route::get('/history', 'HistoryController@show')->name('feed.history');
Route::post('/feed/history/clear', 'HistoryController@clearHistory');

// studio Address
Route::get('studio/addresses', 'StudioAddressController@index');
Route::post('studio/address/update/{studioAddress}', 'StudioAddressController@update');
Route::post('studio/mobile/update/{studioAddress}', 'StudioAddressController@updateMobile');

// studio Payments
Route::get('studio/payments', 'StudioPaymentController@index');
Route::post('studio/payment', 'StudioPaymentController@store');
Route::delete('studio/payment/delete/{studioPayment}', 'StudioPaymentController@destroy');

// stories
Route::get('stories/discover', 'StoryController@discover');
Route::post('stories/seen', 'StoryController@seen');
Route::get('stories/following', 'StoryController@following');

// product lists
Route::get('products/{id}', [ProductListController::class, 'lists']);
Route::get('parlors/{id}', [ParlorController::class, 'lists']);
// Page //store
Route::get('/shops', 'ShopController@show')->name('feed.shop');

Route::get('/api/feed/products/{slug}', 'StudioController@products');
Route::get('/api/feed/parlors/{slug}', 'StudioController@parlors');
Route::get('/api/feed/reviews/{slug}', 'StudioController@reviews');

Route::get('/api/feed/shops', 'ShopController@index');

// Menu
Route::get('/get/menu', 'MenuController@index');



Route::get('/{slug}', 'StudioController@show')->name('studio');