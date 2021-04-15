<?php
namespace App\Service\Archive;

use App\Entity\Archive\Authorship;
use App\Repository\Archive\AuthorshipRepository;
use App\Service\AbstractEntityService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AuthorshipService
 * @package App\Service\Archive
 * @property AuthorshipRepository $repository
 */
class AuthorshipService extends AbstractEntityService
{
    private $translator;
    public function __construct(ManagerRegistry $managerRegistry, ValidatorInterface $validator, SessionInterface $session, TranslatorInterface $translator)
    {
        parent::__construct($managerRegistry, $validator, $session);
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Authorship::class;
    }

    /**
     * @param Authorship $authorship
     * @throws Exception
     */
    public function create(Authorship $authorship)
    {
        $author = $authorship->getAuthor();
        $authorLabel = $authorship->getAuthorLabel();
        if(!$author and !trim($authorLabel)){
            throw new Exception($this->translator->trans('error.authorship.author'), 400);
        }
        if(!$author){
            # get first and last name from author label
            $authorLabel = str_replace("  ", " ", $authorLabel);
            $array = explode(' ', trim($authorLabel));
            $firstName = trim($array[0]);
            $lastName = trim(str_replace($firstName, "", $authorLabel));
            dump("First: $firstName");
            dump("Last: $lastName");
            die();
        }
        /*dump($authorship->getAuthorLabel());
        die();*/
    }
}