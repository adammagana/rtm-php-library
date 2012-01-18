<?php
/**
 *   PHP Library - Remember The Milk
 *
 *   @author Adam Magaña
 *   @since September 9th, 2011
 *   @see http://www.rememberthemilk.com/services/api/
 *   
 *   License (The MIT License)
 *   
 *   Copyright (c) 2011 Adam Magaña <adammagana@gmail.com>
 *   
 *   Permission is hereby granted, free of charge, to any person obtaining
 *   a copy of this software and associated documentation files (the
 *   'Software'), to deal in the Software without restriction, including
 *   without limitation the rights to use, copy, modify, merge, publish,
 *   distribute, sublicense, and/or sell copies of the Software, and to
 *   permit persons to whom the Software is furnished to do so, subject to
 *   the following conditions:
 *   
 *   The above copyright notice and this permission notice shall be
 *   included in all copies or substantial portions of the Software.
 *   
 *   THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND,
 *   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 *   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 *   IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 *   CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 *   TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 *   SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

class RtmApiError extends Exception {}

class RTM {
    private $authUrl = 'http://www.rememberthemilk.com/services/auth/';
    private $baseUrl = 'http://api.rememberthemilk.com/services/rest/';

    private $appKey;
    private $appSecret;
    private $permissions;

    /**
    * CONSTRUCTOR
    */
    public function __construct($appKey = '', $appSecret = '', $permissions = 'read', $format='json') {
        if(empty($appKey) || empty($appSecret)) {
            throw new RtmApiError('Error: App Key and/or Secret Key must be defined.');
        }

        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->permissions = $permissions;
        $this->format = $format;
    }

    /**
     * Encodes request parameters into URL format 
     * 
     * @param params    Array of parameters to be URL encoded
     * @param signed    Boolean specfying whether or not the URL should be signed
     * @return          Returns the URL encoded string of parameters
     */
    private function encodeUrlParams($params = array(), $signed = false) {
        $paramString = '';

        if(!empty($params)) {
            $count = 0;

            // Encode the parameter keys and values
            foreach($params as $key => $value) {
                if($count == 0){
                    $paramString .= '?'.$key.'='.urlencode($value);
                }else {
                    $paramString .= '&'.$key.'='.urlencode($value);
                }
                $count++;
            }

            // Encode and append the response format paramter
            $paramString .= '&format='.$this->format;

            // Append an auth signature if needed
            if($signed) {
                $paramString .= $this->generateSig($params);
            }
        }else {
            throw new RtmApiError("Error: There are no parameters to encode.");
        }

        return $paramString;
    }

    /**
     * Generates a URL encoded authentication signature
     * 
     * @param params    The parameters used to generate the signature
     * @return          Returns the URL encoded authentication signature
     */
    private function generateSig($params = array()) {
        $params['format'] = $this->format;

        ksort($params);
        $signature = '';
        $signatureUrl = '&api_sig=';

        foreach($params as $key => $value) {
            $signature .= $key.$value;
        }

        $signature = $this->appSecret.$signature;
        $signatureUrl .= md5($signature);

        return $signatureUrl;
    }

    /**
     * Generates a RTM authentication URL
     * 
     * @return          Returns the reponse from the RTM API
     */
    public function getAuthUrl() {
        $params = array(
            "api_key" => $this->appKey,
            "perms" => $this->permissions
        );
        $url = $this->authUrl.$this->encodeUrlParams($params, true);
        return $url;
    }

    /**
     * Main method for making API calls
     * 
     * @param method    Specifies what API method to be used
     * @param params    Array of API parameters to accompany the method parameter
     * @param format    Specifies the response format, defaults to json
     * @return          Returns the reponse from the RTM API
     */
    public function get($method = '', $params = array(), $format = 'json') {
        if(empty($method)) {
            throw new RtmApiError('Error: API Method must be defined.');
        }

        $requestUrl = $baseUrl.'?method='.$method.$this->encodeUrlParams($params);

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $requestUrl);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, True);
        $reponse = ($format == 'json') ? json_decode(curl_exec($c)) : curl_exec($c);

        return $response;
    }
}