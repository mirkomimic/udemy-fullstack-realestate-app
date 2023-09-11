<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Auth;
use Illuminate\Http\Request;

class ListingController extends Controller
{

  public function __construct()
  {
    // policy third way
    $this->authorizeResource(Listing::class, 'listing');
  }
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $filters = $request->only([
      'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
    ]);
    $listings = Listing::query()->filter($filters)
      ->latest()->paginate(9)->withQueryString();

    return inertia(
      'Listing/Index',
      [
        'filters' => $filters,
        'listings' => $listings,
      ]
    );
  }

  /**
   * Show the form for creating a new resource.
   */

  /**
   * Display the specified resource.
   */
  public function show(Listing $listing)
  {
    // listing policy
    // if (Auth::user()->cannot('view', $listing)) {
    //   abort(403); // 403 forbidden
    // }

    // policy second way
    // $this->authorize('view', $listing);

    return inertia(
      'Listing/Show',
      [
        'listing' => $listing,
      ]
    );
  }


}
