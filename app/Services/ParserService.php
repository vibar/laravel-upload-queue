<?php

namespace App\Services;


use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;
use App\Contracts\Services\ParserInterface;

class ParserService implements ParserInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var \Akeneo\Component\SpreadsheetParser\SpreadsheetInterface
     */
    private $content;

    /**
     * @var integer
     */
    private $offsetRow;

    /**
     * @var SpreadsheetParser
     */
    private $spreadsheetParser;

    public function __construct(SpreadsheetParser $spreadsheetParser)
    {
        $this->spreadsheetParser = $spreadsheetParser;
    }

    /**
     * @param string $path
     * @param int $offsetRow
     * @return ParserService
     */
    public function open(string $path, int $offsetRow = 0)
    {
        $this->path = $path;
        $this->offsetRow = $offsetRow;
        $this->content = $this->spreadsheetParser->open($this->path);

        return $this;
    }

    /**
     * @return array
     */
    public function get() : array
    {
        $data = [];

        foreach ($this->content->getWorksheets() as $index => $title) {

            $columns = [];

            foreach ($this->content->createRowIterator($index) as $row => $values) {

                if ($row < $this->offsetRow) {
                    continue;
                }

                if ($row == $this->offsetRow) { // columns
                    $columns = $values;
                    continue;
                }

                $data[] = array_combine($columns, $values);
            }
        }

        return $data;
    }
}
