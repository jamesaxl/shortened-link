<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Utils\Hash;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (!auth()->attempt($credentials)) {
            return $this->send(__('login.not_correct'), [], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = auth()->user();
        $hashed = $user->getPassword();

        if (Hash::needsRehash($hashed)) {
            $user->setPassword(Hash::make($request->get('password')));

            if ($user->save()) {
                return $this->unAuthorized();
            }
        }

        $data = [
            'token' => $user->createToken(env('PASSPORT_SECRET_KEY'))->accessToken,
            'user' => $user,
        ];

        return $this->send('', $data, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->setEmail($request->get('email'));
        $user->setPassword(Hash::make($request->get('password')));

        if (!$user->save()) {
            return $this->internalError();
        }

        return $this->send(__('user.registered'), $user->toArray(), Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user()->token();
        $user->revoke();

        return $this->send(
            __('user.logged_out'),
            [],
            Response::HTTP_OK
        );
    }
}
