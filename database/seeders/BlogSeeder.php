<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 1000; $i++) {
            Term::create([
                'key'   => 'blog',
                'title' => Str::random(10),
                'slag'  => Str::slug('title'),
            ]);

            $value = [
                'status'              => "on", //or off
                'days'                => 10,
                'assign_default_plan' => "on",
                'alert_message'       => "Hi, your plan will expire after 10 days!",
                'expire_message'      => "Your plan is expired!",
            ];
            $theme = new Option();
            $theme->key = 'theme_settings';
            $theme->value = '{"footer_description":"Lorem ipsum dolor sit amet, consect etur adi pisicing elit sed do eiusmod tempor incididunt ut labore.","newsletter_address":"88 Broklyn Golden Street, New York. USA needhelp@ziston.com","theme_color":"39089809809","new_account_button":"jkljkljlk","new_account_url":"jkljkljlk","social":[{"icon":"ri:facebook-fill","link":"#"},{"icon":"ri:twitter-fill","link":"#"},{"icon":"ri:google-fill","link":"#"},{"icon":"ri:instagram-fill","link":"#"},{"icon":"ri:pinterest-fill","link":"#"}]}';
            $theme->save();

        }
    }
}
