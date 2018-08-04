<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DB;
use Crypt;
use Validator;

use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *  Create module 
    **/
    public function get_api_store($data,$model,$module)
    {
        $model = new $model($data);

        $res = $model->save();
        
        return $this->response($res,$module,$model->find($model['id']));
    }

    /**
     * Update module
    **/
    public function get_api_update($data,$model,$module,$checker = [])
    {
        $data['id'] = Crypt::decrypt($data['id']);

        $model  = new $model($data);

        $res = $model->find($data['id']);

        if($checker){
        }

        if($res){
            $res->update($data);
        }else{
            $res = false;
        }

        return $this->response($res,$module,$model->find($data['id']));
    }

    /**
     * Bulk Update module
    **/
    public function get_api_bulk_update($data,$model,$module,$col,$ids)
    {

        $model  = new $model($data);
        $res = $model->whereIn($col,$ids);

        if($res){
            $res->update($data);
        }else{
            $res = false;
        }

        return $this->response($res,$module,$model->whereIn($col,$ids)->get());
    }

    /**
     * Delete module
    **/
    public function get_api_destroy($form_data,$model,$module)
    {
        $data = array();
        foreach ($form_data as $key => $value) {
            array_push($data, Crypt::decrypt($value));
        }

        $res = $model
            ->whereIn('id',$data)
            ->update(['deleted_at'=>date('Y-m-d H:i:s')]);

        return $this->response($res,$module,(Object) []);
    }

    /**
     * Restore module
    **/
    public function get_api_restore($form_data,$model,$module)
    {
        $data = array();
        foreach ($form_data as $key => $value) {
            array_push($data, Crypt::decrypt($value));
        }

        $res = $model
            ->whereIn('id',$data)
            ->restore();

        return $this->response($res,$module,(Object) []);

    }

    /**
     * Response module
    **/
    public function response($res,$module,$model,$code = 'EMPTY_RESPONSE_CODE',$message = 'No Record Found'){

        if($res){
            if($model != null && @count($model)){
                return json_encode([
                    'status'   => (int) env('SUCCESS_RESPONSE_CODE'),
                    'message'  => 'success',
                    'module'   => $module,
                    'errors'   => (Object) [],
                    'data'     => $model,
                ]);
            }else{
                return json_encode([
                    'status'   => (int) env($code != null ? $code : 'EMPTY_RESPONSE_CODE' ),
                    'message'  => $message != null ? $message : 'No Record Found',
                    'module'   => $module,
                    'errors'   => (Object) [],
                    'data'     => $model == null ? (Object) [] : $model ,
                ]);
            }


        }else{
            return json_encode([
                'status'   => (int) env($code != null ? $code : 'BAD_REQUEST' ),
                'message'  => $message != null ? $message : 'something went wrong',
                'module'   => $module,
                'errors'   => (Object) [],
                'data'     => $model == null ? (Object) [] : $model ,
            ]);

        }
    }
}
