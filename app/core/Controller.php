<?php
// Contrôleur de base : rendu des vues, redirections, session, CSRF.
abstract class Controller
{
    /** Affiche une vue dans le layout principal. */
    protected function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require APP . '/views/' . $view . '.php';
        $content = ob_get_clean();
        require APP . '/views/layouts/main.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
    }

    /** Valeur POST nettoyée (chaîne uniquement). */
    protected function input(string $key): string
    {
        $value = $_POST[$key] ?? '';
        return is_string($value) ? trim($value) : '';
    }

    /** Protège une page : redirige vers la connexion si non connecté. */
    protected function requireAuth(): void
    {
        if (!is_logged_in()) {
            $this->flash('warning', 'Veuillez vous connecter pour accéder à cette page.');
            $this->redirect('auth/login');
        }
    }

    /** Exige une requête POST avec un jeton CSRF valide. */
    protected function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->fail(405, 'Méthode non autorisée', 'Cette action nécessite une requête POST.');
        }
        $token = $_POST['_csrf'] ?? '';
        if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
            $this->fail(419, 'Session expirée', 'Jeton de sécurité invalide. Rechargez la page et réessayez.');
        }
    }

    protected function notFound(): void
    {
        $this->fail(404, 'Page introuvable', "La ressource demandée n'existe pas.");
    }

    private function fail(int $code, string $title, string $message): void
    {
        http_response_code($code);
        $this->render('errors/error', ['pageTitle' => $title, 'message' => $message]);
        exit;
    }
}
