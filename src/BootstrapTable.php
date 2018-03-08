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

    private $options;

    private $data;

    private $headers;

    /**
     * @param array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public static function create(array $options = [])
    {
        $instant = new BootstrapTable($options);
        return $instant->render();
    }

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    private function getData()
    {
        if (!$this->data) {
            $this->data = $this->extractFromOptions('data', new BootstrapTableJsException('Missing data'));
        }
        return $this->data;
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    private function getHeaders()
    {
        if (!$this->headers) {
            $this->headers = $this->extractFromOptions('headers', new BootstrapTableJsException('Missing headers'));
        }
        return $this->headers;
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    private function getTableOptions()
    {
        return $this->extractFromOptions('options');
    }

    /**
     * @throws \Exception
     */
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
            $this->data = $this->extractFromOptions('data', new BootstrapTableJsException('Missing data'));
        }

        $this->getAddonUrls($this->getHeaders());
    }

    /**
     * @param $header
     * @throws \Exception
     */
    private function setCustomValueData($header)
    {
        $tempData = $this->getData();
        foreach ($tempData as &$currentData) {
            $currentData[$header['key']] = call_user_func_array(
                $header['value'], $currentData
            );
        }
        $this->data = $tempData;
    }

    private function getAddonUrls($headers)
    {
        foreach ($headers as &$header) {
            if (array_key_exists('addon', $header)) {
                foreach ($header['addon'] as &$add) {
                    foreach ($add as &$a) {
                        if (array_key_exists('params', $a)) {
                            if (array_key_exists('url', $a['params'])) {
                                $urlFunction = $a['params']['url'];
                                $tempData = $this->data;
                                foreach ($tempData as &$currentData) {
                                    $url = call_user_func_array($urlFunction, [$currentData]);
                                    $currentData[$a['key'] . '_url'] = $url;
                                }
                                $this->data = $tempData;
                            }
                        }
                    }
                }
            }
        }
        $this->headers = $headers;
    }


    /**
     * @param $key
     * @param \Exception|null $exception
     * @return array|mixed
     * @throws \Exception
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public
    function render()
    {
        $this->getCustomValues();

        //var_dump($this->getData());

        return view('bootstrap-table-js::table-view', [
            'parsedData' => $this->getData(),
            'headers' => $this->getHeaders(),
            'options' => $this->getTableOptions(),
        ]);
    }

}