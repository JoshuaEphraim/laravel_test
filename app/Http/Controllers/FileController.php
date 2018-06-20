<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File as FileTab;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Validator;

class FileController extends Controller
{
    protected $file_full_path='/filesbase';
    public function show()
    {
        $files = FileTab::all();
        return view('file',['files'=>$files]);
    }
    public function getFile(Request $request){
        $response=array();
        $validator = $this->validator($request->all())->validate();
            $url = $request->url;
            if ($content = file_get_contents($url)) {
                $arr_url = explode('/', $url);
                $name = uniqid().array_pop($arr_url);

                if (Storage::disk('public')->put($name, $content)) {
                    $mime = Storage::mimeType($name);
                    $path = Storage::url($name);
                    $fileTab = new FileTab;
                    $fileTab->mime_type = $mime;
                    $fileTab->url = $url;
                    $fileTab->path = $path;
                    if ($res = $fileTab->save()) {
                        $response = $fileTab;
                    }
                }else{
                    $response['error']='The file can`t be stored';
                }
            }else{
                $response['error']='The file can`t be downloaded';
            }

        echo json_encode($response);
    }
    public function deleteFile(Request $request){
        $id=$request->id;
        $file = FileTab::find($id);
        $path=$file->path;
        $arr_path = explode('/', $path);
        $name=array_pop($arr_path);
        if($file->delete())
        {
            Storage::delete($name);
            $response=array('result'=>true,'id'=>$id);
        }else{
            $response=array('result'=>false,'id'=>$id);
        }
        echo json_encode($response);
    }
    public function pushFile($name){
        if($path = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix().$name){
            return response()->download($path);
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'url' => 'required|url|unique:files,url|string|min:5|max:255'
        ]);
    }
}
