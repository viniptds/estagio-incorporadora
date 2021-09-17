<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin;
use App\Models\Admin;
use App\Services\ResponseService;
use App\Transformers\Admin\AdminResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        return view("admin.auth.login"); //->with("pass", Hash::make("teste123"));
    }
    public function remember()
    {
        return view("admin.auth.remember");
    }

    public function store(StoreAdmin $request)
    {
        try {
            $admin = $this
                ->admin
                ->create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                ]);
        } catch (Exception $e) {
            return ResponseService::exception('users.store', null, $e);
        }

        return new AdminResource($admin, array('type' => 'store', 'route' => 'admin.auth.store'));

            // return ResponseHelper::error($validator->getMessageBag()->first(), 500);
            // $user = Admin::create([
            //     'name' => $request->input('name'),
            //     'email' => $request->input('email'),
            //     'cpf' => $request->input('cpf'),
            //     'phone' => substr($request->input('phone'), 0, 11),
            //     'password' => Hash::make($request->input('password')),
            //     'status' => 1,
            // ]);
            // $user->save();
            // return ResponseHelper::success($user, __("Retornando usuário"));
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            $token = $this
            ->admin
            ->login($credentials);
        } catch (Exception $e) {
            return ResponseService::exception('admin.auth.login', null, $e);
        }

        return response()->json(compact('token'));
        // if (!Auth::guard("admin")->attempt($request->only(['email', 'password']))) {
        //     // return ResponseHelper::error(__("Credenciais inválidas"), Response::HTTP_UNAUTHORIZED);
        //     return redirect()->route("admin.auth")->with('error', __("Credenciais inválidas"));
        // }

        // $user = Auth::user();

        // // $token = $user->createToken('token')->plainTextToken;
        // // $cookie = cookie("jwt", $token, 60 * 24); //1 dia

        // // return ResponseHelper::success($user, __('Sucesso'));//->withCookie($cookie);

        // return redirect()->route("admin.home");
    }

    public function user()
    {
        return ResponseHelper::success(Auth::user(), __("Retornando usuário"));
    }

    public function forgot(Request $request)
    {
        if (Auth::user()) {
            return ResponseHelper::error(__("Faça logout antes de realizar essa operação"), 403);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error(__("Campos inválidos"), 500);
        }

        $email = $request->input("email");

        $user = Admin::where("email", $email)->first();
        if (!$user) {
            return ResponseHelper::error(__("Usuário não encontrado"), 404);
        }

        Password::sendResetLink($request->all());

        return ResponseHelper::success(null, __("Email de recuperação enviado"));
    }

    public function reset(Request $request)
    {

        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return ResponseHelper::error(__("Token inválido"), 400);
        }

        return ResponseHelper::success(null, __("Senha alterada com sucesso"));
    }

    public function logout(Request $request)
    {
        
            try {
                $this
                ->admin
                ->logout($request->input('token'));
            } catch (Exception $e) {
                return ResponseService::exception('admin.auth.logout',null,$e);
            }
    
            return response(['status' => true,'msg' => 'Deslogado com sucesso'], 200);
        // if (!Auth::check()) {
        //     return ResponseHelper::error(__("Faça logout antes de realizar essa operação"), 403);
        // }

        // // $cookie = Cookie::forget("jwt");
        // // return ResponseHelper::success([], __("Logout feito com sucesso")); //->withCookie($cookie);

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        // return redirect()->route("admin.auth");
    }
}
