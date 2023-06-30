<?php

namespace App\Services;

use App\Entity\Maintenance;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MaintenanceService
{
    private CacheInterface $cache;
    private ParameterBagInterface $parameterBag;

    /**
     * MaintenanceService constructor.
     *
     * @param ParameterBagInterface $parameterBag
     * @param CacheInterface $cache
     */
    public function __construct(ParameterBagInterface $parameterBag, CacheInterface $cache) {
        $this->parameterBag = $parameterBag;
        $this->cache = $cache;
    }

    /**
     * Gets the appropriate maintenance response
     *
     * @param string|null $backend_name
     * @param string $host
     * @return Maintenance
     */
    public function getResponse(?string $backend_name, string $host): Maintenance
    {
        $maintenances = $this->loadMaintenances();
        /** @var Maintenance $maintenance */
        foreach ($maintenances as $maintenance) {
            if (
                ($maintenance->getBackendName() !== null && $backend_name !== null && preg_match($maintenance->getBackendName(), $backend_name))
                || ($maintenance->getHost() !== null && preg_match($maintenance->getHost(), $host))
            ) {
                return $maintenance;
            }
        }
        // Send fallback, if no specific maintenance object found
        return new Maintenance();
    }

    /**
     * Loads maintenance objects from disk and parses them
     *
     * @return array
     */
    public function loadMaintenances(): array
    {
        try {
            return $this->cache->get('maintenance-data', function (ItemInterface $item) {
                $item->expiresAfter(60);
                $encoders = [new JsonEncoder()];
                $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
                $serializer = new Serializer($normalizers, $encoders);
                $finder = new Finder();
                $path = $this->parameterBag->get('kernel.project_dir') . '/var/maintenance';
                $finder->files()->in($path)->sortByName();
                $data = [];
                foreach ($finder as $file) {
                    $array = $serializer->deserialize($file->getContents(), 'App\Entity\Maintenance[]', 'json');
                    foreach ($array as $maintenance) {
                        $data[] = $maintenance;
                    }
                }
                return $data;
            });
        } catch (InvalidArgumentException $e) {
            return [];
        }
    }
}