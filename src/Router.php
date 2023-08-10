<?php
namespace APP;

class Router {

        /**
         * @var string
         */

          /**
         * @var AltoRouter
         */

         public function __construct(string $viewPath)
         {
             $this->viewPath = $viewPath; // Attribue le chemin du répertoire des vues passé en paramètre à la propriété viewPath de l'objet
             $this->router = new \AltoRouter(); // Crée une nouvelle instance de la classe AltoRouter et l'assigne à la propriété router de l'objet
         }

    public function run(): self
    {
        $match = $this->router->match(); // Tente de faire correspondre l'URL actuelle à une route définie

        if ($match) {
            $view = $match['target']; // Récupère la vue associée à la route correspondante
            $router = $this; // Stocke une référence à l'objet Router dans la variable locale $router
            require $this->viewPath . $view . '.php'; // Inclut la vue associée à la route correspondante

        } else {
            echo "Page non trouvée (404)"; // Affiche un message d'erreur si aucune route correspondante n'est trouvée
        }

        return $this; // Retourne l'objet Router
    }
}