<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{

    /**
     * handles item quantity
     *
     * @param UpdateCartItemRequest $request
     * @param CartItem $cartItem
     * @return void
     */
    public function update(UpdateCartItemRequest $request, CartItem  $cartItem)
    {
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return back();
    }

    /**
     * remove item
     *
     * @param CartItem $cartItem
     * @return void
     */
    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return back();
    }
}
