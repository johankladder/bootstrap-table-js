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

    private $headers;

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
        if(!$this->headers) {
            $this->headers = $this->extractFromOptions('headers', new BootstrapTableJsException());
        }
        return $this->headers;
    }

    private function getTableOptions()
    {
        return $this->extractFromOptions('options');
    }

    private function getCustomValues()
    {
        $hit = false;
        foreach ($this->getHeaders() as $header) {
            if (array_key_exists('value', $header)) {
                $this->setCustomValueData($header);
                $hit = true;
            }
        }
        if (!$hit) {
            $this->data = $this->extractFromOptions('data', new BootstrapTableJsException());
        }

        $this->getAddonUrls($this->getHeaders());
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

    private function getAddonUrls($headers)
    {
        foreach ($headers as &$header) {
            if (array_key_exists('addon', $header)) {
                foreach ($header['addon'] as $add) {
                    foreach ($add as $a) {
                        if (array_key_exists('params', $a)) {
                            if (array_key_exists('url', $a['params'])) {
                                $urlFunction = $a['params']['url'];
                                foreach ($this->data as &$currentData) {
                                    $url = call_user_func_array($urlFunction, [$currentData]);
                                    $header['addon']['params']['url'] = $url;
                                }
                            }
                        }
                    }
                }
            }
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