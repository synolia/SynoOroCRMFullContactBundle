<?php

namespace Synolia\Bundle\FullContactBundle\Listener;

use Doctrine\ORM\Event\OnFlushEventArgs;

use OroCRM\Bundle\ContactBundle\Entity\Contact;
use OroCRM\Bundle\ContactBundle\Entity\ContactEmail;

use Oro\Bundle\ConfigBundle\Config\ConfigManager;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Synolia\Bundle\FullContactBundle\Services\FullContact\Person as PersonService;

class FullContact extends ContainerAware
{
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $entities = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates()
        );

        foreach ($entities as $entity) {
            if (!($entity instanceof ContactEmail)) {
                continue;
            }

            if($entity->isPrimary()) {
                $owner = $entity->getOwner();
                $this->addFullContactInfos($owner, $entity->getEmail());

                // Force persist
                $em->persist($owner);
                $md = $em->getClassMetadata(get_class($owner));
                $uow->computeChangeSet($md, $owner);
            }
        }
    }

    private function addFullContactInfos(Contact $entity, $email)
    {
        $apiKey = $this->container->get('oro_config.global')->get('synolia_full_contact.api_key');

        if(!empty($apiKey)) {
            try {
                $fullContactService = new PersonService($apiKey);
                $response = $fullContactService->lookupByEmail($entity->getPrimaryEmail()->getEmail());
            } catch (\Exception $e) {
                $this->container->get('session')->getFlashBag()->add(
                    'error',
                    $this->container->get('translator')->trans('synolia.fullcontact.contacts.error.message')
                );
                return;
            }

            $entity->setTwitter($fullContactService->getTwitterId());
            $entity->setFacebook($fullContactService->getFacebookId());
            $entity->setGooglePlus($fullContactService->getGooglePlusId());
            $entity->setLinkedIn($fullContactService->getLinkedInId());

            $this->container->get('session')->getFlashBag()->add(
                'success',
                $this->container->get('translator')->trans('synolia.fullcontact.contacts.success.message')
            );
        }
    }
}