<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ActionBanUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'action:banuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Action Ban User';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::where('ban_date_limit', '>', 0)->get();
        foreach($users as $user){
            $ban_date = $user->ban_date_limit;
            // $user->created_at->addDays($ban_date) <= now()
            if( $user->created_at->addDays($ban_date) <= now() ){
                $user->ban_date_limit = 0;
                $user->update();
            }
        }
    }
}
