<?php

namespace App\Http\Controllers\API;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class AuthApiController
{

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function login() : JsonResponse
  {
    try {
      throw new Exception(__('index.invalid_login_credentials'), 401);

      // DB::beginTransaction();
      // $validatedData = $request->validated();

      // $data = $this->authService->checkCredential($validatedData);
      // $user = $data['user'];
      // $credentials = array(
      //   $data['credential']['login_type'] => $validatedData['username'],
      //   'password' => $validatedData['password']
      // );

      // if (!$this->getAttempt($credentials)) {
      //   throw new Exception(__('index.invalid_login_credentials'), 401);
      // }


      // $tokens = $user->createToken('MyToken' . $user->id)->accessToken;
      // $validatedData['id'] = $user->id;
      // $this->authService->updateUserLoginDetail($validatedData);
      // DB::commit();
      // return AppHelper::sendSuccessResponse(
      //   __('index.authenticated'),
      //   [
      //     'user' => [
      //       'id' => $user->id,
      //       'name' => $user->name,
      //       'email' => $user->email,
      //       'username' => $user->username,
      //       'workspace_type' => $user->workspace_type,
      //       'avatar' => ($user->avatar) ? asset(User::AVATAR_UPLOAD_PATH . $user->avatar) : asset('assets/images/img.png'),
      //     ],
      //     'tokens' => $tokens
      //   ]
      // );
    } catch (Exception $e) {
      $response = [
        'status' => false,
        'message' => $e->getMessage(),
        'status_code' => $e->getCode(),
      ];

      return response()->json($response, $e->getCode());

      // DB::rollBack();
      // if ($e instanceof ValidationException) {
      //   return AppHelper::sendErrorResponse($e->getMessage(), 422, $e->errors());
      // }
      // if ($e instanceof GuzzleException) {
      //   return AppHelper::sendErrorResponse($e->getMessage(), $e->getCode());
      // }
      // return AppHelper::sendErrorResponse($e->getMessage(), $e->getCode());
    }
  }

}