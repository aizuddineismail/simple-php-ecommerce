<?php
class Product
{
    private $username = MANGO_USERNAME;
    private $password = MANGO_PASSWORD;
    private $url = MANGO_URL;

    public function getProductByPage($id = 1)
    {
        $tempUrl = $this->url . '?page=' . $id;
        $headers = [];
        // $tempUrl = "https://jsonplaceholder.typicode.com/posts";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tempUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                {
                    return $len;
                }

                $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                return $len;
            }
        );

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
        $result = curl_exec($ch);

        curl_close($ch);
        // print_r($headers);

        // echo $result;
        $result = json_decode($result, true);
        
        $products = [
            'currentPage' => $id,
            'totalPages' => $headers['x-wp-totalpages'][0],
            'body' => $result
        ];

        return $products;
    }

    public function getProductById($id) {
        $tempUrl = $this->url . '/' .$id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tempUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$this->username:$this->password");
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        return $result;
    }
}
