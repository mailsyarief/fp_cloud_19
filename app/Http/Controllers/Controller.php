<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Routing\Controller as BaseController;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private function tokenValidator($token){

    }


    private function validateToken($token){
        $user = User::where('api_token',$token)->first();
        if($user != null){
            return 1;
        }else{
            return 0;
        }
    }

    public function download($token, $data){
        validateToken($token);
        $path = base64_decode($data);
        return response()->download($path);
    }

    public function convert(Request $request){

        if($request->file() == null && $request->to == null){
            return response($this->setHttpResponse('Parameter Error'), 204);
        }
        
        if(count($request->file()) > 0 ){

            $converto = $request->input('to');
            $data = $request->file('file');
            $filename = time().$data->getClientOriginalName();
            $path = public_path().'/images/raw';
            $data->move($path,$filename);

            $script = "python convert.py ".$filename." ".$converto;
            $output = shell_exec('ls -lart');

            $ip = $_SERVER['SERVER_NAME'];
            


            return response($this->setHttpResponse($process->getOutput()), 200);
        }else{
            return response($this->setHttpResponse('Parameter Error'), 204);
        }
    }


    public function responseDownload(){
        $filename = public_path()."\images"."\\test.png";
        // dd($filename);
        // return $filename;
        return response()->download($filename);
    }

    public function pwd(){
        return $output = shell_exec('pwd');
    }

}
