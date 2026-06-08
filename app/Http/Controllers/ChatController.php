<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemChat;
use App\Models\User;
use App\Models\Customer;
use App\Models\House;
use Carbon\Carbon;
use Exception;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'user_type' => 'nullable|integer',
            ]);

            $userType = (int) $request->input('user_type', 2);

            if ($userType === 1) {
                if (!session()->has('login_id')) {
                    return response('0');
                }

                $userId = session('login_id');
            } else {
                if (!session()->has('login_customer_id')) {
                    return response('0');
                }

                $userId = session('login_customer_id');
                $userType = 2;
            }

            $now = Carbon::now('Asia/Ho_Chi_Minh');

            SystemChat::create([
                'user_id' => $userId,
                'user_type' => $userType,
                'message' => trim($request->message),
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            return response('1');
        } catch (Exception $e) {
            return response('ERROR SEND: ' . $e->getMessage(), 500);
        }
    }

    public function load()
    {
        try {
            $chats = SystemChat::orderBy('created_at', 'asc')
                ->orderBy('id', 'asc')
                ->limit(50)
                ->get();

            $data = $chats->map(function ($chat) {
                $senderName = 'Cư dân';

                if ((int) $chat->user_type === 1) {
                    $sender = User::find($chat->user_id);
                    $senderName = $sender->name ?? 'Ban Quản Lý';
                } else {
                    $sender = Customer::find($chat->user_id);
                    $senderName = $sender->name ?? 'Cư dân';
                }

                return [
                    'id' => $chat->id,
                    'user_id' => (int) $chat->user_id,
                    'user_type' => (int) $chat->user_type,
                    'message' => e($chat->message),
                    'sender_name' => $senderName,
                    'is_edited' => (int) $chat->is_edited,
                    'time' => (
                        $chat->is_edited == 1
                            ? Carbon::parse($chat->updated_at)
                            : Carbon::parse($chat->created_at)
                    )
                    ->timezone('Asia/Ho_Chi_Minh')
                    ->format('H:i d/m/Y'),
                ];
            });

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json([
                [
                    'id' => 0,
                    'user_id' => 0,
                    'user_type' => 1,
                    'message' => 'Lỗi load chat: ' . $e->getMessage(),
                    'sender_name' => 'System',
                    'time' => '',
                ]
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {

            $request->validate([
                'message' => 'required|string'
            ]);

            $chat = SystemChat::findOrFail($id);

            // Kiểm tra chủ tin nhắn
            $currentUserId = session('login_customer_id');

            if ($chat->user_id != $currentUserId || $chat->user_type != 2) {
                return response('0');
            }

            // Giới hạn 5 phút
            $created = Carbon::parse($chat->created_at);

            if ($created->diffInMinutes(now()) > 5) {
                return response('expired');
            }

            $chat->message = trim($request->message);
            $chat->is_edited = 1;
            $chat->updated_at = now('Asia/Ho_Chi_Minh');

            $chat->save();

            return response('1');

        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function aiReply(Request $request)
    {
        $msg = mb_strtolower($request->message ?? '', 'UTF-8');

        if (
            str_contains($msg, 'phòng trống') ||
            str_contains($msg, 'còn phòng') ||
            str_contains($msg, 'thuê')
        ) {
            $rooms = House::with('category')
                ->whereNotIn('id', function ($q) {
                    $q->select('house_id')
                        ->from('tenants')
                        ->where('status', 1);
                })
                ->orderBy('price', 'asc')
                ->limit(5)
                ->get();

            if ($rooms->count() > 0) {
                $reply = "Chào bạn! Hiện tại hệ thống <b>Quản Gia 5.0</b> đang có sẵn các phòng trống sau:<br><br>";

                foreach ($rooms as $room) {
                    $price = number_format($room->price, 0, ',', '.');

                    $reply .= "🏠 <b>Phòng {$room->house_no}</b> (" . e($room->category->name ?? 'Phòng') . ")<br>";
                    $reply .= "💰 Giá thuê: <b style='color:#e74a3b'>{$price} đ/tháng</b><br>";
                    $reply .= "<i>Chi tiết: " . e($room->description) . "</i><hr style='margin:5px 0'>";
                }

                $reply .= "Bạn ưng ý phòng nào, hãy để lại Số Điện Thoại để Ban Quản Lý liên hệ nhé!";

                return response($reply);
            }

            return response("Rất tiếc! Hiện tại tất cả các phòng đã được thuê hết.");
        }

        if (
            str_contains($msg, 'chào') ||
            str_contains($msg, 'hello') ||
            str_contains($msg, 'hi')
        ) {
            return response("Dạ, Quản Gia 5.0 xin chào! Bạn có muốn xem danh sách <b>phòng trống</b> không?");
        }

        if (
            str_contains($msg, 'liên hệ') ||
            str_contains($msg, 'số điện thoại') ||
            str_contains($msg, 'sđt')
        ) {
            return response("Bạn có thể liên hệ Ban Quản Lý qua Hotline <b>1900 1560</b> hoặc Zalo ở thanh công cụ bên phải nhé!");
        }

        return response("Xin lỗi, mình chưa hiểu rõ ý bạn. Bạn có thể hỏi: <b>phòng trống</b>, <b>còn phòng không</b>, hoặc <b>liên hệ</b>.");
    }
}