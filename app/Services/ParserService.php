<?php

namespace App\Services;


use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;
use App\Contracts\Services\ParserServiceInterface;

class ParserService implements ParserServiceInterface
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
     * @param string|string $path
     * @param int|int $offsetRow
     * @return array
     * @throws \Exception
     */
    public function parse(string $path, int $offsetRow = 0) : array
    {
        $this->path = $path;
        $this->offsetRow = $offsetRow;

        if (! file_exists($this->path)) {
            throw new \Exception('Open file error.');
        }

        $this->content = $this->spreadsheetParser->open($this->path);

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
