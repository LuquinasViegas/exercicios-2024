<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {

    $xpath = new \DomXPath($dom);

    //  Retorna toda a classe que contem 'paper-card'
    $paperCards = $xpath->query("//a[contains(@class,'paper-card')]");

    $objPaperArray = array();

    // Para cada 'a.paper-card' vai localizar somente 'paper'
    foreach($paperCards as $paper) {
      $paperArray = array();

      // Retorna o campo específico de cada paper(id,title,type)
      $id = $xpath->query(".//followwing::div[contains(@class,'volume-info')]", $paper);
      $title = $xpath->query(".//h4[contains(@class,'paper-title')]", $paper);
      $type = $xpath->query(".//following::div[contains(@class,'tags')]", $paper);

      $paperArray['id'] = $id[0]->nodeValue;
      $paperArray['title'] = $title[0]->nodeValue;
      $paperArray['type'] = $type[0]->nodeValue;

  


    }
    return [
      
    ];
  }

}
