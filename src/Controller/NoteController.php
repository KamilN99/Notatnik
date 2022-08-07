<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundExcetion;
use App\Controller\AbstractController;
use App\Exception\ConfigurationException;
use App\Model\NoteModel;
use App\Model\UserModel;
use App\Request;

class NoteController extends AbstractController
{
    private NoteModel $noteModel;
    private UserModel $userModel;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        if (empty(self::$configuartion['db'])) {
            throw new ConfigurationException('Configuration error');
        }
        $this->noteModel = new NoteModel(self::$configuartion['db']);
        $this->userModel = new UserModel(self::$configuartion['db']);
    }

    //dodawanie nowej notatki
    public function createAction(): void
    {
        if ($this->request->isPost()) {
            $this->noteModel->create([
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description'),
                'userId' => $_SESSION['id']
            ]);
            header('Location: /?before=created');
            exit;
        }
        $this->view->render('create');
    }
    
    //usuwanie notatki
    public function deleteAction(): void
    {
        if ($this->request->isPost()) {
            $id = (int)$this->request->postParam('id');
            $this->noteModel->delete($id);
            header('Location: /?before=deleted');
            exit;
        }
        $note = $this->getNote();
        $viewParams = [
            'note' => $note
        ];
        $this->view->render('delete', $viewParams);
    }
    //edytowanie notatki
    public function editAction(): void
    {
        if ($this->request->isPost()) {
            $id = (int)$this->request->postParam('id');
            $this->noteModel->edit($id, [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ]);
            header('Location: /?before=edited');
            exit;
        }
        $note = $this->getNote();
        $viewParams = [
            'note' => $note
        ];
        $this->view->render('edit', $viewParams);
    }
    //wyswietlanie listy notatek
    public function listAction(): void
    {
        define('PAGE_SIZE', 5);
        if (isset($_SESSION['id'])) {
            $userID = $_SESSION['id'];
            $pageNumber = (int)$this->request->getParam('pagenumber', 1);
            $phrase = $this->request->getParam('phrase');
            $sortBy = $this->request->getParam('sortby', 'title');
            $sortOrder = $this->request->getParam('sortorder', 'desc');

            if ($phrase) {
                $notes = $this->noteModel->search($phrase, $pageNumber, PAGE_SIZE, $sortBy, $sortOrder, $userID);
                $noteCount = $this->noteModel->searchCount($userID, $phrase);
            } else {
                $notes = $this->noteModel->list($pageNumber, PAGE_SIZE, $sortBy, $sortOrder, $userID);
                $noteCount = $this->noteModel->count($userID);
            }
            $pages = (int)ceil($noteCount / PAGE_SIZE);


            $viewParams = [
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
                'notes' => $notes,
                'phrase' => $phrase,
                'page' => [
                    'pagenumber' => $pageNumber,
                    'pages' => $pages
                ],
                'sort' => [
                    'by' => $sortBy,
                    'order' => $sortOrder
                ]
            ];
            $this->view->render('list', $viewParams);
        } else {
            $this->view->render('login');
        }
    }
    
    //wyświetlanie notatki
    public function showAction(): void
    {
        $note = $this->getNote();
        $viewParams = [
            'note' => $note
        ];
        $this->view->render('show', $viewParams);
    }
    //pobieranie notatki
    private function getNote(): array
    {
        $id = (int)$this->request->getParam('id');
        if (!$id) {
            header('Location: /?error=noteIdNotFound');
            exit;
        }

        try {
            $note = $this->noteModel->get($id);
        } catch (NotFoundExcetion $e) {
            header('Location: /?error=noteNotFound');
            exit;
        }
        return $note;
    }

    //rejestracja
    public function registerAction(): void
    {
        if ($this->request->isPost()) {
            $login = $this->request->postParam('login');
            $password = sha1($this->request->postParam('password'));

            $id = $this->userModel->get($login, $password);
            if (is_null($id)) {
                $this->userModel->create([
                    'login' => $login,
                    'password' => $password
                ]);
                header('Location: /?before=registred');
                exit;
            } else {
                $this->view->render('register', ['message' => 'exist']);
            }
        }
        $this->view->render('register');
    }

    //logowanie
    public function loginAction(): void
    {
        if ($this->request->isPost()) {
            $login = $this->request->postParam('login');
            $password = sha1($this->request->postParam('password'));

            $id = $this->userModel->get($login, $password);
            if (!is_null($id)) {
                $_SESSION['id'] = $id;
                var_dump($_SESSION['id']);
                header('Location: /?before=logged');
                exit;
            } else {
                $this->view->render('login', ['message' => 'exist']);
            }
        }
        $this->view->render('login');
    }

    //wylogowanie
    public function logoutAction(): void
    {
        unset($_SESSION['id']);
        $this->view->render('login');
    }
}
