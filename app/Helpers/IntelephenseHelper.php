<?php

namespace Illuminate\Support\Facades {
    /**
     * @method static \App\Models\User|null user()
     */
    class Auth {}
}

namespace App\Models {
    /**
     * @mixin \Spatie\Permission\Traits\HasRoles
     */
    class User {}
}
