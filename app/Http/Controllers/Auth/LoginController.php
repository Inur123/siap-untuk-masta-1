<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login identifier to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'nim';  // Use NIM as the login identifier
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'nim' => ['required', 'numeric', 'exists:users,nim'],
            'password' => ['required', 'string', 'min:8'],
            'g-recaptcha-response' => ['required'],
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.numeric' => 'NIM harus berupa angka.',
            'nim.exists' => 'NIM tidak ditemukan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
        ]);

        // Verifikasi reCAPTCHA
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $response->json();

        if (!$recaptchaData['success']) {
            return redirect()->back()
                ->withErrors(['g-recaptcha-response' => 'Verifikasi Captcha gagal. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * After authentication, send Telegram notification with user login info.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        // Capture IP address of the user
        $ipAddress = $request->ip();

        // Send Telegram notification with the login details
        $this->sendTelegramLoginNotification($user, $ipAddress);


        // Redirect to the intended page after login
        return redirect()->intended($this->redirectPath());
    }

    /**
     * Send login notification to Telegram bot.
     *
     * @param \App\Models\User $user
     * @param string $ipAddress
     * @return void
     */
    protected function sendTelegramLoginNotification($user, $ipAddress)
    {
        $apiToken = env('TELEGRAM_BOT_API_TOKEN'); // Get your Bot API Token from .env
        $chatId = env('TELEGRAM_CHAT_ID'); // Get your Chat ID from .env

        // Prepare message to be sent to Telegram bot
        $message = "User telah login:\n\n"
            . "Nama: {$user->name}\n"
            . "NIM: {$user->nim}\n"
            . "Email: {$user->email}\n"
            . "IP Address: $ipAddress\n"
            . "Fakultas: {$user->fakultas}\n"
            . "Prodi: {$user->prodi}\n"
            . "Waktu: " . now()->toDateTimeString(); // Current time of login

        // Send the message to Telegram bot
        Http::post("https://api.telegram.org/bot{$apiToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
}
