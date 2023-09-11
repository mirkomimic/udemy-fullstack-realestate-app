<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Auth;
use Illuminate\Http\Request;

class RealtorListingController extends Controller
{
  public function __construct()
  {
    $this->authorizeResource(Listing::class, 'listing');
  }

  public function index(Request $request)
  {
    // https://laravel.com/docs/10.x/requests#retrieving-boolean-input-values
    // ne radi
    $filters = [
      'deleted' => $request->boolean('deleted'),
      ... $request->only(['by', 'order']) // unpack in array
    ];

    $listings = Auth::user()->listings()->filter($filters)->paginate(6)->withQueryString();

    return inertia('Realtor/Index', [
      'listings' => $listings,
      'filters' => $filters
    ]);
  }

  public function create()
  {
    // $this->authorize('create', Listing::class);

    return inertia("Realtor/Create");
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

    return redirect()->route('realtor.listing.index')
    ->with('success', 'Listing was created!');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Listing $listing)
  {
    return inertia(
      'Realtor/Edit',
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

    return redirect()->route('realtor.listing.index')
      ->with('success', 'Listing was changed!');
  }

  public function destroy(Listing $listing)
  {
    // soft delete
    $listing->deleteOrFail();

    return redirect()->back()
      ->with('success', 'Listing was deleted!');
  }

  public function restore(Listing $listing) 
  {
    $listing->restore();

    return redirect()->back()->with('success', 'Listing was restored');
  }
}
