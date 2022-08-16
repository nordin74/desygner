<?php
declare(strict_types=1);

namespace App\Controller;

use App\Assert\UploadRequestAssertion;
use App\Entity\File;
use App\Repository\FileRepository;
use App\Service\ResourceHandlerFactory;
use App\Service\StorageFactory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class FilesController extends AbstractController
{
    public function upload(
        Request                $request,
        ResourceHandlerFactory $resourceFactory,
        ValidatorInterface     $validator,
        UploadRequestAssertion $constraint,
        ManagerRegistry        $doctrine,
        File $file
    ): JsonResponse
    {
        $resource = $request->files->get('img') ? $request->files->get('img') : $request->get('resource');
        $constraint->setFromRequest($request->get('providerName'), $request->get('tags'), $request->get('type'), $resource);
        $errors = $validator->validate($constraint);
        if ($errors->count()) {
            $msgs = [];
            foreach($errors as $error) {
                $msgs[] = $error->getMessage();
            }

            return $this->json(['errors' => $msgs], 400);
        }

        $resourceHandler = $resourceFactory->create($request->get('type'));
        $uri = $resourceHandler->process($resource);

        $file->setUri($uri);
        $file->setProviderName($request->get('providerName'));
        $file->setTags($request->get('tags'));
        $doctrine->getManager()->persist($file);
        $doctrine->getManager()->flush();

        return $this->json(['id' => $file->getId()]);
    }


    public function search(Request $request, FileRepository $fileRepository, StorageFactory $storageFactory): JsonResponse
    {
        $tag = $request->query->get('tag');
        if (empty($tag)) {
            return $this->json(['errors' => 'Empty tag']);
        }
        $providerName = $request->query->get('providerName');

        $items = $fileRepository->findByTagAndProviderName($tag, $providerName);
        foreach ($items as &$item) {
            $storage = $storageFactory->createFromUri($item['uri']);
            $item['url'] = $storage->generatePublicUrl($item['uri']);
            unset($item['uri']);
        }

        return $this->json($items);
    }
}