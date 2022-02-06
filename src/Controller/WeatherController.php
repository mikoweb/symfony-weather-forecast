<?php

namespace App\Controller;

use App\Form\AddressType;
use App\Map\Query\Exceptions\NotFoundCoordinatesException;
use App\Query\FindWeatherForecastQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Throwable;

class WeatherController extends AbstractController
{
    public function index(Request $request, FindWeatherForecastQuery $query, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(AddressType::class, null, [
            'method' => 'get',
            'action' => $this->generateUrl('app_weather_index'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $forecast = $query->find($form->get('country')->getData(), $form->get('city')->getData());

                return $this->render('weather/index.html.twig', [
                    'forecast' => $forecast,
                    'form' => $form->createView(),
                ]);
            } catch (NotFoundCoordinatesException $exception) {
                $this->addFlash('site_error', $translator->trans('weather.message.coordinates_not_found'));
            } catch (HttpExceptionInterface $exception) {
                $this->addFlash('site_error', $translator->trans('weather.message.http_exception'));
            } catch (Throwable) {
                $this->addFlash('site_error', $translator->trans('weather.message.general_error'));
            }
        }

        return $this->render('weather/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
