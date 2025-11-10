<?php

use App\Broadcasting\ConversationChannel;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    // Check if it's a regular user
    if ($user) {
        $conversation = \App\Models\Conversation::find($conversationId);
        
        if (!$conversation) {
            return false;
        }

        // Allow access if user is the customer
        if ($conversation->customer_id === $user->id) {
            return ['id' => $user->id, 'name' => $user->name, 'type' => 'customer'];
        }
        
        // Allow access if user has a seller and is the conversation's seller
        if ($user->seller && $conversation->seller_id === $user->seller->id) {
            return ['id' => $user->id, 'name' => $user->name, 'type' => 'seller'];
        }
    }
    
    return false;
});

Broadcast::channel('seller.{sellerId}', function ($user, $sellerId) {
    // Allow if user has a seller with matching ID
    return $user && $user->seller && $user->seller->id == $sellerId;
});
