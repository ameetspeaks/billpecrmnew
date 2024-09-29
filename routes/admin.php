<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CentralLibraryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\CoupanController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\TemplateCategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TemplateTypeController;
use App\Http\Controllers\Admin\SubUnitController;
use App\Http\Controllers\Admin\PromotionalBannerController;
use App\Http\Controllers\Admin\HomepageVideoController;
use App\Http\Controllers\Admin\TutorialController;
use App\Http\Controllers\Admin\ZoneController;
use App\Http\Controllers\Admin\SubZoneController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\LoyaltyPointController;
use App\Http\Controllers\Admin\CustomerCoupanController;
use App\Http\Controllers\Admin\ChargesController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DeliveryPartnerController;
use App\Http\Controllers\Admin\ShiftTimingsController;

use App\Http\Controllers\Admin\CustomerBannerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['as' => 'admin.'], function () {

        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('loginInsert', [AuthController::class, 'loginInsert'])->name('login.insert');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

        //Dashboard
        Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('adminLogin');
        Route::get('store-Details', [DashboardController::class, 'storeDetails'])->name('storeDetails')->middleware('adminLogin');
        Route::get('TotalBill-History', [DashboardController::class, 'totalbilldetail'])->name('totalbilldetail')->middleware('adminLogin');
        Route::get('viewTable', [DashboardController::class, 'viewTable'])->name('viewTable')->middleware('adminLogin');
        Route::get('trialStoreDetails', [DashboardController::class, 'trialStoreDetails'])->name('trialStoreDetails')->middleware('adminLogin');
        Route::get('viewTrialUser', [DashboardController::class, 'viewTrialUser'])->name('viewTrialUser')->middleware('adminLogin');
        Route::get('activity', [DashboardController::class, 'activity'])->name('activity')->middleware('adminLogin');
        Route::get('totalPaidUser', [DashboardController::class, 'totalPaidUser'])->name('totalPaidUser')->middleware('adminLogin');
        Route::get('exportPaidUser', [DashboardController::class, 'exportPaidUser'])->name('exportPaidUser');
        Route::get('exportTrialUser', [DashboardController::class, 'exportTrialUser'])->name('exportTrialUser');

        //permission
        Route::get('permission', [PermissionsController::class, 'index'])->name('permission.index')->middleware('adminLogin');
        Route::get('addPermission', [PermissionsController::class, 'add'])->name('permission.add')->middleware('adminLogin');
        Route::post('storePermission', [PermissionsController::class, 'store'])->name('permission.store');
        Route::get('getPermissionDatatable', [PermissionsController::class, 'getDatatable'])->name('permission.getDatatable')->middleware('adminLogin');

        //Role
        Route::get('role', [RoleController::class, 'index'])->name('role.index')->middleware('adminLogin');
        Route::get('addRole', [RoleController::class, 'add'])->name('role.add')->middleware('adminLogin');
        Route::post('storeRole', [RoleController::class, 'store'])->name('role.store');
        Route::get('editRole/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware('adminLogin');
        Route::post('updateRole', [RoleController::class, 'update'])->name('role.update');
        Route::get('getRoleDatatable', [RoleController::class, 'getDatatable'])->name('role.getDatatable')->middleware('adminLogin');

        //User
        Route::get('user', [UserController::class, 'index'])->name('user.index')->middleware('adminLogin');
        Route::get('addUser', [UserController::class, 'add'])->name('user.add')->middleware('adminLogin');
        Route::post('storeUser', [UserController::class, 'store'])->name('user.store');
        Route::get('editUser/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware('adminLogin');
        Route::post('updateNewUser', [UserController::class, 'update'])->name('user.update');
        Route::get('exportUser', [UserController::class, 'export'])->name('user.export');

        //Module
        Route::get('module', [ModuleController::class, 'index'])->name('module.index')->middleware('adminLogin');
        Route::get('addModule', [ModuleController::class, 'add'])->name('module.add')->middleware('adminLogin');
        Route::post('storeModule', [ModuleController::class, 'store'])->name('module.store');
        Route::get('editModule/{id}', [ModuleController::class, 'edit'])->name('module.edit')->middleware('adminLogin');
        Route::post('updateModule', [ModuleController::class, 'update'])->name('module.update');
        Route::get('getModuleDatatable', [ModuleController::class, 'getDatatable'])->name('module.getDatatable')->middleware('adminLogin');
        Route::post('changeOnlineStatus', [ModuleController::class, 'changeOnlineStatus'])->name('module.changeOnlineStatus');

        //Store
        Route::get('store', [StoreController::class, 'index'])->name('store.index')->middleware('adminLogin');
        Route::get('addStore', [StoreController::class, 'add'])->name('store.add')->middleware('adminLogin');
        Route::get('getStoreDatatable', [StoreController::class, 'getDatatable'])->name('store.getDatatable')->middleware('adminLogin');
        Route::post('storeStore', [StoreController::class, 'store'])->name('store.store');
        Route::get('editStore/{id}', [StoreController::class, 'edit'])->name('store.edit')->middleware('adminLogin');
        Route::post('updateStore', [StoreController::class, 'update'])->name('store.update');
        Route::get('deleteStore/{id}', [StoreController::class, 'delete'])->name('store.delete')->middleware('adminLogin');
        Route::get('exportStore', [StoreController::class, 'export'])->name('store.export');
        Route::get('manualPayment', [StoreController::class, 'manualPayment'])->name('store.manualPayment')->middleware('adminLogin');
        Route::post('add-manualPayment', [StoreController::class, 'addManualPayment'])->name('store.addManualPayment');
        Route::post('getCoupanByCode', [StoreController::class, 'getCoupanByCode'])->name('store.getCoupanByCode');
        Route::get('Bill-History', [StoreController::class, 'billHistory'])->name('store.billHistory')->middleware('adminLogin');

        Route::get('Withdrawal', [StoreController::class, 'withdrawal'])->name('store.withdrawal')->middleware('adminLogin');

        //Subscription
        Route::get('subscription', [SubscriptionController::class, 'index'])->name('subscription.index')->middleware('adminLogin');
        Route::get('addSubscription', [SubscriptionController::class, 'add'])->name('subscription.add')->middleware('adminLogin');
        Route::post('storeSubscription', [SubscriptionController::class, 'store'])->name('subscription.store');
        Route::get('editSubscription/{id}', [SubscriptionController::class, 'edit'])->name('subscription.edit')->middleware('adminLogin');
        Route::post('updateSubscription', [SubscriptionController::class, 'update'])->name('subscription.update');
        Route::get('getSubscriptionDatatable', [SubscriptionController::class, 'getDatatable'])->name('subscription.getDatatable')->middleware('adminLogin');
        Route::get('deleteSubscription/{id}', [SubscriptionController::class, 'delete'])->name('subscription.delete')->middleware('adminLogin');

        //Addon
        Route::get('addon', [AddonController::class, 'index'])->name('addon.index')->middleware('adminLogin');
        Route::get('addAddon', [AddonController::class, 'add'])->name('addon.add')->middleware('adminLogin');
        Route::get('getAddonDatatable', [AddonController::class, 'getDatatable'])->name('addon.getDatatable')->middleware('adminLogin');
        Route::post('storeAddon', [AddonController::class, 'store'])->name('addon.store');
        Route::get('editAddon/{id}', [AddonController::class, 'edit'])->name('addon.edit')->middleware('adminLogin');
        Route::post('updateAddon', [AddonController::class, 'update'])->name('addon.update');
        Route::get('deleteAddon/{id}', [AddonController::class, 'delete'])->name('addon.delete')->middleware('adminLogin');

        //Attribute
        Route::get('attribute', [AttributeController::class, 'index'])->name('attribute.index')->middleware('adminLogin');
        Route::get('addAttribute', [AttributeController::class, 'add'])->name('attribute.add')->middleware('adminLogin');
        Route::post('storeAttribute', [AttributeController::class, 'store'])->name('attribute.store');
        Route::get('editAttribute/{id}', [AttributeController::class, 'edit'])->name('attribute.edit')->middleware('adminLogin');
        Route::post('updateAttribute', [AttributeController::class, 'update'])->name('attribute.update');
        Route::get('getAttributeDatatable', [AttributeController::class, 'getDatatable'])->name('attribute.getDatatable')->middleware('adminLogin');
        Route::get('deleteAttribute/{id}', [AttributeController::class, 'delete'])->name('attribute.delete')->middleware('adminLogin');

        //Unit
        Route::get('unit', [UnitController::class, 'index'])->name('unit.index')->middleware('adminLogin');
        Route::get('addUnit', [UnitController::class, 'add'])->name('unit.add')->middleware('adminLogin');
        Route::post('storeUnit', [UnitController::class, 'store'])->name('unit.store');
        Route::get('editUnit/{id}', [UnitController::class, 'edit'])->name('unit.edit')->middleware('adminLogin');
        Route::post('updateUnit', [UnitController::class, 'update'])->name('unit.update');
        Route::get('getUnitDatatable', [UnitController::class, 'getDatatable'])->name('unit.getDatatable')->middleware('adminLogin');
        Route::get('deleteUnit/{id}', [UnitController::class, 'delete'])->name('unit.delete')->middleware('adminLogin');

        //SubUnit
        Route::get('SubUnit', [SubUnitController::class, 'index'])->name('subunit.index')->middleware('adminLogin');
        Route::get('Add-SubUnit', [SubUnitController::class, 'add'])->name('subunit.add')->middleware('adminLogin');
        Route::post('Store-SubUnit', [SubUnitController::class, 'store'])->name('subunit.store');
        Route::get('editSubUnit/{id}', [SubUnitController::class, 'edit'])->name('subunit.edit')->middleware('adminLogin');
        Route::post('Update-SubUnit', [SubUnitController::class, 'update'])->name('subunit.update');

        //Category
        Route::get('category', [CategoryController::class, 'index'])->name('category.index')->middleware('adminLogin');
        Route::get('addCategory', [CategoryController::class, 'add'])->name('category.add')->middleware('adminLogin');
        Route::post('storeCategory', [CategoryController::class, 'store'])->name('category.store');
        Route::get('editCategory/{id}', [CategoryController::class, 'edit'])->name('category.edit')->middleware('adminLogin');
        Route::post('updateCategory', [CategoryController::class, 'update'])->name('category.update');
        Route::get('getCategoryDatatable', [CategoryController::class, 'getDatatable'])->name('category.getDatatable')->middleware('adminLogin');
        Route::get('deleteCategory/{id}', [CategoryController::class, 'delete'])->name('category.delete')->middleware('adminLogin');

        //sub Category
        Route::get('subcategory', [SubCategoryController::class, 'index'])->name('subcategory.index')->middleware('adminLogin');
        Route::get('addSubCategory', [SubCategoryController::class, 'add'])->name('subcategory.add')->middleware('adminLogin');
        Route::post('storeSubCategory', [SubCategoryController::class, 'store'])->name('subcategory.store');
        Route::get('editSubCategory/{id}', [SubCategoryController::class, 'edit'])->name('subcategory.edit')->middleware('adminLogin');
        Route::post('updateSubCategory', [SubCategoryController::class, 'update'])->name('subcategory.update');
        Route::get('getSubCategoryDatatable', [SubCategoryController::class, 'getDatatable'])->name('subcategory.getDatatable')->middleware('adminLogin');
        Route::get('deleteSubCategory/{id}', [CategoryController::class, 'delete'])->name('subcategory.delete')->middleware('adminLogin');

        //product
        Route::get('product', [ProductController::class, 'index'])->name('product.index')->middleware('adminLogin');
        Route::get('addProduct', [ProductController::class, 'add'])->name('product.add')->middleware('adminLogin');
        Route::get('getCategory/{id}', [ProductController::class, 'getCategory'])->name('product.getCategory')->middleware('adminLogin');
        Route::get('getsubCategory/{id}', [ProductController::class, 'getsubCategory'])->name('product.getsubCategory')->middleware('adminLogin');
        Route::get('getUnit/{id}', [ProductController::class, 'getUnit'])->name('product.getUnit')->middleware('adminLogin');
        Route::post('storeProduct', [ProductController::class, 'store'])->name('product.store');
        Route::get('editProduct/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware('adminLogin');
        Route::post('updateProduct', [ProductController::class, 'update'])->name('product.update');
        Route::get('getProductDatatable', [ProductController::class, 'getDatatable'])->name('product.getDatatable')->middleware('adminLogin');
        Route::get('deleteProduct/{id}', [ProductController::class, 'delete'])->name('product.delete')->middleware('adminLogin');

        //Central Library Product
        Route::get('centralLibrary', [CentralLibraryController::class, 'index'])->name('centralLibrary.index')->middleware('adminLogin');
        Route::post('centralLibraryImport', [CentralLibraryController::class, 'import'])->name('centralLibrary.import');
        Route::get('centralLibraryExport', [CentralLibraryController::class, 'export'])->name('centralLibrary.export');
        Route::get('addCentralProduct', [CentralLibraryController::class, 'add'])->name('centralLibrary.add')->middleware('adminLogin');
        Route::post('storeCentralProduct', [CentralLibraryController::class, 'store'])->name('centralLibrary.store');
        Route::get('editCentralProduct/{id}', [CentralLibraryController::class, 'edit'])->name('centralLibrary.edit')->middleware('adminLogin');
        Route::post('updateCentralProduct', [CentralLibraryController::class, 'update'])->name('centralLibrary.update');
        Route::get('deleteCentralLibrary/{id}', [CentralLibraryController::class, 'delete'])->name('centralLibrary.delete')->middleware('adminLogin');
        Route::get('getCentralLibraryDatatable', [CentralLibraryController::class, 'getDatatable'])->name('centralLibrary.getDatatable')->middleware('adminLogin');
        Route::post('changeStatus', [CentralLibraryController::class, 'changeStatus'])->name('centralLibrary.changeStatus');
        Route::post('changeFeatured', [CentralLibraryController::class, 'changeFeatured'])->name('centralLibrary.changeFeatured');
        Route::post('exportByModule', [CentralLibraryController::class, 'exportByModule'])->name('centralLibrary.exportByModule');
        
        //gallery
        Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index')->middleware('adminLogin');
        Route::get('addGallery', [GalleryController::class, 'add'])->name('gallery.add')->middleware('adminLogin');
        Route::post('storeGallery', [GalleryController::class, 'store'])->name('gallery.store');

        //notification
        Route::get('notification', [NotificationController::class, 'index'])->name('notification')->middleware('adminLogin');
        Route::get('notificationSend', [NotificationController::class, 'send'])->name('notification.send')->middleware('adminLogin');
        Route::post('send-notification', [NotificationController::class, 'sendnotification'])->name('notification.send-notification');
        Route::get('getnotificationDatatable', [NotificationController::class, 'getDatatable'])->name('notification.getDatatable')->middleware('adminLogin');

        //Coupan
        Route::get('coupan', [CoupanController::class, 'index'])->name('coupan.index')->middleware('adminLogin');
        Route::get('addCoupan', [CoupanController::class, 'add'])->name('coupan.add')->middleware('adminLogin');
        Route::post('storeCoupan', [CoupanController::class, 'store'])->name('coupan.store');
        Route::get('getCoupanDatatable', [CoupanController::class, 'getDatatable'])->name('coupan.getDatatable')->middleware('adminLogin');
        Route::get('deleteCoupan/{id}', [CoupanController::class, 'delete'])->name('coupan.delete')->middleware('adminLogin');

        Route::post('getStoreByPackage', [CoupanController::class, 'getStoreByPackage'])->name('getStoreByPackage');

        //Template
                Route::get('categoryTemplate', [TemplateCategoryController::class, 'category'])->name('template.category')->middleware('adminLogin');
                Route::get('addcategoryTemplate', [TemplateCategoryController::class, 'add'])->name('template.category.add')->middleware('adminLogin');
                Route::post('storeCategoryTemplate', [TemplateCategoryController::class, 'store'])->name('template.category.store');
                Route::get('getDatatable', [TemplateCategoryController::class, 'getDatatable'])->name('template.category.getDatatable')->middleware('adminLogin');
                Route::get('editTemplateCategory/{id}', [TemplateCategoryController::class, 'edit'])->name('template.category.edit')->middleware('adminLogin');
                Route::post('updateTemplateCategory', [TemplateCategoryController::class, 'update'])->name('template.category.update');

                Route::get('Template-Type', [TemplateTypeController::class, 'templateType'])->name('template.type')->middleware('adminLogin');
                Route::get('Add-TemplateType', [TemplateTypeController::class, 'add'])->name('template.type.add')->middleware('adminLogin');
                Route::post('Store-TemplateType', [TemplateTypeController::class, 'store'])->name('template.type.store');
                Route::get('Edit-TemplateType/{id}', [TemplateTypeController::class, 'edit'])->name('template.type.edit')->middleware('adminLogin');
                Route::post('Update-TemplateType', [TemplateTypeController::class, 'update'])->name('template.type.update');

                Route::get('marketing', [TemplateController::class, 'marketing'])->name('template.marketing')->middleware('adminLogin');
                Route::get('marketingAdd', [TemplateController::class, 'marketingAdd'])->name('template.marketing.add')->middleware('adminLogin');
                Route::post('storeMarketing', [TemplateController::class, 'marketingStore'])->name('template.marketing.store');
                Route::get('fetchMarketGallery/{id}', [TemplateController::class, 'fetchMarketGallery'])->name('template.marketing.fetchMarketGallery')->middleware('adminLogin');

                Route::get('offer', [TemplateController::class, 'offer'])->name('template.offer')->middleware('adminLogin');
                Route::get('offerAdd', [TemplateController::class, 'offerAdd'])->name('template.offer.add')->middleware('adminLogin');
                Route::post('storeOffer', [TemplateController::class, 'offerStore'])->name('template.offer.store');
                Route::get('fetchOfferGallery/{id}', [TemplateController::class, 'fetchOfferGallery'])->name('template.offer.fetchOfferGallery')->middleware('adminLogin');

        //End Template

        //settting
        Route::get('setting', [SettingController::class, 'index'])->name('setting')->middleware('adminLogin');
        Route::post('updateUser', [SettingController::class, 'updateUser'])->name('setting.updateUser');
        Route::post('updatesetup', [SettingController::class, 'updatesetup'])->name('setting.updatesetup');

        //BLog
                Route::get('Category-Blog', [BlogCategoryController::class, 'index'])->name('blog.category')->middleware('adminLogin');
                Route::get('Add-CategoryBlog', [BlogCategoryController::class, 'add'])->name('blog.category.add')->middleware('adminLogin');
                Route::post('Store-Blog', [BlogCategoryController::class, 'store'])->name('blog.category.store');
                Route::get('editBlogCategory/{id}', [BlogCategoryController::class, 'edit'])->name('blog.category.edit')->middleware('adminLogin');
                Route::post('Update-CategoryBlog', [BlogCategoryController::class, 'update'])->name('blog.category.update');
                Route::get('Delete-BlogCategory/{id}', [BlogCategoryController::class, 'delete'])->name('blog.category.delete')->middleware('adminLogin');

                Route::get('Blog', [BlogController::class, 'index'])->name('blog.index')->middleware('adminLogin');
                Route::get('Add-Blog', [BlogController::class, 'add'])->name('blog.add')->middleware('adminLogin');
                Route::post('Store-Blog', [BlogController::class, 'store'])->name('blog.store');
                Route::get('editBlog/{id}', [BlogController::class, 'edit'])->name('blog.edit')->middleware('adminLogin');
                Route::post('Update-Blog', [BlogController::class, 'update'])->name('blog.update');
                Route::get('Delete-Blog/{id}', [BlogController::class, 'delete'])->name('blog.delete')->middleware('adminLogin');
                Route::post('Blog-Image-Upload', [BlogController::class, 'uploadImage'])->name('blog.image.upload');
                Route::post('Blog-Image-Delete', [BlogController::class, 'deleteImage'])->name('blog.image.delete');

        //End Blog

        //Banner
                Route::get('Promotional-Banner', [PromotionalBannerController::class, 'index'])->name('promotionalBanner.index')->middleware('adminLogin');
                Route::get('Add-Promotional-Banner', [PromotionalBannerController::class, 'add'])->name('promotionalBanner.add')->middleware('adminLogin');
                Route::post('Store-Promotional-Banner', [PromotionalBannerController::class, 'store'])->name('promotionalBanner.store');
                Route::get('editPromotionBanner/{id}', [PromotionalBannerController::class, 'edit'])->name('promotionalBanner.edit')->middleware('adminLogin');
                Route::post('Store-Promotional-Update', [PromotionalBannerController::class, 'update'])->name('promotionalBanner.update');
                Route::get('Promotional-Delete/{id}', [PromotionalBannerController::class, 'delete'])->name('promotionalBanner.delete');
        //End Banner

        //Homepage Video
                Route::get('Homepage-Video', [HomepageVideoController::class, 'index'])->name('homepagevideo.index')->middleware('adminLogin');
                Route::get('Homepage-Video-Add', [HomepageVideoController::class, 'add'])->name('homepagevideo.add')->middleware('adminLogin');
                Route::post('Store-Homepage-Video', [HomepageVideoController::class, 'store'])->name('homepagevideo.store');
                Route::get('editHomepageVideo/{id}', [HomepageVideoController::class, 'edit'])->name('homepagevideo.edit')->middleware('adminLogin');
                Route::post('Update-Homepage-Video', [HomepageVideoController::class, 'update'])->name('homepagevideo.update');
                Route::get('Delete-Homepage-Video/{id}', [HomepageVideoController::class, 'delete'])->name('homepagevideo.delete');
        //End Homepage Video

        //Tutorial
                Route::get('Tutorial', [TutorialController::class, 'index'])->name('tutorial.index')->middleware('adminLogin');
                Route::get('Tutorial-Add', [TutorialController::class, 'add'])->name('tutorial.add')->middleware('adminLogin');
                Route::post('Store-Tutorial', [TutorialController::class, 'store'])->name('tutorial.store');
                Route::get('editTutorial/{id}', [TutorialController::class, 'edit'])->name('tutorial.edit')->middleware('adminLogin');
                Route::post('Update-Tutorial', [TutorialController::class, 'update'])->name('tutorial.update');
                Route::get('Delete-Tutorial/{id}', [TutorialController::class, 'delete'])->name('tutorial.delete');
        //End Tutorial

        Route::get('Downlaod-pdf', [DashboardController::class, 'dwnloadpdf']);


        //zone
                Route::get('Zone', [ZoneController::class, 'index'])->name('zone.index')->middleware('adminLogin');
                Route::get('Zone-Add', [ZoneController::class, 'add'])->name('zone.add')->middleware('adminLogin');
                Route::post('Store-Zone', [ZoneController::class, 'store'])->name('zone.store');
                Route::get('editZone/{id}', [ZoneController::class, 'edit'])->name('zone.edit')->middleware('adminLogin');
                Route::post('Update-Zone', [ZoneController::class, 'update'])->name('zone.update');

                Route::get('Assign', [ZoneController::class, 'assignZone'])->name('zone.assignZone');
                Route::post('Assign-Update', [ZoneController::class, 'assignstoreupdate'])->name('zone.assignstoreupdate');
                Route::get('SubZone', [SubZoneController::class, 'index'])->name('subzone.index')->middleware('adminLogin');
                Route::get('SubZone-Add', [SubZoneController::class, 'add'])->name('subzone.add')->middleware('adminLogin');
                Route::post('Store-SubZone', [SubZoneController::class, 'store'])->name('subzone.store');
                Route::get('editSubZone/{id}', [SubZoneController::class, 'edit'])->name('subzone.edit')->middleware('adminLogin');
                Route::post('Update-SubZone', [SubZoneController::class, 'update'])->name('subzone.update');
        //

        //chat
                Route::get('chat', [ChatController::class, 'chat'])->name('chat')->middleware('adminLogin');
                Route::get('chatUsers', [ChatController::class, 'chatUsers'])->name('chatUsers')->middleware('adminLogin');

                Route::post('getchat', [ChatController::class, 'getchat'])->name('chat.getchat');

        //

        //loyaltypoint
                Route::get('LoyaltyPoint', [LoyaltyPointController::class, 'index'])->name('loyaltypoint.index')->middleware('adminLogin');
                Route::get('Add-LoyaltyPoint', [LoyaltyPointController::class, 'add'])->name('loyaltypoint.add')->middleware('adminLogin');
                Route::post('Store-LoyaltyPoint', [LoyaltyPointController::class, 'store'])->name('loyaltypoint.store');
                Route::get('editLoyalty/{id}', [LoyaltyPointController::class, 'edit'])->name('loyaltypoint.edit')->middleware('adminLogin');
                Route::post('Update-LoyaltyPoint', [LoyaltyPointController::class, 'update'])->name('loyaltypoint.update');
                Route::get('Delete_Loyalty/{id}', [LoyaltyPointController::class, 'delete'])->name('loyaltypoint.delete')->middleware('adminLogin');
        //

       // customerCoupan
                Route::get('CustomerCoupan', [CustomerCoupanController::class, 'index'])->name('customerCoupan.index')->middleware('adminLogin');
                Route::get('Add-CustomerCoupan', [CustomerCoupanController::class, 'add'])->name('customerCoupan.add')->middleware('adminLogin');
                Route::post('Store-CustomerCoupan', [CustomerCoupanController::class, 'store'])->name('customerCoupan.store');
                Route::get('Delete-CustomerCoupan/{id}', [CustomerCoupanController::class, 'delete'])->name('customerCoupan.delete')->middleware('adminLogin');
                Route::post('Get-SubZone', [CustomerCoupanController::class, 'getSubZone'])->name('customerCoupan.getSubZone');
                Route::post('Get-CategoryStore', [CustomerCoupanController::class, 'getCategoryandStore'])->name('customerCoupan.getCategoryandStore');
        //

        //charges
                Route::get('Charges', [ChargesController::class, 'index'])->name('charges.index')->middleware('adminLogin');
                Route::get('Add-Charges', [ChargesController::class, 'add'])->name('charges.add')->middleware('adminLogin');
                Route::post('Store-Charges', [ChargesController::class, 'store'])->name('charges.store');
                Route::get('editCharge/{id}', [ChargesController::class, 'edit'])->name('charges.edit')->middleware('adminLogin');
                Route::post('update-Charges', [ChargesController::class, 'update'])->name('charges.update');
                Route::get('Delete-Charges/{id}', [ChargesController::class, 'delete'])->name('charges.delete')->middleware('adminLogin');
        //

        //Customer order
                Route::get('All-Order', [OrderController::class, 'allOrder'])->name('order.allOrder')->middleware('adminLogin');
                Route::get('Order-Tracking', [OrderController::class, 'orderTracking'])->name('order.tracking')->middleware('adminLogin');
                Route::post('/order/update-status', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus')->middleware('adminLogin');

                Route::get('ViewOrder/{id}', [OrderController::class, 'viewOrder'])->name('order.viewOrder')->middleware('adminLogin');
                Route::post('OrderStatusChange', [OrderController::class, 'orderStatusChange'])->name('order.orderStatusChange');
                Route::post('AssignTo-DeliveryBoy', [OrderController::class, 'assignOrderToDeliveryBoy'])->name('order.assignOrderToDeliveryBoy');
        //

        //customerbanner
                Route::get('Customer-Banner', [CustomerBannerController::class, 'index'])->name('customerbanner.index')->middleware('adminLogin');
                Route::get('Add-Customerbanner', [CustomerBannerController::class, 'add'])->name('customerbanner.add')->middleware('adminLogin');
                Route::post('Store-customerbanner', [CustomerBannerController::class, 'store'])->name('customerbanner.store');
                Route::get('editCustomerBanner/{id}', [CustomerBannerController::class, 'edit'])->name('customerbanner.edit')->middleware('adminLogin');
                Route::post('update-customerbanner', [CustomerBannerController::class, 'update'])->name('customerbanner.update');
                Route::get('Delete-customerbanner/{id}', [CustomerBannerController::class, 'delete'])->name('customerbanner.delete')->middleware('adminLogin');
        //

        //shiftTimings
                Route::get('shift-timings', [ShiftTimingsController::class, 'index'])->name('shiftTimings.index')->middleware('adminLogin');
                Route::get('shift-timings/edit/{id}', [ShiftTimingsController::class, 'edit'])->name('shiftTimings.edit')->middleware('adminLogin');
                Route::get('shift-timings/delete/{id}', [ShiftTimingsController::class, 'delete'])->name('shiftTimings.delete')->middleware('adminLogin');
                Route::get('shift-timings/add', [ShiftTimingsController::class, 'add'])->name('shiftTimings.add')->middleware('adminLogin');
                Route::post('shift-timings/insert', [ShiftTimingsController::class, 'insert'])->name('shiftTimings.insert')->middleware('adminLogin');
                Route::post('shift-timings/update', [ShiftTimingsController::class, 'update'])->name('shiftTimings.update')->middleware('adminLogin');
        //

        //deliveryPartner
                Route::get('delivery-partner', [DeliveryPartnerController::class, 'index'])->name('deliveryPartner.index')->middleware('adminLogin');
                Route::get('viewDeliveryPartner/{id}', [DeliveryPartnerController::class, 'view'])->name('deliveryPartner.view')->middleware('adminLogin');
                Route::post('accountStatusChange', [DeliveryPartnerController::class, 'accountStatusChange'])->name('deliveryPartner.accountStatusChange')->middleware('adminLogin');
        //

});
