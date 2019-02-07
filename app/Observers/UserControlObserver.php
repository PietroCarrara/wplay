<?php

namespace App\Observers;

use App\UserControl;
use App\Log;

class UserControlObserver
{
    /**
     * Handle the user control "created" event.
     *
     * @param  \App\UserControl  $userControl
     * @return void
     */
    public function created(UserControl $userControl)
    {
        $log = Log::create([
            'message' => ":users: realizou $userControl->type",
        ]);

        $log->users()->save($userControl->user);
    }

    /**
     * Handle the user control "updated" event.
     *
     * @param  \App\UserControl  $userControl
     * @return void
     */
    public function updated(UserControl $userControl)
    {
        //
    }

    /**
     * Handle the user control "deleted" event.
     *
     * @param  \App\UserControl  $userControl
     * @return void
     */
    public function deleted(UserControl $userControl)
    {
        //
    }

    /**
     * Handle the user control "restored" event.
     *
     * @param  \App\UserControl  $userControl
     * @return void
     */
    public function restored(UserControl $userControl)
    {
        //
    }

    /**
     * Handle the user control "force deleted" event.
     *
     * @param  \App\UserControl  $userControl
     * @return void
     */
    public function forceDeleted(UserControl $userControl)
    {
        //
    }
}
