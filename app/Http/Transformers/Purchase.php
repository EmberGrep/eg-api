<?php namespace EmberGrep\Http\Transformers;

use Manuel\Transformer\TransformerAbstract;
use EmberGrep\Models\Purchase as PurchaseModel;

use Manuel\Resource\Item;

class Purchase extends TransformerAbstract
{
    protected $type = 'purchases';

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $includedResources = ['course'];

    /**
     * Transform only desired properties for API
     *
     * @param PurchaseModel $purchase
     * @return array
     */
    public function transform(PurchaseModel $purchase)
    {
        $attrs = [
            'id'            => (string)$purchase->id,
            'purchase-price' => (int)$purchase->charge_amount,
            'date'          => $purchase->created_at->toIso8601String(),
            'notifications' => (boolean)$purchase->notifications,
        ];

        return $attrs;
    }

    public function includeCourse(PurchaseModel $purchase)
    {
        return new Item($purchase->course, new PurchasedCourse());
    }
}
