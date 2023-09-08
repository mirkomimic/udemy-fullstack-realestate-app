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
  public function create()
  {
    // $this->authorize('create', Listing::class);

    return inertia("Listing/Create");
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // $request->user()->listings()->create()
    $request->user()->listings()->create(
      $request->validate([
        'beds' => 'required|integer|min:0|max:20',
        'baths' => 'required|integer|min:0|max:20',
        'area' => 'required|integer|min:15|max:1500',
        'city' => 'required',
        'code' => 'required',
        'street' => 'required',
        'street_nr' => 'required',
        'price' => 'required|integer|min:1|max:20000000',
      ])
    );

    return redirect()->route('listing.index')
      ->with('success', 'Listing was created!');
  }

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

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Listing $listing)
  {
    return inertia(
      'Listing/Edit',
      [
        'listing' => $listing,
      ]
    );
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Listing $listing)
  {
    $listing->update(
      $request->validate([
        'beds' => 'required|integer|min:0|max:20',
        'baths' => 'required|integer|min:0|max:20',
        'area' => 'required|integer|min:15|max:1500',
        'city' => 'required',
        'code' => 'required',
        'street' => 'required',
        'street_nr' => 'required|min:1|max:1000',
        'price' => 'required|integer|min:1|max:20000000',
      ])
    );

    return redirect()->route('listing.index')
      ->with('success', 'Listing was changed!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Listing $listing)
  {
    $listing->delete();

    return redirect()->back()
      ->with('success', 'Listing was deleted!');
  }
}
