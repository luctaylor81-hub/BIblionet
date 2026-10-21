<?php
class AdherentController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $this->render('adherents/index', ['pageTitle' => 'Adhérents', 'adherents' => Adherent::all()]);
    }

    public function create(): void
    {
        $this->requireAuth();
        $this->form('Ajouter un adhérent', 'adherents/store', [], []);
    }

    public function store(): void
    {
        $this->requireAuth();
        $this->requirePost();
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->form('Ajouter un adhérent', 'adherents/store', $data, $errors);
            return;
        }
        Adherent::create($data);
        $this->flash('success', 'Adhérent ajouté.');
        $this->redirect('adherents');
    }

    public function edit(string $id): void
    {
        $this->requireAuth();
        $adherent = Adherent::find((int) $id);
        if (!$adherent) {
            $this->notFound();
        }
        $this->form('Modifier un adhérent', 'adherents/update/' . (int) $id, $adherent, []);
    }

    public function update(string $id): void
    {
        $this->requireAuth();
        $this->requirePost();
        if (!Adherent::find((int) $id)) {
            $this->notFound();
        }
        [$data, $errors] = $this->validate();

        if ($errors) {
            $this->form('Modifier un adhérent', 'adherents/update/' . (int) $id, $data, $errors);
            return;
        }
        Adherent::update((int) $id, $data);
        $this->flash('success', 'Adhérent modifié.');
        $this->redirect('adherents');
    }

    public function delete(string $id): void
    {
        $this->requireAuth();
        $this->requirePost();
        if (!Adherent::find((int) $id)) {
            $this->notFound();
        }
        try {
            Adherent::delete((int) $id);
            $this->flash('success', 'Adhérent supprimé.');
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $this->flash('danger', 'Suppression impossible : cet adhérent a des emprunts enregistrés.');
            } else {
                throw $e;
            }
        }
        $this->redirect('adherents');
    }

    private function form(string $title, string $action, array $adherent, array $errors): void
    {
        $this->render('adherents/form', [
            'pageTitle' => $title,
            'formTitle' => $title,
            'action'    => $action,
            'adherent'  => $adherent,
            'errors'    => $errors,
        ]);
    }

    /** @return array{0: array, 1: array} [données nettoyées, erreurs] */
    private function validate(): array
    {
        $d = [
            'nom'       => $this->input('nom'),
            'prenom'    => $this->input('prenom'),
            'classe'    => $this->input('classe'),
            'telephone' => $this->input('telephone'),
        ];
        $errors = [];

        foreach (['nom' => 100, 'prenom' => 100, 'classe' => 50] as $field => $max) {
            if ($d[$field] === '') {
                $errors[$field] = 'Ce champ est obligatoire.';
            } elseif (mb_strlen($d[$field]) > $max) {
                $errors[$field] = "Maximum $max caractères.";
            }
        }
        if ($d['telephone'] !== '' && !preg_match('/^[0-9+\s().-]{6,20}$/', $d['telephone'])) {
            $errors['telephone'] = 'Numéro invalide (chiffres, espaces, + ( ) . - ; 6 à 20 caractères).';
        }

        return [$d, $errors];
    }
}
