<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
  // runs before rules
  public function before(?User $user, $ability) 
  {
    // exceptions on rules
    // $user? checks if user is not null
    if ($user?->is_admin) {
      return true;
    }  

    // if ($user->is_admin && $ability == 'update') {
    //   return true;
    // }  
  }
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(?User $user): bool
  {
    // ?User
    return true;
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(?User $user, Listing $listing): bool
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return true;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Listing $listing): bool
  {
    return $user->id == $listing->user_id;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Listing $listing): bool
  {
    return $user->id == $listing->user_id;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Listing $listing): bool
  {
    // for soft deletes
    return $user->id == $listing->user_id;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Listing $listing): bool
  {
    return $user->id == $listing->user_id;
  }
}
