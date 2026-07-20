<?php

namespace App\Http\Middleware;

use App\Models\SiteProductField;
use App\Models\UserSubscriptionField;
use Closure;
use Illuminate\Http\Request;

class FraudOrder
{
    
    public function handle(Request $request, Closure $next)
    {

        $count_1 = 0;
        $count_2 = 0;
        $count_3 = 0;

        
        $count_1 = UserSubscriptionField::where('field', 'rt')->where('value',$request->rt)->count();
        

      
        $count_2 = UserSubscriptionField::where('field', 'rw')->where('value',$request->rw)->count();
      

     
        $count_3 = UserSubscriptionField::where('field', 'kelurahan')->where('value',$request->kelurahan)->count();
      

        $count = $count_1 ;
        dd($count);

        if($count <= 3) {
            return $next($request);
        } else {
            return redirect('/console/salesorder')->with('fraud','Installation address has been previously registered');
        }
        
    }
}
