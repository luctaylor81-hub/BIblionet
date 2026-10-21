<?php
class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', [
            'pageTitle'  => 'Accueil',
            'nbLivres'   => Livre::count(),
            'nbAdherents' => Adherent::count(),
        ]);
    }
}
