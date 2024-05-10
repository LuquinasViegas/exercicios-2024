<?php

namespace Chuva\Php\WebScrapping;

// Adciona as bibliotecas ao código.
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

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

    // Write your logic to save the output file bellow.
    // print_r($data);
    // Define o diretório e nome do arquivo a ser criado.
    $filePath = __DIR__ . '/planilha.xlsx';

    // Cria um objeto para escrever planilha XLSX e abre o arquivo.
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile($filePath);

    // Define estilos da primeira linha e dos dados.
    $firstRowStyle = (new StyleBuilder())
      ->setFontName('Arial')
      ->setFontSize(11)
      ->setFontBold('')
      ->build();

    $style = (new StyleBuilder())
      ->setFontName('Arial')
      ->setFontSize(11)
      ->build();

    // Define texto cabeçalho (1 linha)
    $firstRow = ["id", "title", "type"];
    // Como a maior quantidade de autor é 16, escreve 16x.
    for ($x = 1; $x <= 16; $x++) {
      array_push($firstRow, "Author " . $x, "Author " . $x . " Institution");
    }
    // Adciona primira linha a planilha.
    $writer->addRow(
      WriterEntityFactory::createRowFromArray($firstRow, $firstRowStyle)
    );

    // Para cada dado retornado da função 'scrap()'
    foreach ($data as $paper) {
      // Prepara um array para ser inserido nas linhas seguintes.
      $newRow = [
        $paper->id,
        $paper->title,
        $paper->type,
      ];
      // Para cada autor do paper adciona seu nome e instituição.
      foreach ($paper->authors as $author) {
        array_push($newRow, $author->name);
        array_push($newRow, $author->institution);
      }

      // Adciona a linha na planilha.
      $writer->addRow(
        WriterEntityFactory::createRowFromArray($newRow, $style)
      );
    }

    // Encerra conexão com o arquivo.
    $writer->close();

  }

}
