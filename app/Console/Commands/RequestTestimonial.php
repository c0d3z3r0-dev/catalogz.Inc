<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;

class RequestTestimonial extends Command
{
    protected $signature = 'testimonials:request';
    protected $description = 'Ask merchants with 5+ orders for a testimonial';

    public function handle()
    {
        $clients = Client::has('orders', '>=', 5)->get();
        foreach ($clients as $client) {
            // In production, send a WhatsApp message here.
            $this->info("Would send testimonial request to {$client->name}");
        }
        return 0;
    }
}
