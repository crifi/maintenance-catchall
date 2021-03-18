<?php

namespace App\Services;

use App\Entity\Maintenance;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MaintenanceService
{
    /**
     * @var KernelInterface $kernel
     */
    private $kernel;

    /**
     * MaintenanceService constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel) {
        $this->kernel = $kernel;
    }

    /**
     * @param string $host
     * @return Maintenance
     */
    public function getResponse(string $host): Maintenance
    {
        $maintenances = $this->loadMaintenances();
        /** @var Maintenance $maintenance */
        foreach ($maintenances as $maintenance) {
            if (preg_match($maintenance->getHost(), $host)) {
                return $maintenance;
            }
        }
        // Send fallback, if no specific maintenance object found
        return new Maintenance();
    }

    /**
     * @return array
     */
    public function loadMaintenances(): array
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $finder = new Finder();
        $path = $this->kernel->getProjectDir() . '/var/maintenance';
        $finder->files()->in($path)->sortByName();
        $data = [];
        foreach ($finder as $file) {
            $array = $serializer->deserialize($file->getContents(), 'App\Entity\Maintenance[]', 'json');
            foreach ($array as $maintenance) {
                $data[] = $maintenance;
            }
        }
        return $data;
    }
}