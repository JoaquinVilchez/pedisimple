<?php
use App\Restaurant;

function getRestaurantData($id){
    return Restaurant::find($id);
}

function userIsLoggedIn(){
    if(Auth::user()){
        return true;
    }else{
        return false;
    }
}   

?>