<?php namespace EmberGrep\Http\Controllers\Purchases;

use EmberGrep\Http\Controllers\Controller;

use EmberGrep\Http\Transformers\Purchase as PurchaseTransformer;
use EmberGrep\Models\Course;
use EmberGrep\Models\Purchase;

use Auth;
use Illuminate\Http\Request;
use Manuel\Resource\Item;
use Exception;

class AttemptPurchase extends Controller
{
    /**
     * @var \EmberGrep\Models\Course
     */
    protected $course;
    /**
     * @var \EmberGrep\Models\Purchase
     */
    protected $purchase;

    public function __construct(Purchase $purchase, Course $course)
    {
        $this->middleware('auth');
        $this->course = $course;
        $this->purchase = $purchase;
    }

    public function action(Request $request)
    {
        $user = $this->getUser();
        $courseSlug = $request->json('data.relationships.course.data.id');
        $existing = $request->json('data.attributes.existing');
        $token = $request->json('data.attributes.token');
        $course = $this->course->where('slug', $courseSlug)->first();

        try {
            if (!$existing) {
                $user->createAsStripeCustomer($token);
            }
            $charge = $user->charge($course->price);
        } catch(Exception $e) {
            return response()->json([
                'errors' => [[
                  'status' => '400',
                  'title' =>  'Card Failure',
                  'detail' => 'There was an error processing your card.',
                ]],
            ], 400);
        }

        $purchase = $this->purchase->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'charge_amount' => $charge->amount,
            'card_brand' => $charge->source->brand,
            'charge_id' => $charge->id,
        ]);

        $item = new Item($purchase, new PurchaseTransformer(), 'purchase-attempts');

        return response()->jsonApi($item);
    }

    /**
     * @return \EmberGrep\Models\User
     */
    protected function getUser()
    {
        return Auth::user();
    }
}
