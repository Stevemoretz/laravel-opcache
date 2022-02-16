<?php

namespace SteveMoretz\LaravelOpcacheClear;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class OpcacheClearController extends Controller {
    protected function opcacheClear(Request $request) {
        $original = config("app.key");


        $result = false;
        $reason = null;

        $decrypted = null;

        try {
            $decrypted = Crypt::decrypt($request->get("token"));
        } catch (DecryptException $e) {
        }

        if (!function_exists("opcache_reset")) {
            $result = false;
            $reason = "Looke like opcache is not enabled!";
        } elseif ($decrypted == $original) {
            if($request->has("update_file")){
                $updated_file = $request->get( "update_file" );
                if(file_exists($updated_file)){
                    opcache_invalidate( $updated_file );
                    opcache_compile_file( $updated_file );
                }
                $result = true;
            }else{
                if(opcache_reset()){
                    $result = true;
                }
            }
        }

        return response()->json(compact("result", "reason"));
    }
}
