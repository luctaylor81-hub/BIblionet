<?php
class LivreController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $this->render('livres/index', ['pageTitle' => 'Livres', 'livres' => Livre::all()]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->form('Ajouter un livre', 'livres/store', ['nb_exemplaires' => 1], []);
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->requirePost();
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->form('Ajouter un livre', 'livres/store', $data, $errors);
            return;
        }
        Livre::create($data);
        $this->flash('success', 'Livre ajouté.');
        $this->redirect('livres');
    }

    public function edit(string $id): void
    {
        $this->requireAuth();
        $livre = Livre::find((int) $id);
        if (!$livre) {
            $this->notFound();
        }
        $this->form('Modifier un livre', 'livres/update/' . (int) $id, $livre, []);
    }

    public function update(string $id): void
    {
        $this->requireAuth();
        $this->requirePost();
        if (!Livre::find((int) $id)) {
            $this->notFound();
        }
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->form('Modifier un livre', 'livres/update/' . (int) $id, $data, $errors);
            return;
        }
        Livre::update((int) $id, $data);
        $this->flash('success', 'Livre modifié.');
        $this->redirect('livres');
    }

    public function delete(string $id): void
    {
        $this->requireAuth();
        $this->requirePost();
        if (!Livre::find((int) $id)) {
            $this->notFound();
        }
        try {
            Livre::delete((int) $id);
            $this->flash('success', 'Livre supprimé.');
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $this->flash('danger', 'Suppression impossible : ce livre a des emprunts enregistrés.');
            } else {
                throw $e;
            }
        }
        $this->redirect('livres');
    }

    private function form(string $title, string $action, array $livre, array $errors): void
    {
        $this->render('livres/form', [
            'pageTitle' => $title,
            'formTitle' => $title,
            'action'    => $action,
            'livre'     => $livre,
            'errors'    => $errors,
        ]);
    }

    /** @return array{0: array, 1: array} [données nettoyées, erreurs] */
    private function validate(): array
    {
        $d = [
            'titre'          => $this->input('titre'),
            'auteur'         => $this->input('auteur'),
            'categorie'      => $this->input('categorie'),
            'annee'          => $this->input('annee'),
            'nb_exemplaires' => $this->input('nb_exemplaires'),
        ];
        $errors = [];

        foreach (['titre' => 200, 'auteur' => 150, 'categorie' => 100] as $field => $max) {
            if ($d[$field] === '') {
                $errors[$field] = 'Ce champ est obligatoire.';
            } elseif (mb_strlen($d[$field]) > $max) {
                $errors[$field] = "Maximum $max caractères.";
            }
        }

        $maxYear = (int) date('Y') + 1;
        if (filter_var($d['annee'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1000, 'max_range' => $maxYear]]) === false) {
            $errors['annee'] = "Année invalide (entre 1000 et $maxYear).";
        }
        if (filter_var($d['nb_exemplaires'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 1000]]) === false) {
            $errors['nb_exemplaires'] = 'Nombre invalide (entre 1 et 1000).';
        }

        return [$d, $errors];
    }
}
