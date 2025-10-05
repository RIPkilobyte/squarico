<?php

namespace App\Http\Controllers;

use App\Mail\AccountActivation;
use App\Models\Log;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Fortify;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register', ['title' => 'Registration']);
    }

    public function registerStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'firstName' => ['required', 'max:255'],
            'lastName' => ['required', 'max:255'],
            'email' => ['required', 'email:rfc,dns',
                Rule::unique('users')->where(function ($query) use($input) {
                    return $query->where('email', $input['email'])
                    ->where('deleted', 'false');
                })
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'password' => [
                'required',
                'string',
                'min:8',
                // 'regex:/[a-z]/',
                // 'regex:/[A-Z]/',
                'regex:/[0-9]/',
                // 'regex:/[@$!%*#?&]/',
            ],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        /**** Проверка капчи ****/
        // Ваш секретный ключ
        $secretKey = "6LcciGQpAAAAAK8B-5PckUwGLPyZ-wtw7Z66-RWO";
        $recaptchaResponse = $_POST['recaptcha_response'];

        // Подготавливаем запрос к API
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = http_build_query(array(
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ));
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);

        if (!$result->success || $result->score < 0.5) {
            $request->session()->flash('error', 'You did not pass the captcha verification.');
            return back();
        }
        /**** Конец проверки капчи ****/


        $user = new User();
        $user->first_name = $input['firstName'];
        $user->last_name = $input['lastName'];
        $user->email = $input['email'];
        $user->phone = $input['phone'];
        $user->role = 'User';
        $user->password = Hash::make($input['password']);
        $user->attention = true;
        $user->save();

        $log = new Log();
        $log->user_id = $user->id;
        $log->action_user_id = $user->id;
        $log->user_type = $user->role;
        $log->user_name = $user->first_name.' '.$user->last_name;
        $log->action = 'Profile registration';
        $log->save();

        try {
            event(new Registered($user));
            //Mail::to($user->email)->send(new AccountActivation($user->first_name.' '.$user->last_name, $input['password']));
        }
        catch (Exception $e) {}
        Auth::logout();
        //$this->guard()->login($user);

        return redirect()->route('register.complete');
    }

    public function investorType(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $redirect = $input['redirect'] ?? 'register';
        return view('user.investor',[
            'title' => 'Investor type',
            'redirect' => $redirect,
            'user' => $user,
        ]);
    }

    public function investorTypeStore(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'type' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->investor_type = $input['type'];
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action_user_id = Auth::user()->id;
        $log->user_type = Auth::user()->role;
        $log->user_name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $log->action = 'User change investor type';
        $log->save();

        if ($input['redirect'] == 'register') {
            return redirect()->route('details');
        } else {
            return redirect()->route('investor.complete');
        }
    }

    public function investorTypeText($type)
    {
        return view('user.investor-'.$type);
    }

    public function complete()
    {
        //Auth::logout();

        return view('auth.complete', [
            'title' => 'Completed registration',
        ]);
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password', ['title' => 'Forgotten password']);
    }

    public function forgotPasswordStore(Request $request)
    {
        $request->validate([Fortify::email() => 'required|email']);
        $input = $request->all();

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->broker()->sendResetLink(
            $request->only(Fortify::email())
        );
        return view('auth.forgot-password-success', [
            'title' => 'Link was sent',
            'email' => $input['email'],
        ]);
    }

    public function router()
    {
        $user = Auth::user();

        if ($user && $user->role === 'Admin') {
            return redirect()->route('users');
        }
        elseif ($user && $user->role === 'User') {
            if (null === $user->email_verified_at ) {
                return redirect()->route('logout');
            }
            if ('none' === $user->investor_type) {
                return redirect()->route('investor');
            }
            return redirect()->route('opportunities');
        }
        else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }
}
