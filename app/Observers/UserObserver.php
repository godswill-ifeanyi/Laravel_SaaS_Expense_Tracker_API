<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserCredentials;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $plain_password = $user->password;
        $user->notify(new UserCredentials($user->email,$plain_password));

        $user->password = Hash::make($plain_password);
        $user->save();
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
