<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login'; // Arahkan ke halaman login setelah reset

    /**
     * Show the form to reset the user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle a password reset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        if (now()->subMinutes(config('auth.passwords.users.expire'))->isAfter($passwordReset->created_at)) {
            return back()->withErrors(['email' => 'The reset link has expired.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'This email address is not registered.']);
        }

        // Update password
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        if (!$user->wasChanged('password')) {
            return back()->withErrors(['email' => 'Failed to update the password.']);
        }

        // Hapus token setelah reset password
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Event untuk notifikasi atau audit log
        event(new PasswordReset($user));

        // Redirect ke halaman login dengan pesan sukses
        return redirect($this->redirectTo)->with('status', 'Password has been reset successfully! Please login with your new password.');
    }
}
