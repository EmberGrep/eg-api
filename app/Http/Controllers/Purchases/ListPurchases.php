<?php namespace EmberGrep\Http\Controllers\Purchases;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Purchase;

use Manuel\Resource\Collection;
use EmberGrep\Http\Transformers\Purchase as PurchaseTransformer;

use Auth;

class ListPurchases extends Controller
{
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
        $this->middleware('auth');
    }

    public function action()
    {
        $purchases = Auth::user()->purchases()->get();

        $item = new Collection($purchases, new PurchaseTransformer(), 'purchases');

        return response()->jsonApi($item);
    }
}
