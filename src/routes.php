<?php

use SteveMoretz\LaravelOpcacheClear\OpcacheClearController;

Route::get("opcache-clear", [OpcacheClearController::class, "opcacheClear"]);
