<?php

namespace App\Service;

use Stripe\Checkout\Session;

class SessionStripe
{
    
    public function getCheckoutSession(){
         
        $checkoutSession = new Session;

        return $checkoutSession;
    } 
    
       
}

?>