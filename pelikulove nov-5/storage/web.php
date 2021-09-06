<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function () {
     //Route::get('/', 'WelcomeController@login')->name('login');
     Route::get('/', 'WelcomeController@welcome')->name('welcome');


    //Route::get('/', ['as' => 'public.home',   'uses' => 'UserController@index']);
  
});

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['web', 'activity', 'checkblocked']], function () {
    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => 'Auth\ActivateController@initial']);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => 'Auth\SocialController@getSocialRedirect']);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => 'Auth\SocialController@getSocialHandle']);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => 'RestoreUserController@userReActivate']);
    
    // Privacy page
    
    Route::get('/privacy', 'PageController@privacy');
    Route::get('/rody-vera-scripting-course-promo1', 'PageController@promo1');
    Route::get('/rody-vera-scripting-course-promo2', 'PageController@promo2');
    
     
	Route::post('/dragonpay/postback','DragonPayController@postback')->name('dragonpay.postback');
	Route::get('/dragonpay/return','DragonPayController@return')->name('dragonpay.return');
	
	
    Route::post('/webhook/paypal/{order?}/{env?}', [
   		'name' => 'PayPal Express IPN',
    	'as' => 'webhook.paypal.ipn',
    	'uses' => 'PayPalController@webhook',
	]);
	
    Route::get('/course/{course_id}/show2', 'CourseController@show2')->name('course.show2');
    Route::get('/course/{course_id}/show', 'CourseController@show')->name('course.show');
    
    // Vod
	Route::get('/blackbox', 'VodController@index')->name('vod.index');      
    Route::get('/blackbox/{category_id}', 'VodController@showCategory')->name('vod.showCategory');    
    Route::get('/blackbox/{vod_id}/watch/private', 'VodController@showPrivate')->name('vod.showPrivate'); 
            
    // VOD
    Route::get('/blackbox/{vod_id}/watch', 'VodController@show')->name('vod.show'); 

    // Vod Redirector
    Route::get('/vod/{vod_id}/watch', 'VodController@redirector');
    Route::get('/vod', 'VodController@redirectorHome'); 
    Route::get('/vod/{category_id}', 'VodController@redirectorCategory'); 
    Route::get('/vod/{vod_id}/watch/private', 'VodController@redirectorPrivate');    
    
    // Code Redemption    
	Route::get('/redeem-a-code', 'RedemptionController@create')->name('redemption.create');
    Route::post('/redeem-a-code/store', 'RedemptionController@store')->name('redemption.store');
    
    // Homepage Route - Redirect based on user role is in controller.   
    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep', 'checkblocked']], function () {

    // Homepage Route - Redirect based on user role is in controller.    
    Route::get('/home2', ['as' => 'public.home2',   'uses' => 'UserController@index2']);

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@show',
    ]);
    
   
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        'ProfilesController', [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserAccount',
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateUserPassword',
    ]);
    Route::post('profile/{username}/updateNotifSettings', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@updateNotifSettings',
    ]);
    
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => 'ProfilesController@deleteUserAccount',
    ]);
    Route::get('profile/{username}/edit/{focus}', [
        'uses' => 'ProfilesController@edit',
    ]); 

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => 'ProfilesController@userProfileAvatar',
    ]);    

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => 'ProfilesController@upload']);
    
    Route::post('/comment/store', ['as' => 'comment.store', 'uses' => 'CommentController@store']);
    Route::post('/comment/store2', ['as' => 'comment.store2', 'uses' => 'CommentController@store2']);
    
    Route::get('/comment/show', ['as' => 'comment.show', 'uses' => 'CommentController@show']);
    Route::get('/comment/show2', ['as' => 'comment.show2', 'uses' => 'CommentController@show2']);
    Route::get('/comment/showAll', ['as' => 'comment.showAll', 'uses' => 'CommentController@showAll']);
      
    Route::get('/courses/','CourseController@index')->name('courses');
    Route::get('/course/{course_id}/enroll','PaymentController@form')->name('course.enroll');
	Route::get('/course/{course_id}/enroll2','PaymentController@form2')->name('course.enroll2');
	Route::get('/course/{course_id}/stats','CourseController@stats')->name('course.stats');
	  
    Route::get('/lesson/{lesson_id}/topic/{topic_id}/show', 'LessonController@show')->name('lesson.show');
    Route::get('/lesson/{lesson_id}/topic/{topic_id}/show2', 'LessonController@show2')->name('lesson.show2');
      
     
    // Mentors
    Route::get('/mentor/{mentor_id}/show', 'InstructorController@show')->name('mentor.show');
   
     
    // Payment
    Route::post('/payment/process','PaymentController@process')->name('payment.process');
     
    // DragonPay
    Route::get('/checkout/payment/{txnid}/dragonpay','DragonPayController@checkout')->name('checkout.payment.dragonpay');
    
    //Route::post('/process/payment/{txnid}','DragonPayController@process')->name('checkout.process');
    Route::post('/process/payment','DragonPayController@process')->name('checkout.process');
	
	Route::get('/payment/status/{order_id}','DragonPayController@status')->name('payment.status');

	// PayPal
    Route::get('/paypal/{course_id}/{order?}', [
    		'name' => 'PayPal Express Checkout',
    		'as' => 'order.paypal',
    		'uses' => 'PaymentController@form',
	]);		
	
	Route::get('/ajax/check/{code}/', 'PaymentController@ajaxCheckCode');   
	
	//PayPal Express Checkout
	Route::get('/checkout/payment/{order_id}/paypal', [ 'as' => 'checkout.payment.paypal', 'uses' => 'PayPalController@checkout']);

	Route::get('/paypal/checkout/{order_id}/completed', [
   		'name' => 'PayPal Express Checkout',
    	'as' => 'paypal.checkout.completed',
    	'uses' => 'PayPalController@completed',
	]);

	Route::get('/paypal/checkout/{order_id}/cancelled', [
   		'name' => 'PayPal Express Checkout',
    	'as' => 'paypal.checkout.cancelled',
    	'uses' => 'PayPalController@cancelled',
    ]);
            
    // VOD
    Route::get('/blackbox/redirector/{vod_id}', 'VodController@redirector')->name('vod.redirector'); 
    Route::get('/vod/redirector/{vod_id}', 'VodController@redirector')->name('vod.redirector'); 
    
    // VOD Payment
    Route::get('/vod/{vod_id}/purchase','VodPaymentController@form')->name('vod.purchase');
    Route::get('vod/paypal/{vod_id}/{order?}', [
    		'name' => 'PayPal Express Checkout',
    		'as' => 'vod-order.paypal',
    		'uses' => 'VodPaymentController@form',
	]);	
    Route::post('/vod/process','VodPaymentController@process')->name('vod.process');

	// Routing of Enrollees
    Route::get('/enrollees','EnrolleeController@index')->name('enrollees');
	Route::get('/enrollees/{course_id}','EnrolleeController@show')->name('enrollees.show');
	
	// Submissions
	Route::get('/submissions/{course_id}','SubmissionController@index')->name('submissions');
	Route::get('/submissions/{course_id}/show/{lesson_id}','SubmissionController@showLessons')->name('submissions.lessons');
	Route::get('/submissions/create/{lesson_id}','SubmissionController@create')->name('submissions.create');
	Route::get('/submissions/show/{lesson_id}','SubmissionController@show')->name('submissions.show');
	Route::get('/submission/{id}/show/','SubmissionController@show2')->name('submission.show');
    Route::get('/submission/{id}/edit','SubmissionController@edit')->name('submission.edit');
	Route::post('/submission/update','SubmissionController@update')->name('submission.update');
	Route::post('/submission/store','SubmissionController@store')->name('submission.store');
	Route::get('/submission/{uuid}/view', 'SubmissionController@view')->name('submission.view');

    // Code Redemption
	Route::get('/redeem-a-code/invite', 'RedemptionController@invite')->name('redemption.invite');
	Route::post('/redeem-a-code/invite/skip', 'RedemptionController@inviteSkip')->name('redemption.inviteSkip');
    Route::post('/redeem-a-code/invite/store', 'RedemptionController@inviteStore')->name('redemption.inviteStore');
      
    // Notification 
    Route::get('notifications/mark-all-as-read', 'DatabaseNotificationController@markAsReadAll')->name('notifications.readall');
    Route::get('notifications', 'DatabaseNotificationController@index')->name('notifications.index');
    Route::get('notifications/getNotifications', 'DatabaseNotificationController@getNotifications')->name('notifications.getNotifications');
    Route::post('get-notif-details', 'DatabaseNotificationController@getNotifDetails')->name('getNotifDetails');

    // Analytics
    Route::post('/analytics/vod/end', 'AnalyticsController@logVodVideoEnd')->name('analytics.vod.end');
});

Route::get('storage/{id}/{file}', 'SubmissionController2@getSubStoragePath');
Route::get('getData1', 'getData1@TestsController');

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin|pelikulove',  'activity', 'twostep', 'checkblocked']], function () {
    Route::resource('/users/deleted', 'SoftDeletesController', [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', 'UsersManagementController', [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', 'UsersManagementController@search')->name('search-users');

    Route::resource('themes', 'ThemesManagementController', [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    // Services Management
    Route::resource('services', 'ServicesManagementController', [
        'names' => [
            'index'   => 'services',
        ],
    ]);

    // Payment Method Management
    Route::resource('payment-methods', 'PaymentMethodsManagementController', [
        'names' => [
            'index'   => 'payment-methods',
        ],
    ]);
    Route::post('/payment-methods/upload/{id}', ['as' => 'payment-methods.upload', 'uses' => 'PaymentMethodsManagementController@upload']);

    // Courses Admin Management
    Route::resource('courses-admin', 'CoursesAdminManagementController', [
        'names' => [
            'index'   => 'courses-admin',
        ],
    ]);

    // Promo Codes Admin Management
    Route::resource('promo-codes', 'PromoCodesManagementController', [
        'names' => [
            'index'   => 'promo-codes',
            'create'   => 'promocodes.create',
        ],
    ]);
    
    Route::get('/promo-codes/promocode/{id}','PromoCodesManagementController@showPromoCode');
    Route::get('/promo-codes/giftcode/{id}','PromoCodesManagementController@showGiftCode');
    Route::post('/promo-codes/code-gen','PromoCodesManagementController@codeGen')->name('promocodes.code-gen');
    Route::post('/promo-codes/storeTimePromo','PromoCodesManagementController@storeTimePromo')->name('promocodes.storeTimePromo');
    Route::post('/promo-codes/storeGift','PromoCodesManagementController@storeGift')->name('promocodes.storeGift');
    Route::post('/promo-codes/storeTimeVod','PromoCodesManagementController@storeTimeVod')->name('promocodes.storeTimeVod');
    Route::post('/promo-codes/sendTimeVod','PromoCodesManagementController@sendTimeVod')->name('promocodes.sendTimeVod');
    Route::get('/promo-codes/{promocode_id}/editPromoCode','PromoCodesManagementController@editPromoCode')->name('promocodes.editPromoCode');
    Route::post('/promo-codes/{promocode_id}/updatePromoCode','PromoCodesManagementController@updatePromoCode')->name('promocodes.updatePromoCode');

    // Vod Admin
    Route::get('/vods-admin','VodAdminManagementController@index')->name('vodsmanagement.vods-admin');
    Route::get('/vods-admin/slideshow/edit','VodAdminManagementController@editSlideshow')->name('vodsmanagement.edit-slideshow');
    Route::get('/vods-admin/category/create','VodAdminManagementController@createCategory')->name('vodsmanagement.createCategory');
    Route::post('/vods-admin/category/store','VodAdminManagementController@storeCategory')->name('vodsmanagement.storeCategory');
    Route::get('/vods-admin/category/edit/{category_id}','VodAdminManagementController@editCategory')->name('vodsmanagement.editCategory');
    Route::post('/vods-admin/category/update/{category_id}','VodAdminManagementController@updateCategory')->name('vodsmanagement.updateCategory');
    Route::get('/vods-admin/category/rearrange','VodAdminManagementController@rearrangeCategory')->name('vodsmanagement.rearrangeCategory');
    Route::post('/vods-admin/category/store-rearranged','VodAdminManagementController@storeRearrangedCategory')->name('vodsmanagement.storeRearrangedCategory');
    Route::get('/vods-admin/category/remove/{category_id}','VodAdminManagementController@removeCategory')->name('vodsmanagement.removeCategory');
    Route::get('/vods-admin/category/{category_id}','VodAdminManagementController@showCategory')->name('vodsmanagement.showCategory');
    Route::get('/vods-admin/category/{category_id}/vod/rearrange','VodAdminManagementController@rearrangeCategoryVods')->name('vodsmanagement.rearrangeCategoryVods');
    Route::post('/vods-admin/category/{category_id}/vod/store-rearranged','VodAdminManagementController@storeRearrangedCategoryVods')->name('vodsmanagement.storeRearrangedCategoryVods');
    Route::get('/vods-admin/category/{category_id}/vod/create','VodAdminManagementController@createVod')->name('vodsmanagement.createVod');
    Route::post('/vods-admin/category/{category_id}/vod/store','VodAdminManagementController@storeVod')->name('vodsmanagement.storeVod');
    Route::get('/vods-admin/category/{category_id}/vod/edit/{vod_id}','VodAdminManagementController@editVod')->name('vodsmanagement.editVod');
    Route::post('/vods-admin/category/{category_id}/vod/update/{vod_id}','VodAdminManagementController@updateVod')->name('vodsmanagement.updateVod');
    Route::delete('/vods-admin/category/{category_id}/vod/remove/{vod_id}','VodAdminManagementController@removeVod')->name('vodsmanagement.removeVod');
    
    // Temp Vod    
	// Route::get('/vod', 'VodController@index')->name('vod.index');      
	// Route::get('/vod/{category_id}', 'VodController@showCategory')->name('vod.showCategory');   
    // Route::get('/vod/{vod_id}/watch', 'VodController@show')->name('vod.show');   

    Route::get('/courses-admin/{course_id}/lesson/{lesson_id}', 'CoursesAdminManagementController@showLesson');
    Route::get('/courses-admin/{course_id}/create-lesson', 'CoursesAdminManagementController@createLesson');
    Route::post('/courses-admin/{course_id}/store-lesson', 'CoursesAdminManagementController@storeLesson');
    Route::get('/courses-admin/{course_id}/lesson/{lesson_id}/create-topic', 'CoursesAdminManagementController@createTopic');
    Route::get('/courses-admin/{course_id}/lesson/{lesson_id}/store-topic', 'CoursesAdminManagementController@storeTopic');
    
    // Accounting Sales
    Route::get('/accounting/','AccountingController@index')->name('accounting.index');
    Route::get('/accounting/{year}','AccountingController@yearly')->name('accounting.yearly');
	Route::get('/accounting/{year}/{month}','AccountingController@monthly')->name('accounting.monthly');

	// Courses
	Route::get('/course/create','CourseController@create')->name('course.create');
	Route::get('/course/{id}/edit','CourseController@edit')->name('course.edit');
	Route::post('/course/update','CourseController@update')->name('course.update');
	Route::post('/course/store','CourseController@store')->name('course.store');
	
	// Instructors
	Route::get('/mentor/create','InstructorController@create')->name('instructor.create');
	Route::get('/mentor/{id}/edit','InstructorController@edit')->name('instructor.edit');
	Route::post('/mentor/update','InstructorController@update')->name('instructor.update');
	Route::post('/mentor/store','InstructorController@store')->name('instructor.store');
	
	
	// Routing of Orders
    Route::get('/orders','OrderController@index')->name('orders.index');
    Route::get('/order/create/{order?}','OrderController@create')->name('order.create');
	Route::get('/order/{id}/edit','OrderController@edit')->name('order.edit');
	Route::post('/order/update','OrderController@update')->name('order.update');
	Route::post('/order/store','OrderController@store')->name('order.store');
    Route::get('/order/{id}/transactions/','OrderController@transact')->name('order.transaction');

    // Analytics
    Route::get('/analytics/vod','AnalyticsController@index')->name('analytics.vod');
    Route::get('/analytics/vod/show-all-videos','AnalyticsController@showAllVodStats')->name('analytics.vod.showAllVodStats');
    Route::get('/analytics/vod/show-all-users','AnalyticsController@showAllUserStats')->name('analytics.vod.showAllUserStats');
    Route::post('/analytics/vod','AnalyticsController@index')->name('analytics.vod');
    Route::post('/analytics/vod/show-all-videos','AnalyticsController@showAllVodStats')->name('analytics.vod.showAllVodStats');
    Route::post('/analytics/vod/show-all-users','AnalyticsController@showAllUserStats')->name('analytics.vod.showAllUserStats');
	
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'AdminDetailsController@listRoutes');
    Route::get('active-users', 'AdminDetailsController@activeUsers');

    // Tests
    Route::get('/test01','TestsController@test01')->name('tests.test01');	
    Route::get('/test02','TestsController@test02')->name('tests.test02');	
    Route::get('/test03','TestsController@test03')->name('tests.test03');	

    // SEO
    Route::get('/sitemap-generate', 'SEOController@generate')->name('seo.gen');
});


Route::redirect('/php', '/phpinfo', 301);
