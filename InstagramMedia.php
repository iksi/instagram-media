<?php

/**
 * fetch Instagram media
 *
 * @author Jurriaan <jurriaan@iksi.cc>
 * @version 1.0
 */
namespace Iksi;

class InstagramMedia {

  public $feed = 'https://www.instagram.com/%s/media/';
  public $username;
  public $query;

  public function __construct($username, $params = []) {
    $this->username = $username;
    $this->query = http_build_query($params);
  }

  public function feed() {
    $handle = curl_init();

    $url = sprintf($this->feed, $this->username);

    if(!empty($this->query)) {
      $url = "{$url}?{$this->query}";
    }

    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_HEADER, false);

    $response = curl_exec($handle);
    $httpcode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    curl_close($handle);

    if ($httpcode !== 200) {
      return false;
    }

    $array = json_decode($response, true);

    if(empty($array)) {
      return false;
    }

    return $array;
  }

}
