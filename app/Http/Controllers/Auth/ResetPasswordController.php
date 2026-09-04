<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
class ResetPasswordController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo = '/';
    public function __construct() { $this->middleware('guest'); }
    public function showResetForm(\Illuminate\Http\Request $request, $token = null) {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }
}
