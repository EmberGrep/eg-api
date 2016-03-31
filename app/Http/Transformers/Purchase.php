<?php namespace EmberGrep\Http\Transformers;

use League\Fractal\TransformerAbstract;
use EmberGrep\Models\Purchase as PurchaseModel;

class Purchase extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        // 'lessons',
    ];

    /**
     * Transform only desired properties for API
     *
     * @param PurchaseModel $purchase
     * @return array
     */
    public function transform(PurchaseModel $purchase)
    {
        $attrs = [
            'id'            => (int)$purchase->id,
            'purchase-price' => (int)$purchase->charge_amount,
            'course'        => $purchase->course->slug,
            'date'          => $purchase->created_at->toIso8601String(),
            'notifications' => (boolean)$purchase->notifications,
        ];

        return $attrs;
    }

    // protected function includeLessons(PurchaseModel $purchase)
    // {
    //     return $this->collection($purchase->lessons, new LessonAbstract(), 'lesson-abstracts');
    // }
}
