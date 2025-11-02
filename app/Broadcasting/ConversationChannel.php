<?php

namespace App\Broadcasting;

use App\Models\Conversation;
use App\Models\User;

class ConversationChannel
{
    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $conversationId): array|bool
    {
        $conversation = Conversation::find($conversationId);

        if (!$conversation) {
            return false;
        }

        // Allow access if user is either the customer or the seller
        if ($conversation->customer_id === $user->id || $conversation->seller_id === $user->id) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'type' => $conversation->customer_id === $user->id ? 'customer' : 'seller'
            ];
        }

        return false;
    }
}
