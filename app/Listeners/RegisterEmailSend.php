<?php

namespace App\Listeners;

use App\Events\Register;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterEmailSend
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Register  $event
     * @return void
     */
    public function handle(Register $event)
    {
        $num = $event->num;
        if($num == 1){
            file_put_contents("logs/number.log",date("Y-m-d H:i:s").">>>>>>>>>>>> 1 \n",FILE_APPEND);
        }elseif($num <1){
            file_put_contents("logs/number.log",date("Y-m-d H:i:s").">>>>>>>>>>>> 2 \n",FILE_APPEND);
        }else{
            file_put_contents("logs/number.log",date("Y-m-d H:i:s").">>>>>>>>>>>> 超出预估 \n",FILE_APPEND);
        };
    }
}
