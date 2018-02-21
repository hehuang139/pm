<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WxController extends Controller
{
    protected $token = "hehuang139";
    //
    public function wx(Request $request) {
        try {
            $signature = $request->signature;
            $timestamp = $request->timestamp;
            $nonce = $request->nonce;
            $echostr = $request->echostr;

            $list = [$this->token, $timestamp, $nonce];
            $list->sort();

            $listString = '';
            foreach ($list as $item) {
                $listString = $item . $listString;
            }

            $hashCode = sha1($listString);

            Log::debug('计算出来的hash值为'.$hashCode. '， 请求的signature：'. $signature);

            if ($hashCode === $signature) {
                return $echostr;
            } else {
                return '';
            }
        } catch (\Exception $exception) {
            return '';
        }
    }
}
