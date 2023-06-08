<?php

namespace App\Libraries;

use Exception;

class BaseApiClient
{
    protected static $authTokenInfo = null;

    protected $useCurl = true;
    protected $throwsCurlException = false;
    protected $requireAuth = false;

    private function setCurlOptions($curl, $url, $headers = [], $auth = false)
    {
        $refer = $_SERVER['REQUEST_URI'];
        $token = '';

        if ($auth) {
            $token = $this->getAuthToken();
            $headers[] = "Authorization: {$token}";
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, false);

        curl_setopt($curl, CURLOPT_HEADER, false);

        if (count($headers) > 0) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1800);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1800);

        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7');
        curl_setopt($curl, CURLOPT_REFERER, $refer);
    }

    private function setCurlOptionsForPost($curl, $url, $data, $headers = [], $auth = false)
    {
        $refer = $_SERVER['REQUEST_URI'];

        $postHeaders = $headers;
        //$postHeaders[] = 'Content-Type: application/x-www-form-urlencoded';
        $token = '';

        if ($auth) {
            $token = $this->getAuthToken();
            $postHeaders[] = "Authorization: {$token}";
        }

        $payload = '';

        if (is_array($data)) {
            $payload = $data;
        } elseif (is_object($data)) {
            $payload = json_encode($data);
        } elseif ($data instanceof \DateTime) {
            $payload = $data->format('Y-m-d H:i');
        } else {
            $payload = $data;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $postHeaders);

        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1800);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1800);

        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7');
        curl_setopt($curl, CURLOPT_REFERER, $refer);
    }

    private function getJsonUsingCurl($url, $headers = [], $auth = false)
    {
        $curl = curl_init();
        $url = str_replace(' ', '%20', $url);

        $this->setCurlOptions($curl, $url, $headers, $auth);
        $result = curl_exec($curl);

        if ($this->throwsCurlException) {
            $errorNumber = curl_errno($curl);

            if ($errorNumber) {
                $messageError = curl_strerror($errorNumber);
                throw new Exception("[$errorNumber] $messageError", $errorNumber);
            }
        }

        curl_close($curl);

        if (!$result) {
            return null;
        }

        $return = json_decode($result);

        return $return;
    }

    private function getJsonUsingFileGetContents($url)
    {
        $content = file_get_contents($url);

        if (!$content) {
            return null;
        }

        $return = json_decode($content);

        return $return;
    }

    private function getUsingCurl($url, $headers = [], $auth = false)
    {
        $curl = curl_init();
        $url = str_replace(' ', '%20', $url);

        $this->setCurlOptions($curl, $url, $headers, $auth);
        $result = curl_exec($curl);

        if ($this->throwsCurlException) {
            $errorNumber = curl_errno($curl);

            if ($errorNumber) {
                $messageError = curl_strerror($errorNumber);
                throw new Exception("[$errorNumber] $messageError", $errorNumber);
            }
        }

        curl_close($curl);

        if (!$result) {
            return null;
        }

        return $result;
    }

    private function getUsingFileGetContents($url)
    {
        $content = file_get_contents($url);

        if (!$content) {
            return null;
        }

        return $content;
    }

    protected function getJson($url, $headers = [])
    {
        $json = null;

        if ($this->useCurl) {
            $json = $this->getJsonUsingCurl($url, $headers, $this->requireAuth);
        } else {
            $json = $this->getJsonUsingFileGetContents($url);
        }

        return $json;
    }

    protected function get($url, $headers = [])
    {
        $json = null;

        if ($this->useCurl) {
            $json = $this->getUsingCurl($url, $headers, $this->requireAuth);
        } else {
            $json = $this->getUsingFileGetContents($url);
        }

        return $json;
    }

    protected function post($url, $data, $headers = [])
    {
        $curl = curl_init();
        $url = str_replace(' ', '%20', $url);

        $this->setCurlOptionsForPost($curl, $url, $data, $headers, $this->requireAuth);
        $result = curl_exec($curl);

        if ($this->throwsCurlException) {
            $errorNumber = curl_errno($curl);

            if ($errorNumber) {
                $messageError = curl_strerror($errorNumber);
                throw new Exception("[$errorNumber] $messageError", $errorNumber);
            }
        }

        curl_close($curl);

        if (!$result) {
            return null;
        }

        return $result;
    }

    protected function auth()
    {
        $username = env('CMS_API_USERNAME');
        $password = env('CMS_API_PASSWORD');
        $url = env('CMS_API_AUTH_URL');
        $params = ['username' => $username, 'password' => $password];

        $require_auth = $this->requireAuth;
        $this->requireAuth = false;

        $data = $this->post($url, $params, []);

        if (!$data) {
            return null;
        }

        $json = json_decode($data);
        $this->requireAuth = $require_auth;

        return $json;
    }

    protected function fillAuthTokenInfo()
    {
        $data = $this->auth();

        if (!$data || !$data->success) {
            self::$authTokenInfo = null;

            return false;
        }

        self::$authTokenInfo = $data;
    }

    protected function getAuthToken()
    {
        if (self::$authTokenInfo == null) {
            $this->fillAuthTokenInfo();

            return self::$authTokenInfo->token;
        }

        $validoAte = strtotime(self::$authTokenInfo->valido_ate);
        $dataAtual = strtotime(date('Y-m-d H:i'));

        if ($dataAtual > $validoAte) {
            self::$authTokenInfo = null;
            $this->fillAuthTokenInfo();

            return self::$authTokenInfo->token;
        }

        return self::$authTokenInfo->token;
    }
}
