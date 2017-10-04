<?php

		// Cron Job Routing
		Route::get('cronjob', 'CronController@index');

		/* Admin part routing */
		Route::get('/', 'LoginController@login');
		Route::get('/login', 'LoginController@login');
		Route::post('/authenticate', 'LoginController@authenticate');
		Route::get('/logout', 'LoginController@logout');
		// Password Reset Routes...
		Route::get('password/resets/{token?}', 'LoginController@showResetForm');
		Route::post('password/resets/{token?}', 'LoginController@setPassword');
		Route::post('password/email', 'LoginController@sendResetLinkEmail');
		Route::get('password/reset', 'LoginController@reset');

		// Customer Login Route 
		Route::get('customer', 'CustomerAuth\AuthController@showLoginForm');
		Route::post('customer/authenticate', 'CustomerAuth\AuthController@login');
		Route::get('customer/logout', 'CustomerAuth\AuthController@logout');

		Route::get('customer/dashboard', 'CustomerPanelController@index');
		Route::get('customer/profile', 'CustomerPanelController@profile');
		Route::post('customer/profile', 'CustomerPanelController@updateProfile');

		Route::get('customer-panel/order/{id}','CustomerPanelController@salesOrder');
		Route::get('customer-panel/view-order-details/{id}','CustomerPanelController@viewOrderDetails');
		Route::get('customer-panel/orderPdf/{order_id}','CustomerPanelController@orderPdf');
		Route::get('customer-panel/orderPrint/{order_id}','CustomerPanelController@orderPrint');

		Route::get('customer-panel/invoice/{id}','CustomerPanelController@invoice');
		Route::get('customer-panel/view-detail-invoice/{order_id}/{invoice_id}','CustomerPanelController@viewInvoiceDetails');
		Route::get('customer-panel/invoice-pdf/{order_id}/{invoice_id}','CustomerPanelController@invoicePdf');
		Route::get('customer-panel/invoice-print/{order_id}/{invoice_id}','CustomerPanelController@invoicePrint');

		Route::get('customer-panel/payment/{id}','CustomerPanelController@payment');
		Route::get('customer-panel/view-receipt/{id}','CustomerPanelController@viewReceipt');
		
		Route::get('customer-panel/shipment/{id}','CustomerPanelController@shipment');
		Route::get('customer-panel/view-shipment-details/{order_id}/{shipment_id}','CustomerPanelController@shipmentDetails');

		Route::get('customer-panel/branch/{id}','CustomerPanelController@branch');
		Route::get('customer-panel/branch/edit/{id}','CustomerPanelController@branchEdit');
		Route::post('customer-panel/branch/update/{id}','CustomerPanelController@branchUpdate');


	Route::group(['middleware' => ['auth','locale'] ], function() {
	
		/* User Actions */
		Route::get('dashboard','DashboardController@index');
		Route::post('change-lang','DashboardController@switchLanguage');
		Route::get('users','UserController@index');
		Route::get('create-user','UserController@create');
		Route::post('save-user','UserController@store');
		Route::get('edit-user/{id}','UserController@edit');
		Route::post('update-user/{id}','UserController@update');
		Route::post('delete-user/{id}','UserController@destroy');
		Route::post('email-valid','UserController@validEmail');
		Route::get('profile','UserController@profile');
		Route::get('change-password/{id}','UserController@changePassword');
		Route::post('change-password/{id}','UserController@updatePassword');
		// Details 
		Route::get('user/purchase-list/{id}','UserController@userPurchaseOrderList');
		Route::get('user/sales-order-list/{id}','UserController@userSalesOrderList');
		Route::get('user/sales-invoice-list/{id}','UserController@userSalesInvoiceList');
		Route::get('user/user-transfer-list/{id}','UserController@userTransferList');
		Route::get('user/user-payment-list/{id}','UserController@userPaymentList');

		// user Role
		Route::get('user-role','RoleController@index');
		Route::get('create-role','RoleController@create');
		Route::post('save-role','RoleController@store');
		Route::get('edit-role/{id}','RoleController@edit');
		Route::post('update-role/{id}','RoleController@update');
		Route::post('delete-role/{id}','RoleController@destroy');

		// item category
		Route::get('item-category','CategoryController@index');
		Route::get('create-category','CategoryController@create');
		Route::post('save-category','CategoryController@store');
		Route::post('edit-category','CategoryController@edit');
		Route::post('update-category','CategoryController@update');
		Route::post('delete-category/{id}','CategoryController@destroy');
		Route::get('categorydownloadExcel/{type}', 'CategoryController@downloadCsv');
		Route::get('categoryimport', 'CategoryController@import');
		Route::post('categoryimportcsv', 'CategoryController@importCsv');

		// item Unit
		Route::get('unit','UnitController@index');
		Route::get('create-unit','UnitController@create');
		Route::post('save-unit','UnitController@store');
		Route::post('edit-unit','UnitController@edit');
		Route::post('update-unit','UnitController@update');
		Route::post('delete-unit/{id}','UnitController@destroy');

		
		// Location
		Route::get('location','LocationController@index');
		Route::get('create-location','LocationController@create');
		Route::post('save-location','LocationController@store');
		Route::get('edit-location/{id}','LocationController@edit');
		Route::post('update-location/{id}','LocationController@update');
		Route::post('delete-location/{id}','LocationController@destroy');
		Route::get('loc_code-valid','LocationController@validLocCode');

		// Item
		Route::group([
			'as' => '.item',
			'prefix'=>'item'
		], function(){
			Route::get('/','ItemController@index');
			Route::get('/add','ItemController@create');
			Route::get('/edit/{id}','ItemController@edit');
			Route::post('/save','ItemController@store');
			Route::post('/update','ItemController@update');
			Route::post('/save-grouped-product','ItemController@storeGroupedProduct');
			Route::get('/save-specification','ItemController@saveSpecification');
			Route::get('/ajax/list','ItemController@ajaxGetAllItems');
		});
		Route::get('item','ItemController@index');
		Route::get('create-item/{tab}','ItemController@create');
		Route::post('save-item','ItemController@store');
		Route::get('edit-item/{tab}/{id}','ItemController@edit');
		Route::get('copy-item/{id}','ItemController@copy');
		Route::get('show-item/{id}','ItemController@show');
		Route::post('update-item/{id}','ItemController@update');
		Route::post('item/delete/{id}','ItemController@destroy');
		Route::post('save-sale-price','ItemController@storeSalePrice');
		Route::post('save-purchase-price','ItemController@storePurchasePrice');
		Route::post('update-item-info','ItemController@updateItemInfo');
		Route::post('add-sale-price','ItemController@addSalePrice');
		Route::post('edit-sale-price','ItemController@editSalePrice');
		Route::post('update-sale-price','ItemController@updateSalePrice');
		Route::post('delete-sale-price/{id}/{item_id}','ItemController@deleteSalePrice');
		Route::post('update-purchase-price','ItemController@updatePurchasePrice');
		Route::get('item/ajax/get-item','ItemController@ajaxGetItem');
		Route::post('add-stock','ItemController@addStock');
		Route::post('remove-stock','ItemController@removeStock');
		Route::post('move-stock','ItemController@moveStock');
		Route::post('stock-valid','ItemController@stockValidChk');
		Route::post('qty-valid','ItemController@qtyValidAjax');
		Route::get('trans-details/{id}','ItemController@showFullDetails');

		Route::get('itemdownloadcsv/{type}', 'ItemController@downloadCsv');
		Route::get('itemimport', 'ItemController@import');
		Route::post('itemimportcsv', 'ItemController@importCsv');

		// Company 
		Route::get('company','CompanyController@index');
		Route::get('create-company','CompanyController@create');
		Route::post('save-company','CompanyController@store');
		Route::get('edit-company/{id}','CompanyController@edit');
		Route::post('update-company/{id}','CompanyController@update');
		Route::post('delete-company/{id}','CompanyController@destroy');

		// create direct sale / invoive
		Route::get('sales/list','SalesController@index');
		Route::get('sales/add','SalesController@create');
		Route::post('sales/save','SalesController@store');
		Route::get('sales/edit/{id}','SalesController@edit');
		Route::post('sales/update','SalesController@update');
		Route::post('sales/delete/{id}','SalesController@destroy');
		Route::post('sales/reference-validation','SalesController@referenceValidation');
		Route::post('sales/get-branches','SalesController@customerBranches');
		
		Route::post('sales/search','SalesController@search');
		Route::post('sales/quantity-validation','SalesController@quantityValidation');
		Route::post('sales/check-item-qty','SalesController@checkItemQty');
		Route::get('sales/preview/{id}','SalesController@pdfview');
        Route::post('sales/quantity-validation-with-localtion','SalesController@quantityValidationWithLocaltion');
		Route::post('sales/quantity-validation-edit-invoice','SalesController@quantityValidationEditInvoice');
		Route::get('sales/filtering','SalesController@salesFiltering');
		

		Route::get('order/shipping_cost_price/{weight}/{method}','QuoteController@shipping_cost_price');

		// create sales order
		Route::group([
			'prefix' => 'order',		
			'as' => 'order.',
		], function(){
			Route::get('/add','OrderController@create');
			Route::get('/shipping-cost','OrderController@getShippingCost');
			Route::get('/list','OrderController@index');

			Route::get('ajax/pending-order-list','OrderController@ajaxGetPendingOrders');
			Route::get('ajax/get-order-summary','OrderController@ajaxGetOrderSummary');
			Route::get('ajax/ready-ship-order-list','OrderController@ajaxGetReadyToShipOrders');
			Route::get('ajax/cancelled-order-list','OrderController@ajaxGetCancelledOrders');
			Route::get('ajax/completed-order-list','OrderController@ajaxGetCompletedOrders');
			Route::get('ajax/shipped-order-list','OrderController@ajaxGetShippedOrders');
			//Route::get('/add','SalesOrderController@create');
			//Route::post('/save','SalesOrderController@store');
			Route::get('/updateaddress','OrderController@updateAddress');
			//Route::get('/edit/{id}','SalesOrderController@edit');
			//Route::post('/update','SalesOrderController@update');
			Route::post('/delete/{id}','SalesOrderController@destroy');
			Route::get('/view-order/{id}','SalesOrderController@viewOrder');
			Route::post('/convert-order','SalesOrderController@convertOrder');
			Route::get('/customer_mobile_no/{mobile_no}','SalesOrderController@customer_mobile_no');
			Route::post('/save','OrderController@save');
			Route::get('/edit/shipping_cost_price/{weight}/{method}','QuoteController@shipping_cost_price');
			Route::get('/edit/{id}','OrderController@edit');
			Route::post('/search','SalesOrderController@search');
			Route::post('/quantity-validation','SalesOrderController@quantityValidation');
			Route::post('/update','OrderController@update');
			Route::get('/view-order-details/{id}','SalesOrderController@viewOrderDetails');
			Route::get('/manual-invoice-create/{id}','SalesOrderController@manualInvoiceCreate');
			Route::post('/save-manual-invoice','SalesOrderController@storeManualInvoice');
			Route::get('/auto-invoice-create/{id}','SalesOrderController@autoInvoiceCreate');
			Route::post('/check-quantity-after-invoice','SalesOrderController@checkQuantityAfterInvoice');
			Route::get('/pdf/{order_id}','SalesOrderController@orderPdf');
			Route::get('/print/{order_id}','SalesOrderController@orderPrint');
			Route::post('/email-order-info','SalesOrderController@sendOrderInformationByEmail');	
			Route::get('/filtering','SalesOrderController@orderFiltering');
			Route::post('/checkphonenumber','SalesOrderController@checkIfCustomerPhoneNumberExist');	
			Route::post('/addpayment','OrderController@addPayment');
			Route::post('/deletepayment','OrderController@deletePayment');
			Route::post('/deletemultipayment','OrderController@deleteMultiPayment');
			Route::post('/editpayment','OrderController@editPayment');
			Route::post('/update-status-multi-payment','OrderController@updateStatusMultiPayment');
			Route::post('/update-status-payment','OrderController@updateStatusPayment');
			Route::post('/update-status','OrderController@updateStatus');
			Route::get('/ajax-item-search','ItemController@ajaxSearch');
			Route::get('/printpdf','SalesOrderController@printPDF');
			Route::get('/ajax-get','OrderController@ajaxGet');
		});
		//Route::get('order/list','SalesOrderController@index');
	

		/* Stock Routes */
		Route::group([
			'prefix'=>'stock',
			'as' => 'stock.'
		], function(){

			//Stock Movement
			Route::get('/movement','StockController@index');
			Route::post('/movement/create','StockController@create');
			Route::get('/movement/get-by-id','StockController@getStockMovementsById');
			Route::post('/movement/edit','StockController@update');
			Route::post('/movement/delete','StockController@delete');
		});
		


		//QUOTE 
		
		Route::get('quote/list','QuoteController@index');
		Route::get('quote/add','QuoteController@create');
		Route::post('quote/save','QuoteController@store');
		Route::get('quote/edit/{id}','QuoteController@edit');
		Route::post('quote/update','QuoteController@update');
		Route::post('quote/delete/{id}','QuoteController@destroy');
		Route::get('quote/view-order/{id}','QuoteController@viewOrder');
		Route::post('quote/convert-order','QuoteController@convertOrder');
		Route::get('quote/view-quote-details/{id}','QuoteController@viewQuoteDetails');
		
		



		Route::post('quote/search','QuoteController@search');
		Route::get('quote/customer_details/{id}','QuoteController@mobile_search');
		Route::get('quote/fill_data/{mobile_no}','QuoteController@fill_data');
		Route::post('quote/save','QuoteController@quote_save');
		Route::get('quote/shipping_cost_price/{weight}/{method}','QuoteController@shipping_cost_price');
		Route::get('quote/edit/shipping_cost_price/{weight}/{method}','QuoteController@shipping_cost_price');
		
		//QUOTE PAYMENTS
		
		Route::get('quote/payment','QuoteController@quote_payment');
		Route::get('quote/payment_add','QuoteController@quote_payment_add');
		Route::get('quote/quote_cust_info/{quote_id}','QuoteController@quote_cust_info');
		Route::post('save-quote_payment','QuoteController@save_quote_payment');


		Route::get('shipping/cost','ShippingController@index');
		Route::get('shipping/add','ShippingController@add_shipping');
		//INVENTORY MODULE
		Route::get('inventory/inventory_view_adjust','InventoryController@inventory_view_adjust');
		Route::get('inventory/adjust_history','InventoryController@adjust_history');
		Route::get('inventory/preoder','InventoryController@preoder');
		Route::get('inventory/purchases','InventoryController@purchases');
		Route::get('inventory/supplier_list','InventoryController@supplier_list');

		



		// Invoice Routing
		Route::get('invoice/view-detail-invoice/{orderId}/{invoiceId}','InvoiceController@viewInvoiceDetails');
		Route::post('invoice/email-invoice-info','InvoiceController@sendInvoiceInformationByEmail');
		Route::get('invoice/pdf/{order_id}/{invoice_id}','InvoiceController@invoicePdf');
		Route::get('invoice/print/{order_id}/{invoice_id}','InvoiceController@invoicePrint');		
		Route::post('invoice/delete/{id}','InvoiceController@destroy');
		Route::get('invoice/delete-invoice/{id}','InvoiceController@destroy');
		// Customer 

		Route::group([
			
			'prefix'   =>'customer',
			'as'       =>'customer.'
		], function(){
	    Route::post('/updateaddress','CustomerController@updateAddress');
		Route::get('/list','CustomerController@index');
		Route::get('/create-customer','CustomerController@create');
		Route::post('save-customer','CustomerController@store');
		Route::get('/edit/{id}','CustomerController@edit');
		Route::get('/order/{id}','CustomerController@salesOrder');
		Route::get('/invoice/{id}','CustomerController@invoice');
		Route::get('/payment/{id}','CustomerController@payment');
		Route::get('/shipment/{id}','CustomerController@shipment');
		Route::post('/update-customer/{id}','CustomerController@update');
		Route::post('/customer/update-password','CustomerController@updatePassword');
		Route::post('/delete-customer/{id}','CustomerController@destroy');

		Route::get('/customerdownloadCsv/{type}', 'CustomerController@downloadCsv');
		Route::get('/customerimport', 'CustomerController@import');
		Route::post('/customerimportcsv', 'CustomerController@importCsv');
		Route::post('/delete-sales-info', 'CustomerController@deleteSalesInfo');
		//Route::post('customerimportcsv', 'CustomerController@importCsv');

		// Customer Branch
		Route::get('/branch','CustomerController@index');
		Route::get('/create-branch','CustomerController@create');
		Route::post('/save-branch','CustomerController@storeBranch');
		Route::post('/edit-branch','CustomerController@editBranch');
		Route::post('/update-branch','CustomerController@updateBranch');
		Route::post('/delete-branch/{id}','CustomerController@destroyBranch');

		Route::get('/ajax/get-customer','CustomerController@ajaxGetCustomer');
		});

		// supplier 
		Route::group([
			'prefix' => 'supplier',
			'as' => '.supplier'
		], function(){
			Route::get('/ajax/get','SupplierController@ajaxGet');
		});
		Route::get('supplier','SupplierController@index');
		Route::get('create-supplier','SupplierController@create');
		Route::post('save-supplier','SupplierController@store');
		Route::get('edit-supplier/{id}','SupplierController@edit');
		Route::post('update-supplier/{id}','SupplierController@update');
		Route::post('delete-supplier/{id}','SupplierController@destroy');
        Route::get('supplier/orders/{id}','SupplierController@orderList');

		Route::get('supplierdownloadCsv/{type}', 'SupplierController@downloadCsv');
		Route::get('supplierimport', 'SupplierController@import');
		Route::post('supplierimportcsv', 'SupplierController@importCsv');

		// check-in Purchese Order
		Route::group([
			'prefix' => 'purchase',
			'as' => '.purchase'
		], function(){
			Route::post('/save', 'PurchaseController@store');
			Route::get('/add', 'PurchaseController@create');
			Route::get('/edit/{id}','PurchaseController@edit');
			Route::post('/update','PurchaseController@update');
			Route::post('/addpayment','PurchaseController@addPayment');
			Route::post('/editpayment','PurchaseController@editPayment');
			Route::post('/saveshipment','PurchaseController@saveShipment');
			Route::post('/markshipped','PurchaseController@markShipped');
		});
		Route::get('purchase/list','PurchaseController@index');
		Route::post('purchase/delete/{id}','PurchaseController@destroy');
		
		Route::post('purchase/item-search','PurchaseController@searchItem');
		Route::get('purchase/view-purchase-details/{id}','PurchaseController@viewPurchaseInvoiceDetail');
	
		Route::get('purchase/pdf/{order_id}','PurchaseController@invoicePdf');
		Route::get('purchase/print/{order_id}','PurchaseController@invoicePrint');
		Route::post('purchase/reference-validation','PurchaseController@referenceValidation');
		
		Route::get('purchase/filtering','PurchaseController@Filtering');
		// Stock Transfer Routing
		Route::get('transfer/list','StockTransferController@index');
		Route::get('transfer/create','StockTransferController@create');
		Route::post('transfer/search','StockTransferController@itemSearch');
		Route::post('transfer/get-destination','StockTransferController@destinationList');
		Route::post('transfer/check-item-qty','StockTransferController@checkItemQty');
		Route::post('transfer/save','StockTransferController@store');
		Route::get('transfer/view-details/{id}','StockTransferController@details');
		Route::post('transfer/delete/{id}','StockTransferController@destroy');
		// Payment Routing
		Route::post('payment/save','PaymentController@createPayment');

		// item Tax
		Route::get('tax','TaxController@index');
		Route::get('create-tax','TaxController@create');
		Route::post('save-tax','TaxController@store');
		Route::post('edit-tax','TaxController@edit');
		Route::post('update-tax','TaxController@update');
		Route::post('delete-tax/{id}','TaxController@destroy');

		// item Sales Type
		Route::get('sales-type','SalesTypeController@index');

		Route::post('save-sales-type','SalesTypeController@store');
		Route::post('edit-sales-type','SalesTypeController@edit');
		Route::post('update-sales-type','SalesTypeController@update');
		Route::post('delete-sales-type/{id}','SalesTypeController@destroy');



		// Settings
		Route::get('setting-general','SettingController@index');
		Route::get('setting-email-template','SettingController@mailTemp');
		Route::get('setting-preference','SettingController@preference');
		Route::get('setting-finance','SettingController@finance');
		Route::get('setting-company','SettingController@company');
		Route::post('save-preference','SettingController@savePreference');
		Route::get('currency','SettingController@currency');
		Route::post('save-currency','SettingController@store');
		Route::post('edit-currency','SettingController@edit');
		Route::post('update-currency','SettingController@update');
		Route::post('delete-currency/{id}','SettingController@destroy');
		Route::get('backup/list','SettingController@backupList');
		Route::get('back-up','SettingController@backupDB');
		Route::get('email/setup','SettingController@emailSetup');
		Route::post('save-email-config','SettingController@emailSaveConfig');
		Route::post('test-email','SettingController@testEmailConfig');

		
		//Payment route
		Route::get('payment/terms','SettingController@paymentTerm');
		Route::post('payment/terms/add','SettingController@addPaymentTerms');
		Route::post('payment/terms/edit','SettingController@editPaymentTerms');
		Route::post('payment/terms/update','SettingController@updatePaymentTerms');
		Route::post('payment/terms/delete/{id}','SettingController@deletePaymentTerm');
		Route::get('payment/method','SettingController@paymentMethod');
		Route::post('payment/method/add','SettingController@addPaymentMethod');
		Route::post('payment/method/edit','SettingController@editPaymentMethod');
		Route::post('payment/method/update','SettingController@updatePaymentMethod');
		Route::post('payment/method/delete/{id}','SettingController@deletePaymentMethod');
		Route::get('company/setting','SettingController@companySetting');
		Route::post('company/setting/save','SettingController@companySettingSave');
		
		//mail template
		Route::get('mail-temp','MailTemplateController@index');
		Route::get('customer-invoice-temp/{id}','MailTemplateController@customerInvTemp');
		Route::post('customer-invoice-temp/{id}','MailTemplateController@update');

		// Payment Routing
		Route::get('payment/list','PaymentController@index');
		Route::post('payment/delete','PaymentController@delete');
		Route::get('payment/view-receipt/{id}','PaymentController@viewReceipt');
		Route::get('payment/create-receipt/{id}','PaymentController@createReceiptPdf');
		Route::get('payment/print-receipt/{id}','PaymentController@printReceipt');
		Route::post('payment/email-payment-info','PaymentController@sendPaymentInformationByEmail');
		Route::get('payment/pay-all/{orderid}','PaymentController@payAllAmount');

		Route::get('payment/filtering','PaymentController@paymentFiltering');
		
		// Shipment Routing
		Route::get('shipment/add/{id}','ShipmentController@createShipment');
		Route::post('shipment/store','ShipmentController@storeShipment');
		Route::get('shipment/create-auto-shipment/{id}','ShipmentController@storeAutoShipment');
		Route::get('shipment/list','ShipmentController@index');
		Route::post('shipment/status-change','ShipmentController@StatusChange');
		Route::post('shipment/delete/{id}','ShipmentController@destroy');
		Route::get('shipment/view-details/{order_id}/{shipment_id}','ShipmentController@shipmentDetails');
		Route::get('shipment/pdf/{order_id}/{shipment_id}','ShipmentController@pdfMake');
		Route::get('shipment/print/{order_id}/{shipment_id}','ShipmentController@shipmentPrint');
		Route::get('shipment/edit/{id}','ShipmentController@edit');
		Route::post('shipment/quantity-validation','ShipmentController@shipmentQuantityValidation');
		Route::post('shipment/update','ShipmentController@update');
		Route::post('shipment/email-shipment-info','ShipmentController@sendShipmentInformationByEmail');
		Route::get('shipment/delivery/{oid}/{sid}','ShipmentController@makeDelivery');

		Route::get('shipment/filtering','ShipmentController@shipmentFiltering');
		Route::get('shipment/manageShipment','ShipmentController@manageShipment');
		Route::get('shipment/get-shipment-detail','ShipmentController@getShipmentByOrderNo');
		Route::get('shipment/automatic-allocate','ShipmentController@automaticAllocateShipment');
		Route::get('shipment/manual-allocate','ShipmentController@manualAllocate');
		Route::get('shipment/validate-additional-quantity','ShipmentController@validateAdditionalPackingQuantity');
		Route::get('shipment/add-tracking','ShipmentController@addTrackingNumber');
		Route::get('/shipment/manual-get-data','ShipmentController@getDataForManualAllocate');
		Route::get('/shipment/remove-shipment','ShipmentController@removeShipment');
		Route::get('/shipment/edit-shipment','ShipmentController@editShipment');
		Route::get('/shipment/test','ShipmentController@test');
		// Report Routing
		Route::get('report/inventory-stock-on-hand','ReportController@inventoryStockOnHand');
		
		Route::get('report/inventory-stock-on-hand-pdf','ReportController@inventoryStockOnHandPdf');
		Route::get('report/inventory-stock-on-hand-csv','ReportController@inventoryStockOnHandCsv');
		Route::get('report/sales-report','ReportController@salesReport');
		Route::get('report/sales-report-pdf','ReportController@salesReportPdf');
		Route::get('report/sales-report-csv','ReportController@salesReportCsv');
		Route::get('report/sales-report-by-date/{date}','ReportController@salesReportByDate');
		Route::get('report/sales-report-by-date-pdf/{date}','ReportController@salesReportByDatePdf');
		Route::get('report/sales-report-by-date-csv/{date}','ReportController@salesReportByDateCsv');
	
		Route::get('report/sales-history-report','ReportController@salesHistoryReport');
		Route::get('report/sales-history-report-pdf','ReportController@salesHistoryReportPdf');
		Route::get('report/sales-history-report-csv','ReportController@salesHistoryReportCsv');
		// Purchase Report
        Route::get('report/purchase-report','ReportController@purchaseReport');
        Route::get('report/purchase-report-pdf','ReportController@purchaseReportPdf');
        Route::get('report/purchase-report-csv','ReportController@purchaseReportCsv');
        Route::get('report/purchase_report_datewise/{time}','ReportController@purchaseReportDateWise');
        Route::get('report/purchase-year-list','ReportController@purchaseYearList');

        Route::get('report/member-report','UserController@memberReport');
      
       

	});