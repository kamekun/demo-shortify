<?php
function code(int $length = 5)
{
    return substr((string) Str::uuid(), 0, $length);
}