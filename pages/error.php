<?php
/** @var Throwable $exception */
/** @var bool $displayErrors */

$title = 'Error';
include(__DIR__ . '/../_header.php');

?>
<h1>An error occurred</h1>
<?php
if ($displayErrors) {
    ?><pre><?php echo (string)$exception; ?></pre><?php
}

include(__DIR__ . '/../_footer.php');
