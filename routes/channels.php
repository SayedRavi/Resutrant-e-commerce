<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('orderPlaced', function (){
   return true;
});

Broadcast::channel('chat.{id}', function ($user, $id) {
    return $user->id ==  $id;
});
