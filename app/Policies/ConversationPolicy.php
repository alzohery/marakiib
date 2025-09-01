<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any conversations.
     */
    public function viewAny(User $user)
    {
        // يمكن تعديلها لاحقاً إذا أردت عرض جميع المحادثات
        return true;
    }

    /**
     * Determine whether the user can view a specific conversation.
     */
    public function view(User $user, Conversation $conversation)
    {
        return ($conversation->user1_id === $user->id || $conversation->user2_id === $user->id)
            ? Response::allow()
            : Response::deny('You do not belong to this conversation.');
    }

    /**
     * Determine whether the user can create a conversation.
     */
    public function create(User $user)
    {
        // أي مستخدم مسجل يمكنه بدء محادثة
        return true;
    }

    /**
     * Determine whether the user can send/update messages in a conversation.
     */
    public function update(User $user, Conversation $conversation)
    {
        return ($conversation->user1_id === $user->id || $conversation->user2_id === $user->id)
            ? Response::allow()
            : Response::deny('You cannot send a message in this conversation.');
    }

    /**
     * Determine whether the user can delete a conversation.
     */
    public function delete(User $user, Conversation $conversation)
    {
        // لا يمكن حذف المحادثات حالياً
        return false;
    }

    /**
     * Determine whether the user can restore a conversation.
     */
    public function restore(User $user, Conversation $conversation)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete a conversation.
     */
    public function forceDelete(User $user, Conversation $conversation)
    {
        return false;
    }
}
