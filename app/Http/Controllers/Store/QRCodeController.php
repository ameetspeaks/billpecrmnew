<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function qrcode()
    {
        // print_r("hello code"); die;
        return QrCode::generate(
            'Chandan Bisht Created!',
        );

        // $otp = rand(100000, 99999); // generate a random OTP PIN
        // return QrCode::size(250)->generate('url:' . 'upi://pay?pa=chandusingh751@okicici%26am=20%26tn=');

        // return view('store.storeAdmin.qrcodegenerate');
    }
}
