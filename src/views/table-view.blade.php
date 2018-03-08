<?php

/**
 * @var array $parsedData
 */

?>

<!-- Require the stylesheet: -->
<link rel="stylesheet" href="{{ asset('bootstrap-table-js/css/style.css') }}"/>

<vue-table
        entities='{{ json_encode($parsedData) }}'
        headers='{{ json_encode($headers)}}'
        options='{{ json_encode($options) }}'
>
</vue-table>
