<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function login(){
        return response()->view('user.login', [
            'title' => 'login'
        ]);
    }

    public function doLogin(Request $request):Response|RedirectResponse{
        $username = $request->input("username");
        $password = $request->input("password");
        $login = false;

        if($username && $password){
            $login = $this->userService->login($username, $password);
        }

        if(!$login){
            return response()->view('user.login', [
                'title' => 'login',
                'error' => 'failed login invalid username/password'
            ]);
        }else{
            $request->session()->put('username', $username);
            return redirect('/');
        }
    }

    public function doLogout(Request $request): RedirectResponse{
        $request->session()->forget('username');
        return redirect('/');
    }
}
