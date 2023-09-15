<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class RealtorListingAcceptOfferController extends Controller
{
  // __invoke call class as function "Single Action Controller"
  public function __invoke(Offer $offer)
  {
    $this->authorize('update', $offer->listing); // from listing policy
    // Accept selected offer
    $offer->update(['accepted_at' => now()]);

    $offer->listing->sold_at = now();
    $offer->listing->save();

    // Reject all other offers
    $offer->listing->offers()->except($offer)
      ->update(['rejected_at' => now()]);

    return redirect()->back()->with('success', "Offer #{$offer->id} accepted, other offers rejected");
  }
}
