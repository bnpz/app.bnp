<?php
namespace App\Command;

use App\Entity\Archive\AuthorshipType;
use App\Service\Archive\AuthorshipTypeService;
use App\Service\User\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateAuthorshipTypesCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:authorship-types:create';

    /**
     * @var AuthorshipTypeService
     */
    private $authorshipTypeService;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService, AuthorshipTypeService $authorshipTypeService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->authorshipTypeService = $authorshipTypeService;
    }

    protected function configure()
    {
        $this->setDescription('Creates Authorship Types');

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user = $this->userService->findByEmail("info@bnp.ba");

        $types = [
            ['skr' => 'ad.', 'naziv' => 'Adaptacija'],
            ['skr' => 'an.', 'naziv' => 'Animacija'],
            ['skr' => 'a.r.', 'naziv' => 'Asistent reditelja'],
            ['skr' => 'a.sc.', 'naziv' => 'Asistent scenografa'],
            ['skr' => 'd.', 'naziv' => 'Dirigent'],
            ['skr' => 'dm.', 'naziv' => 'Dramatizacija'],
            ['skr' => 'dr.', 'naziv' => 'Dramaturgija'],
            ['skr' => 'ism.', 'naziv' => 'Izbor muzike'],
            ['skr' => 'izr.l.', 'naziv' => 'Izrada lutaka'],
            ['skr' => 'izr.ms.', 'naziv' => 'Izrada maski'],
            ['skr' => 'izv.', 'naziv' => 'Izvođač'],
            ['skr' => 'izv.pr.', 'naziv' => 'Izvršni producent'],
            ['skr' => 'jez.ad.', 'naziv' => 'Jezička adaptacija'],
            ['skr' => 'k.svj.', 'naziv' => 'Kreator svjetla'],
            ['skr' => 'kl.', 'naziv' => 'Kreacija lutaka'],
            ['skr' => 'komp.', 'naziv' => 'Kompozitor'],
            ['skr' => 'kp.', 'naziv' => 'Korepetitor'],
            ['skr' => 'kr.', 'naziv' => 'Koreografija'],
            ['skr' => 'ks.', 'naziv' => 'Kostimografija'],
            ['skr' => 'lk.', 'naziv' => 'Lektor'],
            ['skr' => 'lut.', 'naziv' => 'Lutke'],
            ['skr' => 'm.p.', 'naziv' => 'Muzička pratnja'],
            ['skr' => 'ms.', 'naziv' => 'Maske'],
            ['skr' => 'mz.', 'naziv' => 'Muzika'],
            ['skr' => 'ms.sr.', 'naziv' => 'Muzički saradnik'],
            ['skr' => 'org.', 'naziv' => 'Organizacija'],
            ['skr' => 'p.r.', 'naziv' => 'Pomoćnik reditelja'],
            ['skr' => 'pr.', 'naziv' => 'Prevod'],
            ['skr' => 'prod.', 'naziv' => 'Producent'],
            ['skr' => 'red.', 'naziv' => 'Režija'],
            ['skr' => 'r.obn.', 'naziv' => 'Režiju obnovio'],
            ['skr' => 'sc.', 'naziv' => 'Scenografija'],
            ['skr' => 'sp.', 'naziv' => 'Scenski pokret'],
            ['skr' => 'svj.', 'naziv' => 'Svjetlo'],
            ['skr' => 'vid.', 'naziv' => 'Video']

        ];

        foreach ($types as $type) {
            $skr = $type['skr'];
            $naziv = $type['naziv'];

            $existingType = $this->authorshipTypeService->getRepository()->findOneBy(['abbreviation' => $skr]);
            if(!$existingType instanceof AuthorshipType){
                $output->writeln("$skr - $naziv");
                $authorshipType = new AuthorshipType();
                $authorshipType->setAbbreviation($skr)->setName($naziv)->setCreatedBy($user)->setUpdatedBy($user);
                $this->authorshipTypeService->save($authorshipType);
            }

        }

        $io->success('DONE');

        return 0;
    }
}