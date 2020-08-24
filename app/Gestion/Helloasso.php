<?php


namespace App\Gestion;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;



class Helloasso
{
    public $hid;
    private $hpass;
    public $hurl;
    public $access_token;
    private $refresh_token;
    public $api_version;
    public $asso_slug;


    public function __construct()
    {
//        print "hello asso bonjour !";
//
        $this->hid = env('HELLOASSO_ID');

        $this->hpass = env('HELLOASSO_PASS');

        $this->hurl = env('HELLOASSO_API_URL','https://api.helloasso.com');

        $this->api_version = env('HELLOASSO_API_VERSION','V5');

        $this->asso_slug=env('HELLOASSO_ASSO_SLUG');


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
                'form_params' =>[
                        'client_id'=>$this->hid,
                        'client_secret'=>$this->hpass,
                        'grant_type'=>'client_credentials',
                    ]

            ];

            $client = new Client();

            $res = $client->request('POST', $this->hurl .  "/oauth2/token",$json);

        }
        catch(\GuzzleHttp\Exception\ServerException $e)
        {
            return false;
        }

        $auth=json_decode($res->getBody()->getContents());

        $this->access_token=$auth->access_token;

        $this->refresh_token=$auth->refresh_token;

//        $auth = $res->getHeader('Authorization');
//
//        $this->izly_token=$auth;

        return true;


    }

    public function getadhesions($mail=false,$adhesionslug="inscriptions-2019-2020")
    {
        $this->login();



        try {

                    $url = $this->hurl."/".$this->api_version.'/organizations/'.$this->asso_slug."/forms/Membership/".$adhesionslug."/orders?pageIndex=1&pageSize=20&retrieveOfflineDonations=false&withDetails=false";


            $json = [
                'headers'  => [
                                'accept' => 'application/json',

                                'Authorization' => "Bearer ".$this->access_token
                              ],


            ];

            if($mail)
            {
                $search= "userSearchKey=".urlencode($mail)."&";
            }
            else{
                $search="";
            }

        $url="https://api.helloasso.com/v5/organizations/fjep-gymnastique-saint-just-saint-rambert/forms/Membership/inscriptions-2019-2020/orders?".$search."pageIndex=1&pageSize=20&retrieveOfflineDonations=false&withDetails=true";
            $client = new Client();

            $res = $client->request('GET', $url ,$json);

        }
        catch(\GuzzleHttp\Exception\ServerException $e)
        {
            return false;
        }

        $data= $auth=$res->getBody()->getContents();



        return $data;


    }

    public function getcurrentadhurl()
    {
        return "https://www.helloasso.com/associations/fjep-gymnastique-saint-just-saint-rambert/adhesions/inscriptions-2019-2020";
    }


}
