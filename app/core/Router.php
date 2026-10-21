<?php
// Routeur simple : /livres/edit/5  ->  LivreController::edit('5')
class Router
{
    /** Premier segment de l'URL => contrôleur */
    private array $routes = [
        ''          => 'HomeController',
        'auth'      => 'AuthController',
        'livres'    => 'LivreController',
        'adherents' => 'AdherentController',
    ];

    public function dispatch(string $url): void
    {
        $segments = array_values(array_filter(explode('/', trim($url, '/')), 'strlen'));

        $class  = $this->routes[$segments[0] ?? ''] ?? null;
        $method = $segments[1] ?? 'index';
        $params = array_slice($segments, 2);

        if ($class === null || !preg_match('/^[a-z][a-zA-Z]*$/', $method)) {
            $this->notFound();
            return;
        }

        $controller = new $class();

        // La méthode doit exister, être publique et recevoir le bon nombre de paramètres
        if (!is_callable([$controller, $method])) {
            $this->notFound();
            return;
        }
        $ref = new ReflectionMethod($controller, $method);
        if (count($params) < $ref->getNumberOfRequiredParameters()
            || count($params) > $ref->getNumberOfParameters()) {
            $this->notFound();
            return;
        }

        $controller->$method(...$params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        $pageTitle = 'Page introuvable';
        $message   = "La page demandée n'existe pas.";
        ob_start();
        require APP . '/views/errors/error.php';
        $content = ob_get_clean();
        require APP . '/views/layouts/main.php';
    }
}
