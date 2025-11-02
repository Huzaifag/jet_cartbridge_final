<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['salesman', 'accountant', 'warehouse', 'deliveryman']);
    }

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        // Check if order belongs to user's seller
        $belongsToSeller = $user->hasRole('salesman') && $user->salesman?->seller_id === $order->seller_id;
        $belongsToAccountant = $user->hasRole('accountant') && $user->accountant?->seller_id === $order->seller_id;
        $belongsToWarehouse = $user->hasRole('warehouse') && $user->warehouse?->seller_id === $order->seller_id;
        $belongsToDeliveryman = $user->hasRole('deliveryman') && $order->delivery_person_id === $user->deliveryman?->id;

        return $belongsToSeller || $belongsToAccountant || $belongsToWarehouse || $belongsToDeliveryman;
    }

    /**
     * Determine whether the salesman can confirm the order.
     */
    public function confirmAsSalesman(User $user, Order $order): bool
    {
        return $user->hasRole('salesman') &&
               $user->salesman?->seller_id === $order->seller_id &&
               $order->status === 'Order Placed';
    }

    /**
     * Determine whether the accountant can confirm the order (create invoice).
     */
    public function confirmAsAccountant(User $user, Order $order): bool
    {
        return $user->hasRole('accountant') &&
               $user->accountant?->seller_id === $order->seller_id &&
               $order->status === 'Confirmed';
    }

    /**
     * Determine whether the warehouse can dispatch the order.
     */
    public function dispatch(User $user, Order $order): bool
    {
        return $user->hasRole('warehouse') &&
               $user->warehouse?->seller_id === $order->seller_id &&
               $order->status === 'Confirmed' &&
               !is_null($order->invoice);
    }

    /**
     * Determine whether the deliveryman can deliver the order.
     */
    public function deliver(User $user, Order $order): bool
    {
        return $user->hasRole('deliveryman') &&
               $order->delivery_person_id === $user->deliveryman?->id &&
               $order->status === 'Dispatched';
    }

    /**
     * Determine whether the user can update the order.
     */
    public function update(User $user, Order $order): bool
    {
        return $this->view($user, $order);
    }

    /**
     * Determine whether the user can delete the order.
     */
    public function delete(User $user, Order $order): bool
    {
        return false; // Orders should not be deleted
    }
}
