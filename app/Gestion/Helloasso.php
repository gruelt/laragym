<?php


namespace App\Gestion;


class Helloasso
{
    public $hid;
    private $hpass;
    public $hurl;

    public function __construct()
    {
        print "hello asso bonjour !";

        $this->hid = env('HELLOASSO_ID');

        $this->hpass = env('HELLOASSO_PASS');

        $this->hurl = env('HELLOASSO_URL','https://api.helloasso.com/oauth2/token');

        $test='a';
    }


    /**
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function login()
    {
        try {

            $json = [
                'headers'  => ['content-type' => 'application/x-www-form-urlencoded',
                    'charset' =>'utf8'],
                'body' =>json_encode([
                        'client_id'=>$this->hid,
                        'client_secret'=>$this->hpass,
                        'grant_type'=>'credentials',
                    ]
                )
            ];

            $client = new Client();

            $res = $client->request('POST', $this->izly_uri . $this->izly_api . "authenticate",$json);

        }
        catch(\GuzzleHttp\Exception\ServerException $e)
        {
            return false;
        }

        $auth = $res->getHeader('Authorization');

        $this->izly_token=$auth;

        return $auth;


    }


}
