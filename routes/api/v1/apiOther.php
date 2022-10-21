<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Backend\CertificateController;
use App\Http\Controllers\Frontend\User\API\OrderController;





Route::post('certificates', [CertificateController::class, 'getCertificates'])->name('certificates.index');
Route::post('certificates/generate', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');

Route::post('certificate-verification', [CertificateController::class, 'getVerificationForm'])->name('frontend.certificates.getVerificationForm');
Route::post('certificate-verification', [CertificateController::class, 'verifyCertificate'])->name('frontend.certificates.verify');
Route::post('certificates/download', [CertificateController::class, 'download'])->name('certificates.download');

//orders API
Route::post('order/invoice/{order}', [OrderController::class, 'show'])->name('shopping.order.invoice.api');


Route::post('/faqs', [HomeController::class, 'getFaqs'])->name('faqs');


/*=============== Theme blades routes ends ===================*/


Route::post('contact', [ContactController::class, 'index'])->name('contact');
Route::post('contact/send', [ContactController::class, 'send'])->name('contact.send');


Route::post('download', [HomeController::class, 'getDownload'])->name('download');


Route::post('teachers', [HomeController::class, 'getTeachers'])->name('teachers.index');
Route::post('teachers/{id}/show', [HomeController::class, 'showTeacher'])->name('teachers.show');


Route::post('app-conf', [HomeController::class, 'appConf'])->name('app.config');

Route::post('newsletter/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
