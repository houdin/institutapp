// Route::get('certificates', [CertificateController::class, 'getCertificates'])->name('certificates.index');
// Route::post('certificates/generate', [CertificateController::class, 'generateCertificate'])->name('certificates.generate');

export default [
    {
        name: "frontend.certificates.getVerificationForm",
        path: "/certificate-verification",
        component:
            require("../../../components/certificates/CertificateVerification")
                .default,
        meta: {
            breadcrumb: false,
        },
    },
    {
        name: "certificates.download",
        path: "/certificates/download",
        component:
            require("../../../components/certificates/CertificateVerification")
                .default,
        meta: {
            breadcrumb: false,
        },
    },
];
