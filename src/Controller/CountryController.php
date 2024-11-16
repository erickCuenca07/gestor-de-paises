<?php

namespace App\Controller;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/')]
class CountryController extends AbstractController
{
    public function __construct(private HttpClientInterface $httpClient, private EntityManagerInterface $entityManager){}
    #[Route(name: 'app_country_index', methods: ['GET'])]
    public function index(CountryRepository $countryRepository)
    {
        $countries = $countryRepository->findAll();    
        $countryData = array_map(function ($country) {
            return [
                'id' => $country->getId(),
                'name' => $country->getName(),
                'capital' => $country->getCapital(),
                'region' => $country->getRegion(),
                'subregion' => $country->getSubregion(),
                'population' => $country->getPopulation(),
                'area' => $country->getArea(),
                'continent' => $country->getContinent(),
                'flag' => $country->getFlag(),
            ];
        }, $countries);

        return $this->render('base.html.twig', [
            'countries' => json_encode($countryData)
        ]);
    }
    
    #[Route('/addCountry/{name}', name: 'app_country_new', methods: ['POST'])]
    public function addCountry(string $name)
    {
        try {
            $response = $this->httpClient->request('GET', "https://restcountries.com/v3.1/name/$name");
            $countries = $response->toArray();
            if(!empty($countries)){
                $dataCountry = $countries[0];

                $country = $this->entityManager->getRepository(Country::class)->findOneBy(['name' => $dataCountry['name']['common']]);

                if (!$country) {

                $country = new Country();
                $country->setName($dataCountry['name']['common']);
                $country->setCapital($dataCountry['capital'][0]);
                $country->setRegion($dataCountry['region']);
                $country->setSubregion($dataCountry['subregion']);
                $country->setPopulation($dataCountry['population']);
                $country->setArea($dataCountry['area']);
                $country->setContinent($dataCountry['continents'][0]);
                $country->setFlag($dataCountry['flags']['png']);

                $this->entityManager->persist($country);
                $this->entityManager->flush();

                return new JsonResponse([
                    'message' => 'País guardado correctamente.',
                    'country' => $country->toArray(),
                ], 200);
            } else {
                    return new JsonResponse([
                        'exists' => 'true',
                        'message' => 'El país ya existe en la base de datos.'
                    ], 200);
                }
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'No se ha encontrado ningún país con ese nombre.',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }

    #[Route('/editCountry/{id}', name: 'app_country_edit', methods: ['PUT'])]
    public function edit(int $id,Request $request, CountryRepository $countryRepository, EntityManagerInterface $entityManager)
    {
        $country = $countryRepository->find($id);

        if (!$country) {
            return new JsonResponse(['exists' => 'true','message' => 'País no encontrado'], 404);
        }
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['data' => 'true','message' => 'Datos inválidos'], 400);
        }
        
        try{
            $country->setName($data['name']);
            $country->setCapital($data['capital']);
            $country->setRegion($data['region']);
            $country->setSubregion($data['subregion']);
            $country->setPopulation($data['population']);
            $country->setArea($data['area']);
            $country->setContinent($data['continent']);
            $country->setFlag($data['flag']);

            $entityManager->persist($country);
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'País editado correctamente.'
            ]);
        }catch(\Exception $e){
            return new JsonResponse(['message' => $e->getMessage()], 500);
        }
        
    }

    #[Route('/deleteCountry/{id}', name: 'app_country_delete', methods: ['DELETE'])]
    public function delete(int $id, CountryRepository $countryRepository, EntityManagerInterface $entityManager)
    {
        try{
            $country = $countryRepository->find($id);
            
            if (!$country) {
                return new JsonResponse(['exists' => 'true','message' => 'País no encontrado.'], 404);
            }

            $entityManager->remove($country);
            $entityManager->flush();

            return new JsonResponse(['message' => 'País eliminado correctamente.'], 200);
        }catch(\Exception $e){
            return new JsonResponse([
                'message' => 'Ocurrió un error al eliminar el país.',
                'error' => $e->getMessage(),
            ], 500);
        }
        
    }
}
