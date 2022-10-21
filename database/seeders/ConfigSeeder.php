<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contact_data = array(
            0 =>
            array(
                'name' => 'short_text',
                'value' => 'Si vous êtes un client et avez besoin d’aide pour un produit ou service, veuillez visiter notre support client dédiée qui se trouve <a href="https://fxinstitut.com/support">ici</a> afin que nous puissions vous aide.<br>
		Sinon vous pouvez nous contacter par email <a href="mailto:team@fxinstitut.com">team@fxinstitut.com</a>',
                'status' => 1,
            ),
            1 =>
            array(
                'name' => 'primary_address',
                'value' => ' Abidjan, Codody, Angré les Oscars',
                'status' => 1,
            ),
            2 =>
            array(
                'name' => 'secondary_address',
                'value' => '',
                'status' => 0,
            ),
            3 =>
            array(
                'name' => 'primary_phone',
                'value' => '(225) 0749821615',
                'status' => 1,
            ),
            4 =>
            array(
                'name' => 'secondary_phone',
                'value' => '(225) 0586272686',
                'status' => 1,
            ),
            5 =>
            array(
                'name' => 'primary_email',
                'value' => 'team@fxinstitut.com',
                'status' => 1,
            ),
            6 =>
            array(
                'name' => 'secondary_email',
                'value' => 'mail@fxinstitut.com',
                'status' => 1,
            ),
            7 =>
            array(
                'name' => 'location_on_map',
                'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d101408.2330017279!2d-122.15130702796371!3d37.41330279145996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb7495bec0189%3A0x7c17d44a466baf9b!2sMountain+View%2C+CA%2C+USA!5e0!3m2!1sen!2sin!4v1553663251022" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>',
                'status' => 1,
            ),
        );

        $footer_data = '{"short_description":{"text":"Nous prenons au sérieux notre mission d\'accroître l\'accès mondial à un service de qualité. Nous partageons notre savoir faire à toutes les communautés du monde entier.","status":1},"section1":{"type":"2","status":1},"section2":{"type":"3","status":1},"section3":{"type":"4","status":1},"social_links":{"status":1,"links":[{"icon":"fab fa-facebook-f","link":"#"},{"icon":"fab fa-instagram","link":"#"},{"icon":"fab fa-twitter","link":"#"},{"icon":"fab fa-youtube","link":"#"},{"icon":"fab fa-linkedin-in","link":"#"},{"icon":"fab fa-github","link":"#"}]},"bottom_footer":{"status":1},"copyright_text":{"text":"All right reserved  © 2020","status":1},"bottom_footer_links":{"status":1,"links":[{"label":"Privacy Policy","link":"' . asset('privacy-policy') . '"}]}}';
        $contact_data = json_encode($contact_data);
        $data = [
            'contact_data' => $contact_data,
            'footer_data' => $footer_data,
            'app__locale' => 'fr',
            'app__currency' => 'USD',
            'module_timer' => 0,
            'show_offers' => 1,
            'access.captcha.registration' => 0,
            'sitemap.chunk' => 500,
            'one_signal' => 0
        ];

        foreach ($data as $key => $value) {
            $key = str_replace('__', '.', $key);
            $config = \App\Models\Config::firstOrCreate(['key' => $key]);
            $config->value = $value;
            $config->save();
        }
    }
}
