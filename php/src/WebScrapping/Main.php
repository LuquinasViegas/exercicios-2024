<?php

namespace Chuva\Php\WebScrapping;

/**
 * Runner for the Webscrapping exercice.
 */
class Main {

  /**
   * Main runner, instantiates a Scrapper and runs.
   */
  public static function run(): void {
    $dom = new \DOMDocument('1.0', 'utf-8');
    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    $data = (new Scrapper())->scrap($dom);

    $xpath = new \DomXPath($dom);
    $nodeList = $xpath->query("//div[@class='volume-info']");
    $node = $nodeList->item(0);
    $conteudoDaDiv = $node->nodeValue;

    print("\n\n\n\n\n\n\n\n");
    print_r($conteudoDaDiv);
    print("\n\n\n\n\n\n\n\n");

    // Write your logic to save the output file bellow.
    print_r($data);
  }

}
