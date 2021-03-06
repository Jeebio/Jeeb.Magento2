<?php
/**
 * Jeeb PlaceOrder controller
 *
 * @category    Jeeb
 * @package     Jeeb_Merchant
 * @author      Jeeb
 * @copyright   Jeeb (https://jeeb.com)
 * @license     https://github.com/jeeb/magento2-plugin/blob/master/LICENSE The MIT License (MIT)
 */
namespace Jeeb\Merchant\Controller\Payment;

use Jeeb\Merchant\Model\Payment as JeebPayment;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Model\OrderFactory;

class PlaceOrder extends Action
{
    protected $orderFactory;
    protected $jeebPayment;
    protected $checkoutSession;

    /**
     * @param Context $context
     * @param OrderFactory $orderFactory
     * @param Session $checkoutSession
     * @param JeebPayment $jeebPayment
     */
    public function __construct(
        Context $context,
        OrderFactory $orderFactory,
        Session $checkoutSession,
        JeebPayment $jeebPayment
    )
    {
        parent::__construct($context);

        $this->orderFactory = $orderFactory;
        $this->jeebPayment = $jeebPayment;
        $this->checkoutSession = $checkoutSession;
    }

    public function execute()
    {
        $id = $this->checkoutSession->getLastOrderId();

        $order = $this->orderFactory->create()->load($id);

        if (!$order->getIncrementId()) {
            $this->getResponse()->setBody(json_encode(array(
                'status' => false,
                'reason' => 'Order Not Found',
            )));

            // return;
        }

        // $this->jeebPayment->getJeebRequest($order);

        // $hello = $this->jeebPayment->getJeebRequest($order);
        // \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('Response =>'.var_export($hello, TRUE));
        // \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('Response =>'.$hello["token"]);
        //
        //
        // $params = array(
        //   'token'=> $hello["token"]
        // );
        // \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('Response =>'. var_export($params, TRUE));
        //
        // $this->_redirect($url."payments/invoice",$param);


        $this->getResponse()->setBody(json_encode($this->jeebPayment->getJeebRequest($order)));

        // \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info('Response =>'. var_export($hello, TRUE));
        //

        // Mage::app()->getResponse()->setRedirect($hello["url"]."payments/invoice")->sendResponse();
        // $this->_redirectUrl($hello["url"]."payments/invoice",$params);

        return;
    }
}
