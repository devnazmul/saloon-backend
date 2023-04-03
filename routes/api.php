<?php

use App\Http\Controllers\AffiliationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutomobilesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\client\ClientBasicController;
use App\Http\Controllers\client\ClientBookingController;
use App\Http\Controllers\client\ClientCouponController;
use App\Http\Controllers\client\ClientJobController;
use App\Http\Controllers\client\ClientPreBookingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailTemplateWrapperController;
use App\Http\Controllers\FuelStationController;
use App\Http\Controllers\GarageAffiliationController;
use App\Http\Controllers\GarageGalleryController;
use App\Http\Controllers\GaragePackageController;
use App\Http\Controllers\GarageRuleController;
use App\Http\Controllers\GaragesController;
use App\Http\Controllers\GarageServicePriceController;
use App\Http\Controllers\GarageTimesController;
use App\Http\Controllers\JobBidController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserManagementController;
use App\Models\GaragePackage;
use App\Models\JobBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/v1.0/register', [AuthController::class, "register"]);
Route::post('/v1.0/login', [AuthController::class, "login"]);
Route::post('/forgetpassword', [AuthController::class, "storeToken"]);
Route::post('/resend-email-verify-mail', [AuthController::class, "resendEmailVerifyToken"]);
Route::patch('/forgetpassword/reset/{token}', [AuthController::class, "changePasswordByToken"]);
Route::post('/auth/check/email', [AuthController::class, "checkEmail"]);






Route::post('/v1.0/auth/user-register-with-garage', [AuthController::class, "registerUserWithGarageClient"]);
Route::get('/v1.0/automobile-categories/get/all', [AutomobilesController::class, "getAllAutomobileCategories"]);

Route::get('/v1.0/automobile-makes-all/{categoryId}', [AutomobilesController::class, "getAutomobileMakesAll"]);
Route::get('/v2.0/automobile-makes-all/{categoryId}', [AutomobilesController::class, "getAutomobileMakesAllV2"]);

Route::get('/v1.0/automobile-models-all', [AutomobilesController::class, "getAutomobileModelsAll"]);



Route::get('/v1.0/services-all/{categoryId}', [ServiceController::class, "getAllServicesByCategoryId"]);
Route::get('/v2.0/services-all/{categoryId}', [ServiceController::class, "getAllServicesByCategoryIdV2"]);

Route::get('/v1.0/sub-services-all', [ServiceController::class, "getSubServicesAll"]);


Route::get('/v1.0/available-countries', [GaragesController::class, "getAvailableCountries"]);

Route::get('/v1.0/available-cities/{country_code}', [GaragesController::class, "getAvailableCities"]);


Route::get('/v1.0/fuel-station/{perPage}', [FuelStationController::class, "getFuelStations"]);



// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
// Protected Routes
// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
Route::middleware(['auth:api'])->group(function () {
    Route::get('/v1.0/user', [AuthController::class, "getUser"]);
    Route::patch('/auth/changepassword', [AuthController::class, "changePassword"]);

    Route::put('/v1.0/update-user-info', [AuthController::class, "updateUserInfo"]);
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// user management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// ********************************************
// user management section --user
// ********************************************
Route::post('/v1.0/users', [UserManagementController::class, "createUser"]);
Route::put('/v1.0/users', [UserManagementController::class, "updateUser"]);
Route::get('/v1.0/users/{perPage}', [UserManagementController::class, "getUsers"]);

Route::delete('/v1.0/users/{id}', [UserManagementController::class, "deleteUserById"]);

// ********************************************
// user management section --role
// ********************************************
Route::get('/v1.0/initial-role-permissions', [RolesController::class, "getInitialRolePermissions"]);
Route::post('/v1.0/roles', [RolesController::class, "createRole"]);
Route::put('/v1.0/roles', [RolesController::class, "updateRole"]);
Route::get('/v1.0/roles/{perPage}', [RolesController::class, "getRoles"]);
Route::get('/v1.0/roles/get/all', [RolesController::class, "getRolesAll"]);
Route::get('/v1.0/roles/get-by-id/{id}', [RolesController::class, "getRoleById"]);
Route::delete('/v1.0/roles/{id}', [RolesController::class, "deleteRoleById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end user management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// garage management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/auth/register-with-garage', [GaragesController::class, "registerUserWithGarage"]);
Route::put('/v1.0/garages', [GaragesController::class, "updateGarage"]);
Route::get('/v1.0/garages/{perPage}', [GaragesController::class, "getGarages"]);
Route::get('/v1.0/garages/single/{id}', [GaragesController::class, "getGarageById"]);
Route::delete('/v1.0/garages/{id}', [GaragesController::class, "deleteGarageById"]);


// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end garage management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%




// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// automobile management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// ********************************************
// automobile management section --category
// ********************************************
Route::post('/v1.0/automobile-categories', [AutomobilesController::class, "createAutomobileCategory"]);
Route::put('/v1.0/automobile-categories', [AutomobilesController::class, "updateAutomobileCategory"]);
Route::get('/v1.0/automobile-categories/{perPage}', [AutomobilesController::class, "getAutomobileCategories"]);

Route::get('/v1.0/automobile-categories/single/get/{id}', [AutomobilesController::class, "getAutomobileCategoryById"]);
Route::delete('/v1.0/automobile-categories/{id}', [AutomobilesController::class, "deleteAutomobileCategoryById"]);


// ********************************************
// automobile management section --make
// ********************************************
Route::post('/v1.0/automobile-makes', [AutomobilesController::class, "createAutomobileMake"]);
Route::put('/v1.0/automobile-makes', [AutomobilesController::class, "updateAutomobileMake"]);
Route::get('/v1.0/automobile-makes/{categoryId}/{perPage}', [AutomobilesController::class, "getAutomobileMakes"]);
Route::get('/v1.0/automobile-makes/single/get/{id}', [AutomobilesController::class, "getAutomobileMakeById"]);
Route::delete('/v1.0/automobile-makes/{id}', [AutomobilesController::class, "deleteAutomobileMakeById"]);




// ********************************************
// automobile management section --model
// ********************************************
Route::post('/v1.0/automobile-models', [AutomobilesController::class, "createAutomobileModel"]);
Route::put('/v1.0/automobile-models', [AutomobilesController::class, "updateAutomobileModel"]);
Route::get('/v1.0/automobile-models/{makeId}/{perPage}', [AutomobilesController::class, "getAutomobileModel"]);
Route::get('/v1.0/automobile-models/single/get/{id}', [AutomobilesController::class, "getAutomobileModelById"]);
Route::delete('/v1.0/automobile-models/{id}', [AutomobilesController::class, "deleteAutomobileModelById"]);




// ********************************************
// automobile management section --model variant
// ********************************************
Route::post('/v1.0/automobile-model-variants', [AutomobilesController::class, "createAutomobileModelVariant"]);
Route::put('/v1.0/automobile-model-variants', [AutomobilesController::class, "updateAutomobileModelVariant"]);
Route::get('/v1.0/automobile-model-variants/{modelId}/{perPage}', [AutomobilesController::class, "getAutomobileModelVariant"]);
Route::get('/v1.0/automobile-model-variants/single/get/{id}', [AutomobilesController::class, "getAutomobileModelVariantById"]);
Route::delete('/v1.0/automobile-model-variants/{id}', [AutomobilesController::class, "deleteAutomobileModelVariantById"]);


// ********************************************
// automobile management section --fuel types
// ********************************************
Route::post('/v1.0/automobile-fuel-types', [AutomobilesController::class, "createAutomobileFuelType"]);
Route::put('/v1.0/automobile-fuel-types', [AutomobilesController::class, "updateAutomobileFuelType"]);
Route::get('/v1.0/automobile-fuel-types/{modelVariantId}/{perPage}', [AutomobilesController::class, "getAutomobileFuelType"]);
Route::get('/v1.0/automobile-fuel-types/single/get/{id}', [AutomobilesController::class, "getAutomobileFuelTypeById"]);
Route::delete('/v1.0/automobile-fuel-types/{id}', [AutomobilesController::class, "deleteAutomobileFuelTypeById"]);



// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end automobile management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// service management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// ********************************************
// service management section --service
// ********************************************
Route::post('/v1.0/services', [ServiceController::class, "createService"]);
Route::put('/v1.0/services', [ServiceController::class, "updateService"]);
Route::get('/v1.0/services/{perPage}', [ServiceController::class, "getServices"]);
Route::delete('/v1.0/services/{id}', [ServiceController::class, "deleteServiceById"]);
Route::get('/v1.0/services/single/get/{id}', [ServiceController::class, "getServiceById"]);

// ********************************************
// service management section --sub service
// ********************************************
Route::post('/v1.0/sub-services', [ServiceController::class, "createSubService"]);
Route::put('/v1.0/sub-services', [ServiceController::class, "updateSubService"]);
Route::get('/v1.0/sub-services/{serviceId}/{perPage}', [ServiceController::class, "getSubServicesByServiceId"]);
Route::get('/v1.0/sub-services-all/{serviceId}', [ServiceController::class, "getAllSubServicesByServiceId"]);
Route::delete('/v1.0/sub-services/{id}', [ServiceController::class, "deleteSubServiceById"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end service management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// fuel station management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/fuel-station', [FuelStationController::class, "createFuelStation"]);
Route::put('/v1.0/fuel-station', [FuelStationController::class, "updateFuelStation"]);

Route::delete('/v1.0/fuel-station/{id}', [FuelStationController::class, "deleteFuelStationById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// fuel station management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// template management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// ********************************************
// template management section --wrapper
// ********************************************
Route::put('/v1.0/email-template-wrappers', [EmailTemplateWrapperController::class, "updateEmailTemplateWrapper"]);
Route::get('/v1.0/email-template-wrappers/{perPage}', [EmailTemplateWrapperController::class, "getEmailTemplateWrappers"]);
Route::get('/v1.0/email-template-wrappers/single/{id}', [EmailTemplateWrapperController::class, "getEmailTemplateWrapperById"]);




// ********************************************
// template management section
// ********************************************
Route::post('/v1.0/email-templates', [EmailTemplateController::class, "createEmailTemplate"]);
Route::put('/v1.0/email-templates', [EmailTemplateController::class, "updateEmailTemplate"]);
Route::get('/v1.0/email-templates/{perPage}', [EmailTemplateController::class, "getEmailTemplates"]);
Route::get('/v1.0/email-templates/single/{id}', [EmailTemplateController::class, "getEmailTemplateById"]);
Route::get('/v1.0/email-template-types', [EmailTemplateController::class, "getEmailTemplateTypes"]);
 Route::delete('/v1.0/email-templates/{id}', [EmailTemplateController::class, "deleteEmailTemplateById"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// template management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// Garage Time Management
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::patch('/v1.0/garage-times', [GarageTimesController::class, "updateGarageTimes"]);
Route::get('/v1.0/garage-times/{garage_id}', [GarageTimesController::class, "getGarageTimes"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end Garage Time Management
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// Garage Rule Management
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::patch('/v1.0/garage-rules', [GarageRuleController::class, "updateGarageRules"]);
Route::get('/v1.0/garage-rules/{garage_id}', [GarageRuleController::class, "getGarageRules"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end Garage Rule Management
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// garage gallery management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/garage-galleries/{garage_id}', [GarageGalleryController::class, "createGarageGallery"]);
Route::get('/v1.0/garage-galleries/{garage_id}', [GarageGalleryController::class, "getGarageGalleries"]);
Route::delete('/v1.0/garage-galleries/{garage_id}/{id}', [GarageGalleryController::class, "deleteGarageGalleryById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// end garage gallery management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%




// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// payment type management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/payment-types', [PaymentTypeController::class, "createPaymentType"]);
Route::put('/v1.0/payment-types', [PaymentTypeController::class, "updatePaymentType"]);
Route::get('/v1.0/payment-types/{perPage}', [PaymentTypeController::class, "getPaymentTypes"]);
Route::delete('/v1.0/payment-types/{id}', [PaymentTypeController::class, "deletePaymentTypeById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// payment type management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%






// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// booking management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::put('/v1.0/bookings', [BookingController::class, "updateBooking"]);
Route::put('/v1.0/bookings/confirm', [BookingController::class, "confirmBooking"]);
Route::put('/v1.0/bookings/change-status', [BookingController::class, "changeBookingStatus"]);

Route::get('/v1.0/bookings/{garage_id}/{perPage}', [BookingController::class, "getBookings"]);

Route::get('/v1.0/bookings/single/{garage_id}/{id}', [BookingController::class, "getBookingById"]);
Route::delete('/v1.0/bookings/{garage_id}/{id}', [BookingController::class, "deleteBookingById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// booking management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// job bid management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::get('/v1.0/pre-bookings/{garage_id}/{perPage}', [JobBidController::class, "getPreBookings"]);
Route::get('/v1.0/pre-bookings/single/{garage_id}/{id}', [JobBidController::class, "getPreBookingById"]);

Route::post('/v1.0/job-bids', [JobBidController::class, "createJobBid"]);
Route::put('/v1.0/job-bids', [JobBidController::class, "updateJobBid"]);

Route::get('/v1.0/job-bids/{garage_id}/{perPage}', [JobBidController::class, "getJobBids"]);
Route::get('/v1.0/job-bids/single/{garage_id}/{id}', [JobBidController::class, "getJobBidById"]);

Route::delete('/v1.0/job-bids/{garage_id}/{id}', [JobBidController::class, "deleteJobBidById"]);








Route::delete('/v1.0/bookings/{garage_id}/{id}', [BookingController::class, "deleteBookingById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// job bid management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// job management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::patch('/v1.0/jobs/booking-to-job', [JobController::class, "bookingToJob"]);
Route::put('/v1.0/jobs', [JobController::class, "updateJob"]);
Route::put('/v1.0/jobs/change-status', [JobController::class, "changeJobStatus"]);


Route::get('/v1.0/jobs/{garage_id}/{perPage}', [JobController::class, "getJobs"]);
Route::get('/v1.0/jobs/single/{garage_id}/{id}', [JobController::class, "getJobById"]);
Route::delete('/v1.0/jobs/{garage_id}/{id}', [JobController::class, "deleteJobById"]);


Route::post('/v1.0/jobs/payment', [JobController::class, "addPayment"]);
Route::delete('/v1.0/jobs/payment/{garage_id}/{id}', [JobController::class, "deletePaymentById"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// job management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%





// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// coupon management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/coupons', [CouponController::class, "createCoupon"]);
Route::put('/v1.0/coupons', [CouponController::class, "updateCoupon"]);
Route::get('/v1.0/coupons/{garage_id}/{perPage}', [CouponController::class, "getCoupons"]);
Route::get('/v1.0/coupons/single/{garage_id}/{id}', [CouponController::class, "getCouponById"]);
Route::delete('/v1.0/coupons/{garage_id}/{id}', [CouponController::class, "deleteCouponById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// coupon management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%




// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// affiliation management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/affiliations-logo', [AffiliationController::class, "createAffiliationLogo"]);


Route::post('/v1.0/affiliations', [AffiliationController::class, "createAffiliation"]);
Route::put('/v1.0/affiliations', [AffiliationController::class, "updateAffiliation"]);
Route::get('/v1.0/affiliations/{perPage}', [AffiliationController::class, "getAffiliations"]);
Route::delete('/v1.0/affiliations/{id}', [AffiliationController::class, "deleteAffiliationById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// affiliation management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// affiliation management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::post('/v1.0/garage-affiliations', [GarageAffiliationController::class, "createGarageAffiliation"]);
Route::put('/v1.0/garage-affiliations', [GarageAffiliationController::class, "updateGarageAffiliation"]);
Route::get('/v1.0/garage-affiliations/{perPage}', [GarageAffiliationController::class, "getGarageAffiliations"]);
Route::get('/v1.0/garage-affiliations/{garage_id}/{perPage}', [GarageAffiliationController::class, "getGarageAffiliationsByGarageId"]);
Route::delete('/v1.0/garage-affiliations/{id}', [GarageAffiliationController::class, "deleteGarageAffiliationById"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// affiliation management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// price management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::post('/v1.0/garage-sub-service-prices', [GarageServicePriceController::class, "createGarageSubServicePrice"]);

Route::put('/v1.0/garage-service-prices', [GarageServicePriceController::class, "updateGarageSubServicePrice"]);



Route::delete('/v1.0/garage-service-prices/{id}', [GarageServicePriceController::class, "deleteGarageSubServicePriceById"]);

Route::delete('/v1.0/garage-service-prices/by-garage-sub-service/{id}', [GarageServicePriceController::class, "deleteGarageSubServicePriceByGarageSubServiceId"]);


// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// price management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// package management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::post('/v1.0/garage-packages', [GaragePackageController::class, "createGaragePackage"]);

Route::put('/v1.0/garage-packages', [GaragePackageController::class, "updateGaragePackage"]);

Route::get('/v1.0/garage-packages/{garage_id}', [GaragePackageController::class, "getGaragePackages"]);

Route::get('/v1.0/garage-packages/single/{garage_id}/{id}', [GaragePackageController::class, "getGaragePackageById"]);

Route::delete('/v1.0/garage-packages/single/{garage_id}/{id}', [GaragePackageController::class, "deleteGaragePackageById"]);


// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// package management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



});

// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
// end admin routes
// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^




























































// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
// client routes
// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^


Route::get('/v1.0/client/garages/{perPage}', [ClientBasicController::class, "getGaragesClient"]);

Route::get('/v1.0/client/garages/single/{id}', [ClientBasicController::class, "getGarageByIdClient"]);

Route::get('/v1.0/client/garages/service-model-details/{id}', [ClientBasicController::class, "getGarageServiceModelDetailsByIdClient"]);


// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^
// client protected routes
// !!!!!!!@@@@@@@@@@@@$$$$$$$$$$$$%%%%%%%%%%%%%%%%^^^^^^^^^^

Route::middleware(['auth:api'])->group(function () {

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// booking management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
Route::post('/v1.0/client/bookings', [ClientBookingController::class, "createBookingClient"]);
Route::put('/v1.0/client/bookings', [ClientBookingController::class, "updateBookingClient"]);
Route::patch('/v1.0/client/bookings/change-status', [ClientBookingController::class, "changeBookingStatusClient"]);
Route::get('/v1.0/client/bookings/{perPage}', [ClientBookingController::class, "getBookingsClient"]);
Route::get('/v1.0/client/bookings/single/{id}', [ClientBookingController::class, "getBookingByIdClient"]);
Route::delete('/v1.0/client/bookings/{id}', [ClientBookingController::class, "deleteBookingByIdClient"]);
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// booking management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// booking management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::get('/v1.0/client/jobs/{perPage}', [ClientJobController::class, "getJobsClient"]);
Route::get('/v1.0/client/jobs/single/{id}', [ClientJobController::class, "getJobByIdClient"]);

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// booking management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%


// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// coupon management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

Route::get('/v1.0/client/coupons/by-garage-id/{garage_id}/{perPage}', [ClientCouponController::class, "getCouponsByGarageIdClient"]);
Route::get('/v1.0/client/coupons/all/{perPage}', [ClientCouponController::class, "getCouponsClient"]);
Route::get('/v1.0/client/coupons/single/{id}', [ClientCouponController::class, "getCouponByIdClient"]);


Route::get('/v1.0/client/coupons/get-discount/{garage_id}/{code}/{amount}', [ClientCouponController::class, "getCouponDiscountClient"]);




// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// coupon management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// client pre booking management section
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@



Route::post('/v1.0/client/pre-bookings', [ClientPreBookingController::class, "createPreBookingClient"]);
Route::put('/v1.0/client/pre-bookings', [ClientPreBookingController::class, "updatePreBookingClient"]);


Route::get('/v1.0/client/pre-bookings/{perPage}', [ClientPreBookingController::class, "getPreBookingsClient"]);

Route::get('/v1.0/client/pre-bookings/single/{id}', [ClientPreBookingController::class, "getPreBookingByIdClient"]);

Route::post('/v1.0/client/pre-bookings/confirm', [ClientPreBookingController::class, "confirmPreBookingClient"]);

Route::delete('/v1.0/client/pre-bookings/{id}', [ClientPreBookingController::class, "deletePreBookingByIdClient"]);


// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//  client pre booking management section
// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%






















});


