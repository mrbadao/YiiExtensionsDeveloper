<?php

/**
 * Class ImgurUploader
 */
class ImgurUploader extends CApplicationComponent
{
    const ImgUrAPI_ALIAS_PASTH = "application.vendors.ImgUrAPI";
    const ImgUrAPI_MINE_URL = "https://api.imgur.com/3/account/[:user_id]/[:action]";
    const ImgUrAPI_DEFAULT_URL = "https://api.imgur.com/3/[:action]";
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

    /**
     * get all images infomation
     *
     * @return array|string
     */
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

    /**
     * get all Albums infomation
     *
     * @return array|string
     */
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

    /**
     * get image infomation
     *
     * @param $id
     * @return \Image
     */
    public function getImage($id)
    {
        $url = str_replace("[:action]", "image/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_img = new Image();
        $_img->setAttributes($result['data']);
        return $_img;
    }

    /**
     * get Album infomation
     *
     * @param $id
     * @return \Album
     */
    public function getAlbum($id)
    {
        $url = str_replace("[:action]", "album/$id", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        $_album = new Album();
        $_album->setAttributes($result['data']);

        return $_album;
    }


    /**
     * Get all albums id
     *
     * @return array|null
     */
    public function getAlbumsId()
    {
        $url = str_replace("[:action]", "albums/ids", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        return isset($result['data']) && !empty($result['data']) ? $result['data'] : null;
    }

    /**
     * Get all albums id     *
     *
     * @return array|null
     */
    public function getImagesId()
    {
        $url = str_replace("[:action]", "images/ids", self::ImgUrAPI_MINE_URL);
        $url = str_replace("[:user_id]", $this->user_id, $url);
        $result = self::excuteHTTPSRequest($url, $this->accessToken);

        return isset($result['data']) && !empty($result['data']) ? $result['data'] : null;
    }


    /**
     * delete image
     *
     * @param $id
     * @return bool
     */
    public function deleteImage($id)
    {
        $img = self::getImage($id);
        if ($img) {
            $url = str_replace("[:action]", "image/" . $img->_deletehash, self::ImgUrAPI_MINE_URL);
            $url = str_replace("[:user_id]", $this->user_id, $url);
            $result = self::excuteHTTPSRequest($url, $this->accessToken, null, "DELETE");
            return isset($result['data']) && $result['data'] == true && $result['success'] ? true : false;
        }
        return true;
    }


    /**
     * delete Album
     * @param $id
     * @return bool
     */
    public function deleteAlbum($id)
    {
        $album = self::getAlbum($id);
        if ($album) {
            $url = str_replace("[:action]", "albums/" . $album->_deletehash, self::ImgUrAPI_MINE_URL);
            $url = str_replace("[:user_id]", $this->user_id, $url);
            $result = self::excuteHTTPSRequest($url, $this->accessToken, null, "DELETE");
            return isset($result['data']) && $result['data'] == true && $result['success'] ? true : false;
        }
        return true;
    }

    public function createAlbum($params = null)
    {
        $url = str_replace("[:action]", "album", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, $this->accessToken, $params);

        var_dump($result);
    }

    public function uploadImage($params = null)
    {
        var_dump($params);
        $url = str_replace("[:action]", "image", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, $this->accessToken, $params);

        return $result;
    }


    /**
     * Get credit current user.
     * @return null
     */
    public function getCredit(){
        $url = str_replace("[:action]", "credits", self::ImgUrAPI_DEFAULT_URL);
        $result = self::excuteHTTPSRequest($url, null, null);
        return isset($result['data']) && $result['data'] == true && $result['success'] ? $result['data'] : null;
    }

    private function excuteHTTPSRequest($url, $accessToken = null, $postFields = null, $customRequestMethod = null)
    {
        $curl = curl_init();
        $header = null;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => self::TIMEOUT,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        if ($accessToken) {
            $header[] = "Authorization:Bearer " . $accessToken;
//            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization:Bearer " . $accessToken));
        } else {
            $header[] ="Authorization:Client-ID " . $this->client_id;
//                curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization:Client-ID " . $this->client_id));
        }

        if ($customRequestMethod) curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($customRequestMethod));

        if ($postFields) {
            $fields_string = '';
            foreach ($postFields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);

        }
        $header[] = "Content-Type:application/x-www-form-urlencoded;charset=UTF-8";
        curl_setopt ($curl, CURLOPT_HTTPHEADER, $header);
        $out = curl_exec($curl);
        $error = curl_error($curl);
        var_dump($error);
        curl_close($curl);

        return json_decode($out, true);
    }
}