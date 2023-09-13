<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
  public function create(Listing $listing)
  {
    // https://laravel.com/docs/10.x/eloquent-collections#method-load
    $listing->load(['images']);
    return inertia('Realtor/ListingImage/Create', [
      'listing' => $listing
    ]);
  }

  public function store(Listing $listing, Request $request)
  {
    if ($request->hasFile('images')) {
      // images.* for validating arrays
      $request->validate([
        'images.*' => 'mimes:jpg,png,jpeg|max:5000'
      ], [
        // customized message
        'images.*.mimes' => 'The file shuld be in one of the formats: jpg, png, jpeg'
      ]);

      foreach ($request->file('images') as $file) {
        $path = $file->store('images', 'public');

        $listing->images()->save(new ListingImage([
          'filename' => $path
        ]));
      }
    }

    return redirect()->back()->with('success', 'Images uploaded!');
  }

  public function destroy($listing, ListingImage $image)
  {
    Storage::disk('public')->delete($image->filename);
    $image->delete();

    return redirect()->back()->with('success', 'Image was deleted!');
  }
}