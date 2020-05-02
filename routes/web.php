<?php
Route::group(['middleware' => ['web']] ,function(){ });

// start hotel get route
	Route::get('/get-reservation', 'ViewController@Getreservation');
	Route::get('/get-reservation-details', 'ViewController@GetreservationDetail');
	Route::get('/get-room', 'ViewController@GetRoomRate');
	Route::get('/calender', 'ViewController@GetCalender');
	Route::get('/get-room-occupancy', 'ViewController@GetRoomOccupancy');
	Route::get('/guest-check-in', 'ViewController@GetCheckIn');
	Route::get('/guest-check-out', 'ViewController@GetCheckOut');
	Route::get('/reservation-confirmation', 'ViewController@GetReservationConfirmation');
	Route::get('/current-guest-in-hotel', 'ViewController@GetHotelCurrentGuest');
	Route::get('/workinground-help-with-video-tutorial', 'ViewController@GetVideoTutorial');
// end hotel get route

// start hotel post route
Route::post('/create-room', 'RoomController@CreateNewRoom');
Route::post('/edit-reservation', 'ReservationController@EditReservation');
Route::post('/edit-room', 'RoomController@EditRoom');
Route::post('/edit-hotel-rates', 'RoomController@EditHotelRates');
Route::post('/delete-hotel-rates', 'RoomController@DeleteHotelRates');
Route::post('/delete-hotel-room', 'RoomController@DeleteHotelRoom');
Route::post('/create-new-reservation', 'ReservationController@MakeNewReservation');
Route::post('/create-new-hotel-rate', 'HotelDataController@CreateNewRate');
Route::post('/make-guest-checked-in', 'CheckInOutController@MakeGuestCheckin');
Route::post('/mark-as-no-show', 'CheckInOutController@MakeGuestAsNoShow');
Route::post('/confirm-reservation', 'HotelDataController@ConfirmReservationDetails');
// end hotel post route

// start hotel Data route
	Route::post('/get-rate-data', 'HotelDataController@GetRateData');
	Route::post('/get-room-data', 'HotelDataController@CurrentRooms');
	Route::post('/get-available-room-data', 'HotelDataController@GetAvailableRooms');
	Route::post('/get-room-rate-data', 'HotelDataController@GetRoomsRates');
	Route::post('/get-travel-agent-data', 'HotelDataController@GetTravelAgentData');
	Route::post('/get-country-data', 'HotelDataController@GetCountries');
	Route::get('/guest-check-in-data', 'HotelDataController@GetReservationForCheckIn');
// end hotel Data route

//start chart data
Route::post('/sales-chart-data', 'ReportController@GetSalesChartData');
Route::post('/sales-chart-data-flow', 'ReportController@GetChangeChartData');
Route::post('/expenceDataFlow', 'ReportController@GetChangeExpenceChartData');
//end chart data

// start hotel datatabel route
Route::get('hotelCurrentRates', 'DataFlowController@GetCurrentHotelRate')->name('getHotelRate.data');
Route::get('hotelreservationDetails', 'DataFlowController@GetHotelReservationDetails')->name('reservationDetails.data');
Route::get('roomStatus', 'DataFlowController@GetRoomAvailability')->name('occupency.data');
Route::get('bookingData', 'DataFlowController@GetBooking')->name('booking.data');
Route::get('checkingData', 'DataFlowController@GetCheckinData')->name('checking.data');
Route::get('paymentConfirmationData', 'DataFlowController@GetReservationDetails')->name('paymentConfirmation.data');
Route::get('currentGuestData', 'DataFlowController@GetCurrentGuestData')->name('currentGuest.data');
// end hotel datatabel route

Route::get('/', 'ViewController@GetHome');
Route::get('/bill-dashboard-Old', 'BillController@GetBilling');
Route::get('/billing-dashboard', 'BillController@GetNewBillingInterface');//newBilling
Route::get('/printertest', 'ViewController@GetPrinterTest');
Route::get('/printpreview', 'ViewController@GetPrint');
Route::get('/receiveJob', 'ViewController@GetReceiveJob');
Route::get('/master', 'ViewController@GetMaster');
Route::get('/batch', 'ViewController@GetBatch');

Route::get('/TestPrint', 'ViewController@TestPrint');
Route::post('/PrintJob', 'ViewController@PrintJob');


Route::post('/printJobReceiptModel', 'PrintController@PrintJobBoolean');


Route::get('/sri-lanka-web-based-pos-system-software-signup', 'ViewController@GetLogin');
Route::get('/sri-lanka-workinground-web-based-pos-system-software-create-account', 'ViewController@GetRegister');
Route::get('/sri-lanka-workinground-free-web-based-pos-system-software', 'ViewController@landingPage');
Route::get('/signout', 'UserController@SignOut');
Route::get('/getjob', 'ViewController@GetJob');
Route::get('/stock', 'StockController@GetItemHistoryTest');
Route::get('/customer', 'CustomerController@GetCustomers');
Route::get('/manageusers', 'UserController@ManageUsers');
Route::get('/manageusers/{id}', 'UserController@ManageUserCollection');
Route::get('/printpreview', 'BillController@PrintBill');
Route::get('/alert', 'ViewController@AlertDataDate');
Route::get('/profile', 'UserController@GetProfile');
Route::get('/reports', 'ReportController@GetReports');
Route::get('/my-reports', 'ReportController@GetMyReports');
Route::get('/expence', 'ViewController@GetExpence');
Route::get('/payments', 'PaymentController@GetPayment');
Route::get('/prices', 'PaymentController@GetPaymentPrices');
Route::get('/Sales-History', 'ViewController@GetStockTestView'); //new stock view

// =================
Route::get('DemoPrintFile', 'DemoPrintFileController@index');
Route::get('DemoPrintFileController', 'DemoPrintFileController@printFile');
Route::any('WebClientPrintController', 'WebClientPrintController@processRequest');
// =================

Route::get('/test', 'ReportController@getAllMonthlyData'); //for test purpose only
Route::get('/test-page', 'ViewController@GettestPage'); //for test purpose only
Route::get('/manage-user-dashboard', 'ViewController@GetnewUserManage'); //for test purpose only
Route::get('/smstest', 'SmsController@sendSms'); //for test purpose only
Route::get('/test_printer', 'SmsController@printerTest'); //for test purpose only
Route::get('/print_recipt', 'PrintController@PrintReceipt'); //for test purpose only
Route::get('/print_job_recipt', 'PrintController@PrintJobReceipt'); //for test purpose only
Route::get('/test_relation', 'ViewController@GetTestRelation'); //for test purpose only
Route::get('/test_ajax', 'ViewController@Getajaxtest'); //for test purpose only
Route::post('/data_123', 'ViewController@data'); //for test purpose only
Route::post('/data_post', 'ViewController@datapost'); //for test purpose only
Route::get('/aletData', 'ViewController@aletData'); //for test purpose only
Route::get('/systemtest', 'ViewController@GetSystemTest'); //for test purpose only
Route::get('/sri-lanka-web-based-workinground-pos-system-site-map', 'ViewController@GetSiteMap'); //for test purpose only
Route::get('/testyear', 'StockController@yearcount'); //for test purpose only
Route::get('/testjson', 'StockController@productJson'); //for test purpose only
Route::get('/testproduct', 'StockController@testproduct'); //for test purpose only

Route::post('/postjob', 'JobsController@ReceiveJob');
Route::post('/jobactivity', 'JobsController@JobAction');
Route::post('/registeruser', 'UserController@registerUser');
Route::post('/signup', 'UserController@SignUp');
Route::post('/addNewItem', 'StockController@AddNewItem');
Route::post('/deleteItem', 'StockController@DeleteItem');
Route::post('/updateItem', 'StockController@UpdateProduct');
Route::post('/editproduct', 'StockController@EditProduct');
Route::post('/discardproduct', 'StockController@GetItemDiscard');
Route::post('/postitem', 'BillController@PostBillingItem');
Route::post('/removeBillItem', 'BillController@RemoveBillingItem');
Route::post('/purchase', 'BillController@FinishBill');
Route::post('/getapprove', 'StockController@GetItemDiscardApprove');
Route::post('/itemreturn', 'BillController@GetItemReturn');
Route::post('/verify_shop', 'UserController@VerifyShop');
Route::post('/user-modification', 'UserController@VerifyUsers');
Route::post('/userupdate', 'UserController@UpdateUser');
Route::post('/usersettings', 'UserController@PrinterUserSettings');
Route::post('/upload_pic', 'UserController@photoUpload');
Route::get('/sale-data', 'ReportController@GetReportdata');
Route::post('/sale-data-update', 'ReportController@GetReportdata');
Route::post('/expence_record', 'ExpenceController@PostExpence');
Route::post('/delete_expence_record', 'ExpenceController@DeleteExpence');
Route::post('/monthly_Expence', 'ReportController@doughnut');
Route::post('/monthsale', 'ReportController@MonthlySaleReport');
Route::post('/upload-payment', 'PaymentController@PostPayment');
Route::post('/payment_approve', 'PaymentController@ApprovePayment');
Route::post('/payment_delete', 'PaymentController@DeletePayment');
Route::post('/verification_code_check', 'UserController@VerifyAccount');
Route::post('/change-user-role', 'UserController@ChangeRole');
Route::post('/update-rate', 'RateController@DoUpdateShopRate');
Route::post('/ratedata', 'DataFlowController@rateData');
Route::post('/sendBulkMessage', 'SMSController@SendBulkMessage');
Route::get('/testsms', 'SmsController@testSms');
Route::get('/unsettledBillCount', 'BillController@unsettledBillCount');
Route::get('/cartTotal', 'StockController@cartTotal');

// -----------------------DATA FLOWS start-----------------------------------------------
Route::get('ShopDataShouldBeEncriptedToRemoveUnauthorizedAccess1', 'DataFlowController@GetShops')->name('shops.data');
Route::get('StockDataShouldBeEncriptedToRemoveUnauthorizedAccess2', 'DataFlowController@GetProductStockData')->name('stocks.data');
Route::get('StockDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@NewAddForStock')->name('addNewstocks.data');
Route::get('ExpencekDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@GetExpenceData')->name('expence.data');
Route::get('BatchDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@GetBatchData')->name('batch.data');
Route::get('SettledBillDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@GetSettledBillData')->name('settledBill.data');
Route::get('CurrentSockProductDataShouldBeEncriptedToRemoveUnauthorizedAccess', 'DataFlowController@GetCurrentProductData')->name('CurrentStock.data');
Route::get('paymentDataShouldBeEncriptedToRemoveUnauthorizedAccess', 'DataFlowController@GetPaymentData')->name('payment.data');
Route::get('CustomerDataShouldBeEncriptedToRemoveUnauthorizedAccess', 'DataFlowController@GetCustomer')->name('customer.data');
Route::get('ShoppingCartBillDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@GetShoppingCartBillData')->name('shoppingCart.data');
Route::get('VoidBillDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@GetVoidBillData')->name('voidBill.data');
Route::get('SalesBillDataShouldBeEncriptedToRemoveUnauthorizedAccess3', 'DataFlowController@GetSalesBillData')->name('salesBill.data');
Route::get('ItemWiseDataShouldBeEncriptedToRemoveUnauthorizedAccess3/{date}', 'DataFlowController@GetItemWiseData')->name('itemWise.data');
Route::get('DiscardItemsDataShouldBeEncriptedToRemoveUnauthorizedAccess', 'DataFlowController@GetDiscardProductData')->name('discardItem.data');
Route::get('CashReconsilDataShouldBeEncriptedToRemoveUnauthorizedAccess', 'DataFlowController@GetCashCreditData')->name('cashReconsilation.data');
// -----------------------DATA FLOWS end-----------------------------------------------

// -----------------------ajax data route start-----------------------------------------------

Route::get('/current_bill_total', 'BillController@GetBillCurrentTotal');
// -----------------------ajax data route end-----------------------------------------------

Route::post('/test_verify_shop', 'UserController@VerifyShopTest');
Route::post('/test_shop_detail', 'UserController@UpdateShopDetails');
Route::post('/test_delete_shop', 'UserController@DeleteShopTest');
Route::post('/test_bulk_change_shop', 'UserController@BulkChangeTest');
Route::post('/test_notification_change_shop', 'UserController@NotificationChangeTest');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

