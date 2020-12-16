<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Restaurant;
use App\Product;
use App\Notifications\UpdatePricesReminder;

class SendUpdatePricesNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:update-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to users who have a restaurant to update their prices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $restaurants = Restaurant::where('state', 'active')->get();

        foreach ($restaurants as $restaurant) {
            $owner = $restaurant->user;
            $owner->notify(new UpdatePricesReminder());
        }
    }
}
