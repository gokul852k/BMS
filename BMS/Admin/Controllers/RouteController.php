<?php

require_once '../Services/RouteService.php';

class RouteController {
    private $routeService;
    public function __construct() {
        $this->routeService = new RouteService();

        // Check if the request is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die('Invalid request');
        }

        // Get the action from the AJAX request
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Call the appropriate method based on the action
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit"]);
        }
    }

    private function getLanguage() {
        echo json_encode($this->routeService->getLanguage());
    }

    private function createRoute() {
        echo json_encode($this->routeService->createRoute($_POST));
    }

    private function getRouteCardDetails() {
        echo json_encode($this->routeService->getRouteCardDetails());
    }

    private function getRoutes() {
        echo json_encode($this->routeService->getRoutes());
    }

    private function getRoute() {
        echo json_encode($this->routeService->getRoute($_POST['routeId']));
    }

    private function updateRoute() {
        echo json_encode($this->routeService->updateRoute($_POST));
    }

    private function deleteRoute() {
        echo json_encode($this->routeService->deleteRoute($_POST['routeId']));
    }

    private function getRouteField() {
        echo json_encode($this->routeService->getRouteField());
    }
}

new RouteController();