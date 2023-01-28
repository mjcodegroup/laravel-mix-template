<?php

namespace App\Http\Controllers;

use Exception;
use App\Actions\UserAction;
use App\Dtos\ResponseDto;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userAction;

    public function __construct(){
        $this->userAction = new UserAction();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $response = $this->userAction->findAll();
            return ResponseDto::success(ResponseDto::OK, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $response = $this->userAction->create($request->all());
            return ResponseDto::success(ResponseDto::CREATED, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $response = $this->userAction->findOne($id);
            return ResponseDto::success(ResponseDto::OK, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try {
            $response = $this->userAction->update($id, $request->all());
            return ResponseDto::success(ResponseDto::OK, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $response = $this->userAction->remove($id);
            return ResponseDto::success(ResponseDto::OK, $response);
        } catch (Exception $e) {
            return ResponseDto::error($e->getMessage(), $e->getCode());
        }
    }
}
