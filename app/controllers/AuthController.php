<?php
class AuthController extends Controller
{
    /** GET : affiche le formulaire ; POST : traite la connexion. */
    public function login(): void
    {
        if (is_logged_in()) {
            $this->redirect('livres');
        }

        $email = '';
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requirePost();
            $email    = $this->input('email');
            $password = $_POST['password'] ?? '';

            $user = $email !== '' ? User::findByEmail($email) : null;

            if ($user && is_string($password) && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id'    => (int) $user['id'],
                    'nom'   => $user['nom'],
                    'email' => $user['email'],
                ];
                $this->flash('success', 'Bienvenue, ' . $user['nom'] . '.');
                $this->redirect('livres');
            }
            $error = 'Email ou mot de passe incorrect.';
        }

        $this->render('auth/login', ['pageTitle' => 'Connexion', 'email' => $email, 'error' => $error]);
    }

    public function logout(): void
    {
        $this->requirePost();
        $_SESSION = [];
        session_destroy();
        session_start();
        $this->flash('success', 'Vous êtes déconnecté.');
        $this->redirect('');
    }
}
