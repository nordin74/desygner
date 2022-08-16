<?php
declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UrlImgValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UrlImg) {
            throw new UnexpectedTypeException($constraint, UrlImg::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $context = stream_context_create(['http' => ['method' => 'HEAD', 'header' => 'user-agent: PHP_' . PHP_VERSION]]);
        if (!$headerInfo = get_headers($value, 1, $context)) {
            $this->context->addViolation('The [url] is not reachable');

            return;
        }

        $headerInfo = array_change_key_case($headerInfo, CASE_LOWER);
        if (!in_array($headerInfo['content-type'], $constraint->mimeTypes)) {
            $this->context->addViolation($constraint->message);
        }
    }
}