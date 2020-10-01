<?php
namespace App\Service\AndroidApp;

use App\Entity\AndroidApp\Notification;
use App\Service\AbstractEntityService;
use DateTime;
use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class NotificationService
 * @package App\Service\AndroidApp
 */
class NotificationService extends AbstractEntityService
{

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Notification::class;
    }

    /**
     * @throws Exception
     */
    public function getDataFromWebsiteApi()
    {
        $client = HttpClient::create();
        $limit = $this->container->getParameter('android.app.results.limit');
        $newsUrl = $this->container->getParameter('android.app.api.vijesti.read')."?limit=$limit";

        print "GET NEWS"."<br>";
        try {

            # get response from website api
            $response = $client->request('GET', $newsUrl);

            if($response->getStatusCode() == 200){

                $responseArray = $response->toArray();
                $data = $responseArray['data'];
                foreach ($data as $item) {
                    /*echo "<pre>";
                    print_r($item);
                    echo "</pre>";*/
                    # todo: REMOVE NOT condition
                    if($this->_canBeCreated($item)){
                        print "CREATE<br>";
                    }
                    else{
                        print "DON'T CREATE<br>";
                    }
                }


            }
        }
        catch (TransportExceptionInterface $e) {
        }
        catch (ClientExceptionInterface $e) {
        }
        catch (DecodingExceptionInterface $e) {
        }
        catch (RedirectionExceptionInterface $e) {
        }
        catch (ServerExceptionInterface $e) {
        }
    }

    /**
     * @param array $item
     * @return bool
     * @throws Exception
     */
    private function _canBeCreated($item = [])
    {
        $canBeSaved = true;
        print $item['title']."<br>";
        if(!$this->_isToday(new DateTime($item['created']))){
            print "Not today<br>";
            $canBeSaved = false;
        }
        return $canBeSaved;
    }
    /**
     * @param DateTime $dateTime
     * @return bool
     */
    private function _isToday(DateTime $dateTime)
    {
        $today = new DateTime();
        if($today->format('d.m.Y') == $dateTime->format('d.m.Y')){
            return true;
        }
        else{
            return false;
        }
    }
}