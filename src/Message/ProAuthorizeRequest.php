<?php

namespace Omnipay\PayPal\Message;

/**
 * PayPal Pro Authorize Request
 */
class ProAuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'card');

        $card = $this->getCard();
        $card->validate();

        $data = $this->getBaseData();
        $data['METHOD'] = 'DoDirectPayment';
        $data['PAYMENTACTION'] = 'Authorization';
        $data['AMT'] = $this->getAmount();
        $data['CURRENCYCODE'] = $this->getCurrency();
        $data['INVNUM'] = $this->getTransactionId();
        $data['DESC'] = $this->getDescription();

        // add credit card details
        $data['ACCT'] = $card->getNumber();
        $data['CREDITCARDTYPE'] = $card->getBrand();
        $data['EXPDATE'] = $card->getExpiryDate('mY');
        $data['STARTDATE'] = $card->getStartDate('mY');
        $data['CVV2'] = $card->getCvv();
        $data['ISSUENUMBER'] = $card->getIssueNumber();
        $data['IPADDRESS'] = $this->getClientIp();
        $data['FIRSTNAME'] = $card->getFirstName();
        $data['LASTNAME'] = $card->getLastName();
        $data['EMAIL'] = $card->getEmail();
        $data['STREET'] = $card->getAddress1();
        $data['STREET2'] = $card->getAddress2();
        $data['CITY'] = $card->getCity();
        $data['STATE'] = $card->getState();
        $data['ZIP'] = $card->getPostcode();
        $data['COUNTRYCODE'] = strtoupper($card->getCountry());

        // shipping information
        $data['SHIPTONAME'] = $card->getShippingName();
        $data['SHIPTOSTREET'] = $card->getShippingAddress1();
        $data['SHIPTOSTREET2'] = $card->getShippingAddress2();
        $data['SHIPTOCITY'] = $card->getShippingCity();
        $data['SHIPTOSTATE'] = $card->getShippingState();
        $data['SHIPTOZIP'] = $card->getShippingPostcode();
        $data['SHIPTOCOUNTRYCODE'] = strtoupper($card->getShippingCountry());
        $data['SHIPTOPHONENUM'] = $card->getShippingPhone();

        return $data;
    }
}
