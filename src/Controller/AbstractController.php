<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use App\Request;
use App\View;

abstract class AbstractController
{
    protected static array $configuartion = [];
    protected const DEFAULT_ACTION = 'list';
    protected Request $request;
    protected View $view;

    public static function initConfig(array $configuartion): void
    {
        self::$configuartion = $configuartion;
    }

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        try {
            $action = $this->action() . 'Action';
            if (!method_exists($this, $action)) {
                $action = self::DEFAULT_ACTION . 'Action';
            }
            $this->$action();
        } catch (StorageException $e) {
            $this->view->render('error', ['message' => $e->getMessage()]);
        }
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}
