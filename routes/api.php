<?php


//login and register
Route::post('login', 'Auth\ApiAuthController@login');
Route::post('register', 'Auth\ApiAuthController@register');
Route::post('getUserByPhone', 'Auth\ApiAuthController@getUserByPhone');
Route::get('allPermissions', 'Auth\ApiAuthController@allPermissions');
Route::post('logout', 'Auth\ApiAuthController@logout');

//================  Cashier Department  =======================

Route::get('searchUsers', 'Cashier\CashierDepartment@searchUsers');
Route::post('getSingleCashier', 'Cashier\CashierDepartment@getSingleCashier');
Route::post('addNewCashier', 'Cashier\CashierDepartment@add_new_cashier');
Route::post('editCashier', 'Cashier\CashierDepartment@edit_cashier');
Route::post('deleteCashier', 'Cashier\CashierDepartment@delete_cashier');

//================  Product Department  =======================

//category

Route::get('searchCategories', 'Products\ApiCategoryController@searchCategories');
Route::post('getSingleCategory', 'Products\ApiCategoryController@getSingleCategory');
Route::post('addNewCategory', 'Products\ApiCategoryController@addNewCategory');
Route::post('editCategory', 'Products\ApiCategoryController@editCategory');
Route::post('deleteCategory', 'Products\ApiCategoryController@deleteCategory');
Route::post('addProductsToCategory', 'Products\ApiCategoryController@add_products_to_category');

//coupons

Route::get('searchCoupons', 'Products\ApiCouponController@searchCoupons');
Route::post('getSingleCoupon', 'Products\ApiCouponController@getSingleCoupon');
Route::post('addNewCoupon', 'Products\ApiCouponController@addNewCoupon');
Route::post('editCoupon', 'Products\ApiCouponController@editCoupon');
Route::post('deleteCoupon', 'Products\ApiCouponController@deleteCoupon');


//products

Route::post('searchProducts', 'Products\ApiProductController@searchProducts');
Route::post('getSingleProduct', 'Products\ApiProductController@getSingleProduct');
Route::post('getSingleProductByBarcode', 'Products\ApiProductController@getSingleProductByBarcode');
Route::post('addNewProduct', 'Products\ApiProductController@addNewProduct');
Route::post('editProduct', 'Products\ApiProductController@editProduct');
Route::post('deleteProduct', 'Products\ApiProductController@deleteProduct');
Route::get('allCategories', 'Products\ApiProductController@categories');
Route::post('addLocalBarcode', 'Products\ApiProductController@addLocalBarcode');


//================  Client and suppliers Department  =======================

//clients

Route::get('searchClients', 'Clients\ApiClientController@searchClients');
Route::post('getSingleClient', 'Clients\ApiClientController@getSingleClient');
Route::post('addNewClient', 'Clients\ApiClientController@addNewClient');
Route::post('editClient', 'Clients\ApiClientController@editClient');
Route::post('deleteClient', 'Clients\ApiClientController@deleteClient');


//supplier

Route::get('searchSuppliers', 'Clients\ApiSupplierController@searchSuppliers');
Route::post('getSingleSupplier', 'Clients\ApiSupplierController@getSingleSupplier');
Route::post('addNewSupplier', 'Clients\ApiSupplierController@addNewSupplier');
Route::post('editSupplier', 'Clients\ApiSupplierController@editSupplier');
Route::post('deleteSupplier', 'Clients\ApiSupplierController@deleteSupplier');

//================  Sales Department  =======================

//helper

Route::get('allCategoriesInSale', 'Sales\ApiNormalSalesHelperLink@categories');

Route::post('searchProductsInSale', 'Sales\ApiNormalSalesHelperLink@searchProducts');
Route::post('getSingleProductInSale', 'Sales\ApiNormalSalesHelperLink@getSingleProduct');

Route::get('searchCouponsInSale', 'Sales\ApiNormalSalesHelperLink@searchCoupons');
Route::post('getSingleCouponInSale', 'Sales\ApiNormalSalesHelperLink@getSingleCoupon');
Route::post('addNewCouponInSale', 'Sales\ApiNormalSalesHelperLink@addNewCoupon');

Route::get('searchClientsInSale', 'Sales\ApiNormalSalesHelperLink@searchClients');
Route::post('getSingleClientInSale', 'Sales\ApiNormalSalesHelperLink@getSingleClient');
Route::post('addNewClientInSale', 'Sales\ApiNormalSalesHelperLink@addNewClient');


//Sale Order

Route::post('makeSaleOrder', 'Sales\ApiNormalSaleController@makeSaleOrder');
Route::get('allSaleOrders', 'Sales\ApiNormalSaleController@saleOrders');
Route::post('singleSaleOrder', 'Sales\ApiNormalSaleController@single_sale_order');
Route::post('deleteSaleOrder', 'Sales\ApiNormalSaleController@deleteSaleOrder');

//remaining sales 
Route::post('PayBill', 'Sales\PayBillApi@index');

//================  Sales Back Department  =======================

//helper

Route::get('allCategoriesInBackSale', 'BackSales\ApiBackSalesHelperLink@categories');

Route::post('searchProductsInBackSale', 'BackSales\ApiBackSalesHelperLink@searchProducts');
Route::post('getSingleProductInBackSale', 'BackSales\ApiBackSalesHelperLink@getSingleProduct');

Route::get('searchCouponsInBackSale', 'BackSales\ApiBackSalesHelperLink@searchCoupons');
Route::post('getSingleCouponInBackSale', 'BackSales\ApiBackSalesHelperLink@getSingleCoupon');
Route::post('addNewCouponInBackSale', 'BackSales\ApiBackSalesHelperLink@addNewCoupon');

Route::get('searchClientsInBackSale', 'BackSales\ApiBackSalesHelperLink@searchClients');
Route::post('getSingleClientInBackSale', 'BackSales\ApiBackSalesHelperLink@getSingleClient');
Route::post('addNewClientInBackSale', 'BackSales\ApiBackSalesHelperLink@addNewClient');


//Back Sale Order

Route::post('makeBackSaleOrder', 'BackSales\ApiBackSaleController@makeSaleOrder');
Route::get('allBackSaleOrders', 'BackSales\ApiBackSaleController@saleOrders');
Route::post('singleBackSaleOrder', 'BackSales\ApiBackSaleController@single_sale_order');
Route::post('deleteBackSaleOrder', 'BackSales\ApiBackSaleController@deleteSaleOrder');

//================  Purchase  Department  =======================

//helper

Route::get('allCategoriesInPurchase', 'Purchases\ApiNormalPurchaseHelperLink@categories');

Route::post('searchProductsInPurchase', 'Purchases\ApiNormalPurchaseHelperLink@searchProducts');
Route::post('getSingleProductInPurchase', 'Purchases\ApiNormalPurchaseHelperLink@getSingleProduct');


Route::get('searchSuppliersInPurchase', 'Purchases\ApiNormalPurchaseHelperLink@searchSuppliers');
Route::post('getSingleSupplierInPurchase', 'Purchases\ApiNormalPurchaseHelperLink@getSingleSupplier');
Route::post('addNewSupplierInPurchase', 'Purchases\ApiNormalPurchaseHelperLink@addNewSupplier');


//Purchase Order

Route::post('makePurchaseOrder', 'Purchases\ApiNormalPurchaseController@makePurchaseOrder');
Route::get('allPurchaseOrders', 'Purchases\ApiNormalPurchaseController@purchaseOrders');
Route::post('singlePurchaseOrder', 'Purchases\ApiNormalPurchaseController@single_purchase_order');
Route::post('deletePurchaseOrder', 'Purchases\ApiNormalPurchaseController@deletePurchaseOrder');


//================  Back  Purchase  Department  =======================

//helper

Route::get('allCategoriesInBackPurchase', 'BackPurchases\ApiBackPurchaseHelperLink@categories');

Route::post('searchProductsInBackPurchase', 'BackPurchases\ApiBackPurchaseHelperLink@searchProducts');
Route::post('getSingleProductInBackPurchase', 'BackPurchases\ApiBackPurchaseHelperLink@getSingleProduct');


Route::get('searchSuppliersInBackPurchase', 'BackPurchases\ApiBackPurchaseHelperLink@searchSuppliers');
Route::post('getSingleSupplierInBackPurchase', 'BackPurchases\ApiBackPurchaseHelperLink@getSingleSupplier');
Route::post('addNewSupplierInBackPurchase', 'BackPurchases\ApiBackPurchaseHelperLink@addNewSupplier');


// Back Purchase Order

Route::post('makeBackPurchaseOrder', 'BackPurchases\ApiBackPurchaseController@makePurchaseOrder');
Route::get('allBackPurchaseOrders', 'BackPurchases\ApiBackPurchaseController@purchaseOrders');
Route::post('singleBackPurchaseOrder', 'BackPurchases\ApiBackPurchaseController@single_purchase_order');
Route::post('deleteBackPurchaseOrder', 'BackPurchases\ApiBackPurchaseController@deletePurchaseOrder');


//================ Account Department ========================


Route::get('allAccounts', 'Accounts\ApiAccountController@allAccounts');
Route::post('singleAccount', 'Accounts\ApiAccountController@singleAccount');
Route::post('makeAccount', 'Accounts\ApiAccountController@makeAccount');
Route::post('editAccount', 'Accounts\ApiAccountController@editAccount');
Route::post('deleteAccount', 'Accounts\ApiAccountController@deleteAccount');


//================  Expenses Department  =======================

Route::get('allExpenses', 'Expenses\ApiExpenseController@allExpenses');
Route::post('singleExpense', 'Expenses\ApiExpenseController@singleExpense');
Route::post('makeExpense', 'Expenses\ApiExpenseController@makeExpense');
Route::post('editExpense', 'Expenses\ApiExpenseController@editExpense');
Route::post('deleteExpense', 'Expenses\ApiExpenseController@deleteExpense');


//================  Revenues Department  =======================

Route::get('allRevenues', 'Revenues\ApiRevenueController@allRevenues');
Route::post('singleRevenue', 'Revenues\ApiRevenueController@singleRevenue');
Route::post('makeRevenue', 'Revenues\ApiRevenueController@makeRevenue');
Route::post('editRevenue', 'Revenues\ApiRevenueController@editRevenue');
Route::post('deleteRevenue', 'Revenues\ApiRevenueController@deleteRevenue');

//================  Helper Department  =======================

Route::get('getAllColors', 'ApiHelperController@getAllColors');

//================  Helper Department  =======================
//phone token
Route::post('firebase-tokens', 'TokenController@token_update');
Route::post('firebase/token/delete', 'TokenController@token_delete');
//setting
Route::get('app/info', 'ApiSettingController@app_information');
Route::post('contactUs', 'ContactController@contact_us')->name('contactUsFromApi');


//profile
Route::get('currentUser', 'ApiProfileController@getCurrentUserData');
Route::post('profile/update', 'ApiProfileController@update_profile');


//new links

Route::get('allSliders', 'ApiHelperController@getAllSliders');
Route::get('marketData', 'ApiProfileController@marketData');

//=========== reports ======================

// (overview)
Route::get('salesReport', 'reports\SalesReportController@index');
Route::get('earningsReport', 'reports\EarningReportsController@index');
Route::get('mostProductSales', 'reports\MostProductSalesController@index');

//(collection data)
Route::post('salesCollectionReport', 'reports\SaleCollectionController@index');
Route::post('purchaseCollectionReport', 'reports\PurchaseCollectionController@index');


//================  Reports  =======================
Route::get('detailed-sales-report', 'GeneralReports\SalesReportController@detailedSalesReport');
Route::get('an-aggregate-sale-report', 'GeneralReports\SalesReportController@anAggregateSaleReport');
Route::get('report-of-unpaid-sales-invoices', 'GeneralReports\SalesReportController@reportOfUnpaidSalesInvoices');
Route::get('sales-invoices', 'GeneralReports\SalesReportController@salesInvoices');

Route::get('detailed-earnings-report', 'GeneralReports\ProfitsController@detailedEarningsReport');
Route::get('aggregate-earnings-report', 'GeneralReports\ProfitsController@aggregateEarningsReport');


Route::get('report-of-remaining-amounts-customers','GeneralReports\ClientController@reportAemainingAmountsCustomers');
Route::get('client-bills','GeneralReports\ClientController@clientBills');
Route::get('report-products-sold-customer','GeneralReports\ClientController@reportProductsSoldCustomer');

Route::get('report-remaining-amounts-suppliers','GeneralReports\SupplierController@reportRemainingAmountsSuppliers');
Route::get('supplier-invoices','GeneralReports\SupplierController@supplierInvoices');
Route::get('report-products-purchased-supplier','GeneralReports\SupplierController@reportProductsPurchasedSupplier');

// PurchasesReportController
Route::get('detailed-purchase-report', 'GeneralReports\PurchasesController@detailedPurchaseReport');
Route::get('an-aggregate-purchase-report', 'GeneralReports\PurchasesController@anAggregatePurchaseReport');
Route::get('report-of-unpaid-purchase-invoices', 'GeneralReports\PurchasesController@reportOfUnpaidPurchasesInvoices');
Route::get('purchase-invoices', 'GeneralReports\PurchasesController@PurchaseInvoices');

// store
Route::get('store-inventory', 'GeneralReports\StoreController@storeInventory');
Route::get('movement-purchase-price-change-item', 'GeneralReports\StoreController@movementPurchasePriceChangeItem');

// Detailed expense report
Route::get('detailed-expense-report', 'GeneralReports\ExpenseController@detailedExpenseReport');
Route::get('outline-expense-report', 'GeneralReports\ExpenseController@outlineExpenseReport');


// GetPackages
Route::get('GetPackages', 'ApiPackage@GetPackages');

Route::post('getLinkToPay','ApiPackage@get_link_to_pay');
Route::post('paymentIsSuccess','ApiPackage@payment_is_success');
