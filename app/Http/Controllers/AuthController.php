<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 1. Hiển thị View
    public function showLogin() { return view('auth.login'); }
    public function showSignup() { return view('auth.signup'); }

    // 2. Xử lý Đăng nhập truyền thống
    public function postLogin(Request $request)
    {
        $customer = \App\Models\Customer::where('email', $request->email)
            ->where('password', md5($request->password))
            ->first();

        if (!$customer) {
            return response('2');
        }

        session([
            'login_customer_id' => $customer->id,
            'login_customer_name' => $customer->name,
            'login_customer_email' => $customer->email,
            'login_customer_phone' => $customer->phone,
            'login_customer_address' => $customer->address,
            'login_avatar' => $customer->avatar,
        ]);

        return response('1');
    }

    // 3. Xử lý Đăng ký
    public function postSignup(Request $request)
    {
        $exists = \App\Models\Customer::where('email', $request->email)->exists();

        if ($exists) {
            return response('2');
        }

        \App\Models\Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => md5($request->password),
        ]);

        return response('1');
    }

    // 4. Xử lý Đăng nhập bằng Google
    public function loginGoogle(Request $request)
    {
        try {

            $client = new \Google_Client([
                'client_id' => env('GOOGLE_CLIENT_ID')
            ]);

            $payload = $client->verifyIdToken($request->credential);

            if (!$payload) {
                return response()->json([
                    'success' => false
                ]);
            }

            $email = $payload['email'] ?? null;

            if (!$email) {
                return response()->json([
                    'success' => false
                ]);
            }

            $customer = Customer::where('email', $email)->first();

            if (!$customer) {

                $customer = new Customer();

                $customer->name =
                    $payload['name']
                    ?? $payload['given_name']
                    ?? 'Google User';

                $customer->email = $email;

                $customer->phone = 'Chưa cập nhật';

                $customer->address = 'Chưa cập nhật';

                $customer->avatar =
                    $payload['picture']
                    ?? '';

                $customer->password =
                    bcrypt(Str::random(16));

                $customer->save();
            }

            session([
                'login_customer_id' => $customer->id,
                'login_customer_name' => $customer->name,
                'login_avatar' => $customer->avatar
            ]);

            return response()->json([
                'success' => true
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);

        }
    }

    // 5. Đăng xuất
    public function logout()
    {
        session()->flush(); // Xóa sạch session
        return redirect('/');
    }

    // Hàm phụ: Set Session dùng chung
    private function setCustomerSession($customer)
    {
        session([
            'login_customer_id' => $customer->id,
            'login_customer_name' => $customer->name,
            'login_customer_email' => $customer->email,
            'login_avatar' => $customer->avatar
        ]);
    }
}