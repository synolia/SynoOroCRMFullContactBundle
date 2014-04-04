<?php

namespace Synolia\Bundle\FullContactBundle\Services\FullContact;

use Synolia\Bundle\FullContactBundle\Services\FullContact;

class Person extends FullContact {

    /**
     * Supported lookup methods
     * @var $supportedMethods
     */
    protected $supportedMethods = array('email', 'phone', 'twitter', 'facebookUsername');
    protected $resourceUri = '/person.json';

    public function lookupByEmail($search)
    {
        $this->run(array('email' => $search, 'method' => 'email'));

        return $this->responseObject;
    }

    public function lookupByEmailMD5($search)
    {
        $this->run(array('emailMD5' => $search, 'method' => 'email'));

        return $this->responseObject;
    }

    public function lookupByPhone($search)
    {
        $this->run(array('phone' => $search, 'method' => 'phone'));

        return $this->responseObject;
    }

    public function lookupByTwitter($search)
    {
        $this->run(array('twitter' => $search, 'method' => 'twitter'));

        return $this->responseObject;
    }

    public function lookupByFacebook($search)
    {
        $this->run(array('facebookUsername' => $search, 'method' => 'facebookUsername'));

        return $this->responseObject;
    }

    public function getTwitterId()
    {
        if(isset($this->responseObject->socialProfiles->twitter)) {
            $firstElement = $this->responseObject->socialProfiles->twitter[0];
            return $firstElement->username;
        }

        return null;
    }

    public function getFacebookId()
    {
        if($facebook = isset($this->responseObject->socialProfiles->facebook)) {
            $firstElement = $this->responseObject->socialProfiles->facebook[0];
            return $firstElement->id;
        }

        return null;
    }

    public function getGooglePlusId()
    {
        if($googlePlus = isset($this->responseObject->socialProfiles->googleplus)) {
            $firstElement = $this->responseObject->socialProfiles->googleplus[0];
            return $firstElement->id;
        }

        return null;
    }

    public function getLinkedInId()
    {
        if($linkedIn = isset($this->responseObject->socialProfiles->linkedin)) {
            $firstElement = $this->responseObject->socialProfiles->linkedin[0];
            return $firstElement->username;
        }

        return null;
    }
} 