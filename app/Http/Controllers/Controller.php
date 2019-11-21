<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function convert(Request $request){

        if($request->file() == null && $request->to == null){
            return response($this->setHttpResponse('Parameter Error'), 204);
        }
        
        if(count($request->file()) > 0 ){

            $converto = $request->input('to');
            $data = $request->file('file');
            $filename = time().$data->getClientOriginalName();
            $path = public_path().'/images';
            $data->move($path,$filename);

            $script = public_path()."\sh convert.sh ".$filename." ".$converto;
            // dd($script);
            $process = new Process($script);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            
            // echo $process->getOutput();

            return response($this->setHttpResponse($process->getOutput()), 200);
        }else{
            return response($this->setHttpResponse('Parameter Error'), 204);
        }
    }

    private function setHttpResponse($msg){
        $arr = [
            'message' => $msg
        ];
        return json_encode($arr);
    }


}
