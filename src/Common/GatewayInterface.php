<?php
/**
 * Payment gateway interface
 */

namespace Omnibill\Common;

/**
 * Payment gateway interface
 *
 * This interface class defines the standard functions that any
 * Omnipay gateway needs to define.
 *
 *
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array()) (Optional method)
 *         Receive and handle an instant payment notification (IPN)
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())               (Optional method)
 *         Authorize an amount on the customers card
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())       (Optional method)
 *         Handle return from off-site gateways after authorization
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())                 (Optional method)
 *         Capture an amount you have previously authorized
 * @method \Omnipay\Common\Message\RequestInterface purchase(array $options = array())                (Optional method)
 *         Authorize and immediately capture an amount on the customers card
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())        (Optional method)
 *         Handle return from off-site gateways after purchase
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())                  (Optional method)
 *         Refund an already processed transaction
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])             (Optional method)
 *         Fetches transaction information
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())                    (Optional method)
 *         Generally can only be called up to 24 hours after submitting a transaction
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())              (Optional method)
 *         The returned response object includes a cardReference, which can be used for future transactions
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())              (Optional method)
 *         Update a stored card
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())              (Optional method)
 *         Delete a stored card
 */
interface GatewayInterface
{
    public function getName(): string;

    public function getShortName(): string;

    public function getDefaultParameters(): array;

    public function initialize(array $parameters = []): self;

    public function getParameters();
}
