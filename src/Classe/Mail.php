<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = '24f5a5433f41d708625ecb57e4fbe8e5';
    private $api_key_secret = '56d059660c412879e5ce23faf0708f18';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "monptitmatin.contactv2@gmail.com",
                        'Name' => "Mon P'tit Matin"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 5695086,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
                    
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}