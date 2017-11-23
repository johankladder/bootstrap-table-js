<?php
/**
 * Created by PhpStorm.
 * User: johankladder
 * Date: 19-11-17
 * Time: 19:06
 */

namespace JohanKladder\BootstrapTableJs;

class BootstrapTable
{


    public static function create(array $options = [])
    {
        $instant = new BootstrapTable($options);
        return $instant->render();
    }

    private $options;

    private $data;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    private function getData()
    {
        return $this->data;
    }

    private function getHeaders()
    {
        return $this->extractFromOptions('headers', new BootstrapTableJsException());
    }

    private function getTableOptions()
    {
        return $this->extractFromOptions('options');
    }

    private function getCustomValues()
    {
        foreach ($this->getHeaders() as $header) {
            if (array_key_exists('value', $header)) {
                $this->setCustomValueData($header);
            }
        }
    }

    private function setCustomValueData($header)
    {
        $this->data = $this->extractFromOptions('data', new BootstrapTableJsException());
        foreach ($this->data as &$currentData) {
            $currentData[$header['key']] = call_user_func_array(
                $header['value'], $currentData
            );
        }
    }


    private
    function extractFromOptions($key, \Exception $exception = null)
    {
        if (array_key_exists($key, $this->options)) {
            return $this->options[$key];
        } else {
            if ($exception) {
                throw $exception;
            }
        }
        return [];
    }

    public
    function render()
    {
        $this->getCustomValues();

        return view('bootstrap-table-js::table-view', [
            'parsedData' => $this->getData(),
            'headers' => $this->getHeaders(),
            'options' => $this->getTableOptions(),
        ]);
    }

}