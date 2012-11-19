<?php

namespace Dx\Doctrine\Mapping\Event\Adapter;

use Dx\Doctrine\Mapping\Event\AdapterInterface;
use Doctrine\Common\EventArgs;
use Doctrine\ORM\EntityManager;

/**
 * Doctrine event adapter for ORM specific
 * event arguments
 * 
 * @author Dennes B Abing <dennes.b.abing@gmail.com>
 * @package Dx.Doctrine.Mapping.Event
 * @subpackage ORM
 * @link http://labs.madayaw.com
 */
class ORM implements AdapterInterface
{
    /**
     * @var \Doctrine\Common\EventArgs
     */
    private $args;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritdoc}
     */
    public function setEventArgs(EventArgs $args)
    {
        $this->args = $args;
    }

    /**
     * {@inheritdoc}
     */
    public function getDomainObjectName()
    {
        return 'Entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getManagerName()
    {
        return 'ORM';
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args)
    {
        if (is_null($this->args)) {
            throw new RuntimeException("Event args must be set before calling its methods");
        }
        $method = str_replace('Object', $this->getDomainObjectName(), $method);
        return call_user_func_array(array($this->args, $method), $args);
    }

    /**
     * Set the entity manager
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectManager()
    {
        if (!is_null($this->em)) {
            return $this->em;
        }
        return $this->__call('getEntityManager', array());
    }

    /**
     * {@inheritdoc}
     */
    public function getObjectChangeSet($uow, $object)
    {
        return $uow->getEntityChangeSet($object);
    }

    /**
     * {@inheritdoc}
     */
    public function getSingleIdentifierFieldName($meta)
    {
        return $meta->getSingleIdentifierFieldName();
    }

    /**
     * {@inheritdoc}
     */
    public function recomputeSingleObjectChangeSet($uow, $meta, $object)
    {
        $uow->recomputeSingleEntityChangeSet($meta, $object);
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledObjectUpdates($uow)
    {
        return $uow->getScheduledEntityUpdates();
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledObjectInsertions($uow)
    {
        return $uow->getScheduledEntityInsertions();
    }

    /**
     * {@inheritdoc}
     */
    public function getScheduledObjectDeletions($uow)
    {
        return $uow->getScheduledEntityDeletions();
    }

    /**
     * {@inheritdoc}
     */
    public function setOriginalObjectProperty($uow, $oid, $property, $value)
    {
        $uow->setOriginalEntityProperty($oid, $property, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function clearObjectChangeSet($uow, $oid)
    {
        $uow->clearEntityChangeSet($oid);
    }
}