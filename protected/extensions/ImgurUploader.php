<?php

class ImgurUploader extends CApplicationComponent
{
    const ImgUrAPI_ALIAS_PASTH = "application.vendors.ImgUrAPI";
    const ImgUrAPI_MINE_URL = "https://api.imgur.com/3/account/[:user_id]/[:action]";
    const  ImgUrAPI_OAUTH_URL = "https://api.imgur.com/oauth2/[:action]";
    const  TIMEOUT = 30;

    public $refreshToken;
    public $client_id;
    public $client_secret;
    public $user_id;
    private $accessToken;

    function init()
    {
        $postFields = array(
            "refresh_token" => $this->refreshToken,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "refresh_token",
        );
        $url = str_replace("[:action]", "token", self::ImgUrAPI_OAUTH_URL);
        $result = self::excuteHTTPSRequest($url, null, $postFields);

        if (isset($result['access_token'])) $this->accessToken = $result['access_token'];
        else $this->accessToken = null;
        var_dump($this->accessToken);
    }

    public function getImages()
    {
        $url = str_replace("[:action]", "images", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_images = '';
        foreach ($result['data'] as $item) {
            $_img = new Image();
            $_img->setAttributes($item);
            $_images[] = $_img;
        }

        return $_images;
    }

    public function getAlbums()
    {
        $url = str_replace("[:action]", "albums", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_albums = '';

        foreach ($result['data'] as $item) {
            $_album = new Album();
            $_album->setAttributes($item);
            $_albums[] = $_album;
        }

        return $_albums;
    }

    public function getAlbum($id)
    {
        $url = str_replace("[:action]", "album/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_album = new Album();
        $_album->setAttributes($result['data']);


        return $_album;
    }

    public function getImage($id){
        $url = str_replace("[:action]", "image/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_img = new Image();
        $_img->setAttributes($result['data']);
        return $_img;
    }

    private function excuteHTTPSRequest($url, $accessToken = null, $postFields = null)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_RETURNTRANSFER => 1,

            CURLOPT_SSL_VERIFYPEER => false,
        ));

        if ($accessToken) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization:Bearer " . $accessToken));
        } else {
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization:Client-ID " . $this->client_id));
        }

        if ($postFields) {
            $fields_string = '';
            foreach ($postFields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            curl_setopt($curl, CURLOPT_POST, count($postFields));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        }

        $out = curl_exec($curl);
        curl_close($curl);

        return json_decode($out, true);
    }
}