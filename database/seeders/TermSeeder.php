<?php

namespace Database\Seeders;

use App\Models\Term;
use App\Models\Termmeta;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $terms = array(
            array('id' => '1','title' => 'Build custom payments experiences with well-documented APIs','slug' => 'build-custom-payments-experiences-with-well-documented-apis','type' => 'quick_start','status' => '1','featured' => NULL,'created_at' => '2021-04-27 04:47:44','updated_at' => '2021-04-27 05:53:57'),
            array('id' => '2','title' => 'Fully Encrypted','slug' => 'fully-encrypted','type' => 'service','status' => '1','featured' => NULL,'created_at' => '2021-04-27 04:47:45','updated_at' => '2021-04-27 04:47:45'),
            array('id' => '3','title' => 'Transparent Pricing','slug' => 'transparent-pricing','type' => 'service','status' => '1','featured' => NULL,'created_at' => '2021-04-27 04:47:45','updated_at' => '2021-04-27 04:47:45'),
            array('id' => '4','title' => 'Instant cashout','slug' => 'instant-cashout','type' => 'service','status' => '1','featured' => NULL,'created_at' => '2021-04-27 04:47:45','updated_at' => '2021-04-27 04:47:45'),
            array('id' => '5','title' => 'Trip to the road show Report about the team’s','slug' => 'trip-to-the-road-show-report-about-the-teams','type' => 'blog','status' => '1','featured' => '1','created_at' => '2021-04-27 06:03:33','updated_at' => '2021-04-27 06:03:33'),
            array('id' => '6','title' => "The most popular free time tracker for teams",'slug' => 'lorem-ipsum-dolor-sit','type' => 'blog','status' => '1','featured' => '1','created_at' => '2021-04-27 06:04:50','updated_at' => '2021-04-27 06:04:50'),
            array('id' => '7','title' => "How To Work From Home In This Situation",'slug' => 'how-to-work-from-home-in-this-situation','type' => 'blog','status' => '1','featured' => '1','created_at' => '2021-04-27 06:04:50','updated_at' => '2021-04-27 06:04:50')
        );

        Term::insert($terms);

        $termmetas = array(
            array('id' => '1','term_id' => '1','key' => 'quick_start_meta','value' => '{"des":"Developers love our thorough, well-documented APIs that let you to build everything from simple weekend projects, to complex financial products serving hundreds of thousands of customers. If you can imagine it, you can build it with Paystack.","button_name":"Lenden API Quickstart","button_link":"#","list":["Collect one-time and recurring payments from your app or website","Make instant transfers","Retrieve all your transaction and customer data","IVerify the identity of customers"],"image":"uploads\\/quick_starts\\/21\\/04\\/1698171808225933.png"}'),
            array('id' => '2','term_id' => '2','key' => 'service_meta','value' => '{"des":"Lorem ipsum dolor sit amet, cosectetur adipisicing elit, sed deimod tempor incid-idunt ut dolor sit amet","short_des":"Lorem ipsum dolor sit amet, cosectetur adipisicing elit, sed deimod tempor incid-idunt ut dolor sit amet","image":"uploads\\/service\\/21\\/04\\/1698167703623495.png"}'),
            array('id' => '3','term_id' => '3','key' => 'service_meta','value' => '{"des":"Lorem ipsum dolor sit amet, cosectetur adipisicing elit, sed deimod tempor incid-idunt ut dolor sit amet","short_des":"Lorem ipsum dolor sit amet, cosectetur adipisicing elit, sed deimod tempor incid-idunt ut dolor sit amet","image":"uploads\\/service\\/21\\/04\\/1698167800093672.png"}'),
            array('id' => '4','term_id' => '4','key' => 'service_meta','value' => '{"des":"Lorem ipsum dolor sit amet, cosectetur adipisicing elit, sed deimod tempor incid-idunt ut dolor sit amet","short_des":"Lorem ipsum dolor sit amet, cosectetur adipisicing elit, sed deimod tempor incid-idunt ut dolor sit amet","image":"uploads\\/service\\/21\\/04\\/1698167812109136.png"}'),
            array('id' => '5','term_id' => '5','key' => 'excerpt','value' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English.'),
            array('id' => '6','term_id' => '5','key' => 'thum_image','value' => 'uploads/blog/1/21/04/1698172411060494.jpg'),
            array('id' => '7','term_id' => '5','key' => 'description','value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."),
            array('id' => '8','term_id' => '6','key' => 'excerpt','value' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, illum facere distinctio fugiat molestiae quam, amet, architecto consequatur commodi recusandae cum. Obcaecati illum labore atque numquam ipsam perspiciatis, est nam?'),
            array('id' => '9','term_id' => '6','key' => 'thum_image','value' => 'uploads/blog/1/21/04/1698172492517038.jpg'),
            array('id' => '10','term_id' => '6','key' => 'description','value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."),
            array('id' => '11','term_id' => '7','key' => 'thum_image','value' => 'uploads/blog/1/21/04/3.jpg'),
            array('id' => '12','term_id' => '7','key' => 'description','value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."),
            array('id' => '13','term_id' => '7','key' => 'excerpt','value' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique, illum facere distinctio fugiat molestiae quam, amet, architecto consequatur commodi recusandae cum. Obcaecati illum labore atque numquam ipsam perspiciatis, est nam?'),
          );
          
        Termmeta::insert($termmetas);
    }

}
