<?php

require_once '../../config.php';
require_once '../Models/RouteModel.php';

class RouteService {
    private $modelBMS;

    private $modelA;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        global $authenticationDB;
        $this->modelBMS = new RouteModel($bmsDB);
        $this->modelA = new RouteModel($authenticationDB);
    }

    public function getLanguage() {
        $response = $this->modelBMS->getLanguage($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function createRoute($formData) {
        $languages = $this->modelBMS->getLanguage($_SESSION['companyId']);
        if(!$languages) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while creating route',
                'error' => 'Error while get language data in language table in bms DB.'
            ];
        }
        $counter = 0;
        $routeId = 0;
        foreach($languages as $language) {
            //Insert data in bms_routes table & get id
            if($counter == 0) {
                if($language['language_code'] != 'en') {
                    return [
                        'status' => 'error',
                        'message' => 'Something went wrong while creating route',
                        'error' => 'Error firt value is not english. Insert data in bms_routes table & get id.'
                    ];
                }
                $response1 = $this->modelBMS->setRoute($_SESSION['companyId'], $formData['en']);
                if($response1['status'] == 'error') {
                    return [
                        'status' => 'error',
                        'message' => 'Something went wrong while creating route',
                        'error' => 'Error while insert data in route table in bms DB.'
                    ];
                }

                $routeId = $response1['routeId'];
            }

            $this->modelBMS->setRouteTranslation($_SESSION['companyId'], $routeId, $language['language_id'], $formData[$language['language_code']]);

            $counter++;
        }
        return [
            'status' => 'success',
            'message' => 'The bus route has been created successfully.'
        ];
    }


    public function updateRoute($formData) {
        $translations = $this->modelBMS->getRoute($_POST['route_id']);
        if(!$translations) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating route',
                'error' => 'Error while get translation data in rote_translation table in bms DB.'
            ];
        }
        $counter = 0;
        $routeId = 0;
        
        foreach($translations as $translation) {
            $name = 'route'.$translation['translationId'];
            //Insert data in bms_routes table & get id
            if($counter == 0) {
                if($translation['routeName'] != $formData[$name]) {
                    $this->modelBMS->updateRoute($translation['routeId'], $formData[$name]);
                }
            }

            $this->modelBMS->updateRouteTranslation($translation['translationId'], $formData[$name]);

            $counter++;
        }
        return [
            'status' => 'success',
            'message' => 'The bus route has been updated successfully.'
        ];
    }

    public function getRouteCardDetails() {
        $response = $this->modelBMS->getRouteCardDetails($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getRoutes()
    {
        $response = $this->modelBMS->getRoutes($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getRoute($routeId) {
        $response = $this->modelBMS->getRoute($routeId);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function deleteRoute($routeId) {
        $response = $this->modelBMS->deleteRoute($routeId);

        if ($response) {
            return [
                'status' => 'success',
                'message' => 'Route deleted successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the route',
                'error' => 'Error while delete route data in route table in bms DB.'
            ];
        }
    }

    public function getRouteField(){
        $response = $this->modelBMS->getRouteField($_SESSION['companyId'], 'en');

        if (!$response) {
            return [
                'status' => 'error',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

}