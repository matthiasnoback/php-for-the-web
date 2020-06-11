<?php

fopen(__DIR__ . '/this-file-does-not-exist', 'r');

echo 'PHP does not stop execution, even when something went wrong';

//throw new RuntimeException('Something went wrong');
