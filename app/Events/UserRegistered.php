<?php

// app/Events/UserRegistered.php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
