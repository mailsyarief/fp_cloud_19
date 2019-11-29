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

        $str = base64_decode($data);
        $json = json_decode($str);
        $local = url('/');
        // dd($json);
        if($local == $json->origin){
            // dd($json);
            $img = public_path()."\\".$json->onlyname.".".$json->to;
            return response()->download($img)->deleteFileAfterSend(true);
        }else{

            $img = $json->filename;
            file_put_contents($img, file_get_contents($json->url));    
            return response()->download($img)->deleteFileAfterSend(true);        
        }
    }

    public function convert(Request $request){

        if($request->file() == null && $request->to == null){
            
        }
        
        if(count($request->file()) > 0 ){

            $converto = $request->input('to');
            $data = $request->file('file');
            $filename = time().$data->getClientOriginalName();
            $name_only = pathinfo($filename,PATHINFO_FILENAME);
            // dd($name_only);
            $path = public_path().'/images/raw';
            $data->move($path,$filename);
            // $data->move(public_path(),$filename);

            $script = "sudo cp /images/raw/".$filename." ".$name_only.".".$converto;
            // dd($script);
            $output = shell_exec($script);
            $url = asset($filename);

            $data = [   
                "origin" => url('/'),
                "url" => $url,
                "filename" => $filename,
                "onlyname" => $name_only,
                "to" => $request->to
            ];

            $json =  json_encode($data);            
            $base = base64_encode($json);
            $link = url('/')."/".$request->api_token."/".$base;
            return json_encode($link);
            
        }else{
            
        }
    }


    public function responseDownload($str){
        $str = base64_decode($str);
        $str = "http://localhost:1234/images/test.png";
        $img = 'temp.png';
        file_put_contents($img, file_get_contents($str));

        return response()->download($img)->deleteFileAfterSend(true);
    }

    public function pwd(){
        return $output = shell_exec('pwd');
    }

}
