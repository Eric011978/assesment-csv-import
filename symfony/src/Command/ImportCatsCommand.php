<?php

namespace App\Command;

use App\Entity\Cat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(name: 'app:import-cats', description: 'Import cats from CSV file into database')]
class ImportCatsCommand extends Command
{
    private readonly string $projectDir;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        KernelInterface $kernel
    ) {
        $this->projectDir = $kernel->getProjectDir();
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $file = $this->projectDir . '/data/imports/cats.CSV';
        if (!is_file($file)) {
            $io->error(sprintf('File "%s" not found.', $file));
            return Command::FAILURE;
        }

        $handle = fopen($file, 'r');
        if (false === $handle) {
            $io->error('Unable to open file.');
            return Command::FAILURE;
        }

        $count = 0;
        while (($data = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
            if ($data === [null] || count($data) < 2) {
                continue;
            }

            $name = trim((string) $data[0]);
            $description = trim((string) $data[1]);

            if ($name === '') {
                continue;
            }

            $cat = new Cat();
            $cat->setName($name);
            $cat->setDescription($description);

            $this->entityManager->persist($cat);
            ++$count;
        }

        fclose($handle);

        $this->entityManager->flush();

        $io->success(sprintf('Imported %d cats.', $count));

        return Command::SUCCESS;
    }
}
