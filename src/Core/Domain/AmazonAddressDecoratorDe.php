<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
namespace Amazon\Core\Domain;

use Amazon\Core\Api\Data\AmazonAddressInterface;

class AmazonAddressDecoratorDe implements AmazonAddressInterface
{
    /**
     * @var AmazonAddressInterface
     */
    private $amazonAddress;

    /**
     * @var array
     */
    private $responseData;

    /**
     * @param AmazonAddressInterface $amazonAddress
     * @param array $responseData
     */
    public function __construct(AmazonAddressInterface $amazonAddress, array $responseData)
    {
        $this->amazonAddress = $amazonAddress;
        $this->responseData = $responseData;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        $line1 = (string) $this->amazonAddress->getLines()[1];
        $line2 = (string) $this->amazonAddress->getLines()[2];
        $line3 = (string) $this->amazonAddress->getLines()[3];

        $lines = [];
        switch (true) {
            case !empty($line3):
                $lines = [$line3];
                $firstTwoLines = $line1 . ' ' . $line2;
                if ($this->isPOBox($line1, $firstTwoLines)) {
                    $lines[] = $firstTwoLines;
                }
                break;
            case !empty($line2):
                $lines = [$line2];
                if ($this->isPOBox($line1, $line1)) {
                    $lines[] = $line1;
                }
                break;
            case !empty($line1):
                $lines = [$line1];
                break;
        }

        return $lines;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        $line1 = (string) $this->amazonAddress->getLines()[1];
        $line2 = (string) $this->amazonAddress->getLines()[2];
        $line3 = (string) $this->amazonAddress->getLines()[3];

        $company = $this->amazonAddress->getCompany();
        switch (true) {
            case !empty($line3):
                $firstTwoLines = $line1 . ' ' . $line2;
                if (!$this->isPOBox($line1, $firstTwoLines)) {
                    $company = $firstTwoLines;
                }
                break;
            case !empty($line2):
                if (!$this->isPOBox($line1, $line1)) {
                    $company = $line1;
                }
                break;
        }

        return $company;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->amazonAddress->getFirstName();
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->amazonAddress->getLastName();
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->amazonAddress->getCity();
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->amazonAddress->getState();
    }

    /**
     * @return string
     */
    public function getPostCode()
    {
        return $this->amazonAddress->getPostCode();
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->amazonAddress->getCountryCode();
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->amazonAddress->getTelephone();
    }

    /**
     * Returns true if strings contain address.
     *
     * @param string $line1
     * @param string $line2
     * @return bool
     */
    private function isPOBox($line1, $line2)
    {
        return is_numeric($line1) || $this->isPackstationAddress($line2);
    }

    /**
     * @link https://en.wikipedia.org/wiki/Packstation
     * @param string $address
     * @return bool
     */
    private function isPackstationAddress($address)
    {
        return stripos($address, 'packstation') !== false;
    }

    /**
     * Get an address line
     *
     * @param int $lineNumber
     *
     * @return null|string
     */
    public function getLine($lineNumber) {
        $this->amazonAddress->getLine($lineNumber);
    }

    /**
     * Set full name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name) {
        $this->amazonAddress->setName($name);
    }

    /**
     * Set address lines
     *
     * @param array $lines
     *
     * @return $this
     */
    public function setLines($lines) {
        $this->amazonAddress->setLines($lines);
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city) {
        $this->amazonAddress->setCity($city);
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return $this
     */
    public function setState($state) {
        $this->amazonAddress->setState($state);
    }

    /**
     * Set postal code
     *
     * @param string $postCode
     *
     * @return $this
     */
    public function setPostCode($postCode) {
        $this->amazonAddress->setPostCode($postCode);
    }

    /**
     * Set country code
     *
     * @param string $countryCode
     *
     * @return $this
     */
    public function setCountryCode($countryCode) {
        $this->amazonAddress->setCountryCode($countryCode);
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return $this
     */
    public function setTelephone($telephone) {
        $this->amazonAddress->setTelephone($telephone);
    }

    /**
     * Set company name
     *
     * @param string $company
     *
     * @return $this
     */
    public function setCompany($company) {
        $this->amazonAddress->setCompany($company);
    }
}