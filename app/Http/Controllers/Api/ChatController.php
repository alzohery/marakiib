<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Models\Conversation;
use App\Models\Message;

class ChatController extends Controller
{
    /**
     * جلب كل المحادثات الخاصة بالمستخدم الحالي
     */
    public function index()
    {
        $userId = Auth::id();

        $conversations = Conversation::where('is_active', true)
            ->where(function ($q) use ($userId) {
                $q->where('user1_id', $userId)
                  ->orWhere('user2_id', $userId);
            })
            ->with([
                'user1:id,name,image,role',
                'user2:id,name,image,role',
                'lastMessage:id,conversation_id,message,sender_id,created_at,read_at',
            ])
            ->latest('updated_at')
            ->get()
            ->map(function ($conversation) use ($userId) {
                $chatWith = $conversation->user1_id == $userId ? $conversation->user2 : $conversation->user1;
                return [
                    'id' => $conversation->id,
                    'chat_with' => [
                        'id' => $chatWith->id,
                        'name' => $chatWith->name,
                        'role' => $chatWith->role,
                        'image' => $chatWith->image,
                    ],
                    'last_message' => $conversation->lastMessage?->message,
                    'last_message_time' => optional($conversation->lastMessage)->created_at?->diffForHumans(),
                    'unread_count' => $conversation->unreadCountForUser($userId),
                ];
            });

        return response()->json(['data' => $conversations], 200);
    }

    /**
     * بدء محادثة جديدة أو جلب المحادثة إذا موجودة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $user1_id = Auth::id();
        $user2_id = $validated['receiver_id'];

        // جلب المحادثة إذا موجودة
        $conversation = Conversation::where(function ($q) use ($user1_id, $user2_id) {
            $q->where('user1_id', $user1_id)->where('user2_id', $user2_id);
        })->orWhere(function ($q) use ($user1_id, $user2_id) {
            $q->where('user1_id', $user2_id)->where('user2_id', $user1_id);
        })->first();

        // إنشاء محادثة جديدة إذا لم توجد
        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => min($user1_id, $user2_id),
                'user2_id' => max($user1_id, $user2_id),
                'is_active' => true,
                'sort_order' => 0,
            ]);
        }

        return response()->json(['data' => $conversation], 201);
    }

    /**
     * جلب كل الرسائل في محادثة معينة
     */
    // public function getMessages($id)
    // {
    //     $conversation = Conversation::findOrFail($id);

    //     $this->authorize('view', $conversation); // optional إذا عندك Policies

    //     $messages = $conversation->messages()
    //         ->with([
    //             'sender:id,name,email,image,role',
    //             'receiver:id,name,email,image,role'])
    //         ->select('id','conversation_id','sender_id','receiver_id','message','image','read_at','created_at')
    //         ->get();

    //     return response()->json(['data' => $messages], 200);
    // }

    public function getMessages($id)
    {
        $conversation = Conversation::findOrFail($id);

        // $this->authorize('view', $conversation); // لو عندك Policies

        $userId = Auth::id(); // المستخدم الحالي

        $messages = $conversation->messages()
            ->with([
                'sender:id,name,email,image,role',
                'receiver:id,name,email,image,role'
            ])
            ->select('id','conversation_id','sender_id','receiver_id','message','image','read_at','created_at')
            ->get();

        return response()->json([
            'current_user_id' => $userId, // المستخدم الحالي مرة واحدة
            'messages' => $messages
        ], 200);
    }


    /**
     * إرسال رسالة في محادثة
     */
    public function sendMessage(Request $request, $id)
    {
        $conversation = Conversation::findOrFail($id);
        $this->authorize('update', $conversation); // optional إذا عندك Policies

        $validated = $request->validate([
            'message' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('chat_images', 'public') : null;

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $conversation->user1_id === Auth::id() ? $conversation->user2_id : $conversation->user1_id,
            'message' => $validated['message'],
            'image' => $imagePath,
            'slug' => Str::slug($validated['message'] . '-' . Str::random(6)),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        // تحديث آخر رسالة في المحادثة
        $conversation->update(['last_message_id' => $message->id]);

        return response()->json(['data' => $message], 201);
    }

    /**
     * تعليم المحادثة كمقروءة
     */
    public function markConversationAsRead($id)
    {
        $conversation = Conversation::findOrFail($id);

        Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Conversation marked as read'], 200);
    }

    // public function startConversation(Request $request)
    // {
    //     $validated = $request->validate([
    //         'renter_id' => 'required|exists:users,id',
    //     ]);

    //     $user1_id = Auth::id();
    //     $user2_id = $validated['renter_id'];

    //     // Check if conversation exists
    //     $conversation = Conversation::where(function ($query) use ($user1_id, $user2_id) {
    //         $query->where('user1_id', $user1_id)->where('user2_id', $user2_id);
    //     })->orWhere(function ($query) use ($user1_id, $user2_id) {
    //         $query->where('user1_id', $user2_id)->where('user2_id', $user1_id);
    //     })->first();

    //     if (!$conversation) {
    //         $conversation = Conversation::create([
    //             'user1_id' => min($user1_id, $user2_id),
    //             'user2_id' => max($user1_id, $user2_id),
    //             'is_active' => true,
    //             'sort_order' => 0,
                
    //         ]);
    //     }

    //     return response()->json(['data' => $conversation], 201);
    // }

    public function startConversation(Request $request)
{
    $validated = $request->validate([
        'renter_id' => 'required|exists:users,id',
    ]);

    $user1_id = Auth::id();
    $user2_id = $validated['renter_id'];

    // Check if conversation exists
    $conversation = Conversation::where(function ($query) use ($user1_id, $user2_id) {
        $query->where('user1_id', $user1_id)->where('user2_id', $user2_id);
    })->orWhere(function ($query) use ($user1_id, $user2_id) {
        $query->where('user1_id', $user2_id)->where('user2_id', $user1_id);
    })->first();

    if (!$conversation) {
        $conversation = Conversation::create([
            'user1_id'   => min($user1_id, $user2_id),
            'user2_id'   => max($user1_id, $user2_id),
            'is_active'  => true,
            'sort_order' => 0,
        ]);
    }

    // نجيب اسم الـ renter
    $renterName = \App\Models\User::where('id', $user2_id)->value('name');

    // ندمج بيانات الـ conversation مع renter_name
    $conversationData = $conversation->toArray();
    $conversationData['renter_name'] = $renterName;

    return response()->json([
        'data' => $conversationData
    ], 201);
}


}
