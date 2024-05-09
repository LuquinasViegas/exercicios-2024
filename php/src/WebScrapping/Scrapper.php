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


      // Retorna a div da lista de autores 'div.authors' do Paper
      $authorsDiv = $xpath->query(".//following::div[contains(@class,'authors')]", $paper);
    
      // Para cada 'span' em 'div.authors'
      $authors = $xpath->query(".//span", $authorsDiv[0]);

      // Cria array de objetos de autores
      $objAuthorsArray = array();
      foreach($authors as $author) {
        // Cria array individual para cada autor
        $authorArray = array();

        // Condição necessária pois no ID 137457 após RAFAEL ALVES DE ANDRADE existe um campo vazio
        if($author->nodeValue !="") {
        // Retorna o valor absoluto do nó
        $authorName = str_replace(";","", $author->nodeValue);
        // Retorna o valor do atributo 'title'
        $authorInstitution = $author->attributes["title"]->nodeValue;
        $authorArray['name'] = $authorName;
        $authorArray['institution'] = $authorInstitution;
        // Inseree no array individual nome e intituição do autor
        array_push($objAuthorsArray, new Person($authorName, $authorInstitution));
        }

      }

    }
    return [
      
    ];
  }

}
