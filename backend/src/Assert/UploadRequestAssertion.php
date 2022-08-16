<?php
declare(strict_types=1);

namespace App\Assert;

use App\Validator\UrlImg;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class UploadRequestAssertion
{
    const TYPES = ['file', 'url'];
    const MIMES = ['image/jpeg', 'image/png'];


    /** @var mixed */
    private       $resource;
    private array $resourcesConstraints;
    private $defaultConstraints;
    private array $defaultInputs;


    public function __construct()
    {
        $this->defaultConstraints = new Assert\Collection([
            'providerName' => new Assert\NotBlank,
            'tags' => new Assert\NotBlank,
            'type' => new Assert\Sequentially([new Assert\NotBlank, new Assert\Choice(self::TYPES)])
        ]);

        $this->resourcesConstraints = [
            'file' => fn() => new Assert\File([
                'maxSize' => '1024k', 'mimeTypes' => self::MIMES,
                'mimeTypesMessage' => 'Please upload a valid image'
            ]),
            'url' => fn() => new UrlImg(['mimeTypes' => self::MIMES])
        ];
    }


    public function setFromRequest($providerName, $tags, $type, $resource)
    {
        $this->defaultInputs = ['providerName' => $providerName, 'tags' => $tags, 'type' => $type];
        $this->resource = $resource;
    }


    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        $validator = $context->getValidator();
        $errors = $validator->validate($this->defaultInputs, $this->defaultConstraints);

        if ($errors->count()) {
            $this->addViolations($errors, $context);

            return;
        }

        $type = $this->resourcesConstraints[$this->defaultInputs['type']];
        $errors = $validator->validate($this->resource, $type());
        if ($errors->count()) {
            $this->addViolations($errors, $context);
        }
    }


    public function addViolations($errors, $context)
    {
        foreach($errors as $error) {
            $context->addViolation($error->getMessage(), ['value' => $error->getPropertyPath()]);
        }
    }
}
