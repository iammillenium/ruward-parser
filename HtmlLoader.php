<?php

namespace HtmlLoader;

class HtmlLoader
{
  private $url;
  private $html;

  public function __construct($url)
  {
    $this->url = $url;
  }

  public function loadHtml($reload = false)
  {
    if (!empty($this->html) && !$reload) {
      return $this->html;
    }

    $options = array(
      CURLOPT_POST => false,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0,
    );

    $curl = curl_init($this->url);

    curl_setopt_array($curl, $options);

    $html = curl_exec($curl);

    $this->html = $html;

    return $this->html;
  }
}
