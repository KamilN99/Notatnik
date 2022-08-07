<?php

declare(strict_types=1);

namespace App;

class View
{
    public function render(string $page, array $params = []): void
    {
        $params = $this->escape($params);
        require_once("templates/layout.php");
    }
    
    //metoda zabezpieczająca przed wyświetlaniem niebezpiecznych danych np. skrypt js
    private function escape(array $params): array
    {
        $cleanParams = [];
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $cleanParams[$key] = $this->escape($value);
            } else if (is_string($value)) {
                $cleanParams[$key] = htmlentities($value);
            } else {
                $cleanParams[$key] = $value;
            }
        }
        return $cleanParams;
    }
}
