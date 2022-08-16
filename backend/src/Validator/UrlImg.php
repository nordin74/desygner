<?php
declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UrlImg extends Constraint
{
    public $mimeTypes = [];
    public $message = 'The [url] does not contains a valid image.';
    public $mode = 'strict'; // If the constraint has configuration options, define them as public properties
}