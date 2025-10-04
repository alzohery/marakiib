<?php

namespace App\Filament\Resources\ConversationResource\Pages;

use Filament\Resources\Pages\Page;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationChat extends Page
{
    protected static string $resource = \App\Filament\Resources\ConversationResource::class;
    protected static string $view = 'filament.resources.conversation-resource.pages.chat';

    public Conversation $conversation;
    public $messages;

    public function mount($record): void
    {
        $this->conversation = Conversation::findOrFail($record);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::where('conversation_id', $this->conversation->id)
            ->with('sender')
            ->orderBy('created_at')
            ->get();
    }

    // 🟢 هنا هنخلي Filament نفسها تستقبل الـ POST
    // public function submitMessage(Request $request)
    // {
    //     $request->validate([
    //         'message' => 'required|string|max:1000',
    //     ]);

    //     $receiverId = $this->conversation->user1_id == auth()->id()
    //                     ? $this->conversation->user2_id
    //                     : $this->conversation->user1_id;

    //     Message::create([
    //         'conversation_id' => $this->conversation->id,
    //         'sender_id'       => auth()->id(),
    //         'receiver_id'     => $receiverId,
    //         'message'         => $request->message,
    //     ]);

    //     return redirect()->route('filament.resources.conversations.chat', $this->conversation->id);
    // }
}
