<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'name' => 'Basic',
            'price' => '10',
            'duration' => '30',
            'captcha' => '1',
            'menual_req' => '0',
            'monthly_req' => '200',
            'daily_req' => '10',
            'mail_activity' => '1',
            'storage_limit' => '100',
            'fraud_check' => '1',
            'is_featured' => 0,
            'is_auto' => '1',
            'is_trial' => '1',
            'status' => '1',
        ]);

        Plan::create([
            'name' => 'Standard',
            'price' => '20',
            'duration' => '90',
            'captcha' => '1',
            'menual_req' => '1',
            'monthly_req' => '300',
            'daily_req' => '10',
            'mail_activity' => '1',
            'storage_limit' => '100',
            'fraud_check' => '1',
            'is_featured' => 0,
            'is_auto' => '1',
            'is_trial' => '0',
            'is_default' => '0',
            'status' => '1',
        ]);

        Plan::create([
            'name' => 'Pro',
            'price' => '30',
            'duration' => '110',
            'captcha' => '1',
            'menual_req' => '1',
            'monthly_req' => '600',
            'daily_req' => '25',
            'mail_activity' => '1',
            'storage_limit' => '150',
            'fraud_check' => '1',
            'is_featured' => '1',
            'is_auto' => '1',
            'is_trial' => '0',
            'is_default' => '0',
            'status' => '1',
        ]);

        Plan::create([
            'name' => 'Free',
            'price' => '0.00',
            'duration' => '150',
            'captcha' => '1',
            'menual_req' => '1',
            'monthly_req' => '900',
            'daily_req' => '40',
            'mail_activity' => '1',
            'storage_limit' => '300',
            'fraud_check' => '1',
            'is_featured' => '0',
            'is_auto' => '1',
            'is_trial' => '0',
            'is_default' => '0',
            'status' => '1',
        ]);
    }
}
