<?php namespace EmberGrep\Http\Controllers\Purchases;

use Illuminate\Http\Request;
use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Models\Purchase;

use League\Fractal\Resource\Collection;
use EmberGrep\Http\Transformers\Purchase as PurchaseTransformer;

class ListPurchases extends Controller
{
    public function __construct(Purchase $course)
    {
        $this->course = $course;
       $this->middleware('auth');
    }

    public function action()
    {
        // $freePurchases = $this->course->where(['is_published' => true])->get();

        // $item = new Collection($freePurchases, new PurchaseTransformer(), 'course-abstracts');

        // return response()->jsonApi($item);
    }
}
