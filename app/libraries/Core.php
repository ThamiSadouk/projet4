<?php

/*
 * App Core Class
 * créé URL et exécute le core controllers
 * URL FORMAT - /controllers/method/params
 */
class Core
{
    protected $currentController = 'PagesController'; // ce controllers sera exécuté par défaut
    protected $currentMethod = 'index';
    protected $params =[];
    protected $url;

    public function __construct()
    {
        $this->url = $this->getUrl();
        $this->getController();
        $this->getMethod();
        $this->getParams();

        // appelle les fonctions callback dans le dossier controllers avec les paramètres rassemblés dans un tableau
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    //permet d'obtenir la valeur du paramètre url (le paramètre url est set dans .htaccess)
    public function getUrl()
    {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/'); // supprime le slash après la chaîne str
            $url = filter_var($url, FILTER_SANITIZE_URL); // filtre les caractères insérés dans la variable
            $url = explode('/', $url); // coupe la chaine et retourne un tableau de chaînes
            return $url;
        }
    }

    public function getController()
    {
        // Vérifie dans le dossier controllers si la 1ere valeur de $url correspond à un controllers
        if(file_exists('../app/controllers/' . ucwords($this->url[0]). '.php')) {
            // si Existe, on l'attribue en tant que currentController
            $this->currentController = ucwords($this->url[0]);
            // On détruit la 1ere valeur enregistrée dans le tableau
            unset($this->url[0]);
        }

        // Charge le controllers
        require_once '../app/controllers/' . $this->currentController . '.php';
        // Instantiation du controllers appelé
        $this->currentController = new $this->currentController;
    }

    public function getMethod()
    {
        // Vérifie la 2e valeure de $url
        if(isset($this->url[1])) {
            // Vérifie si la méthode existe dans le currentController
            if(method_exists($this->currentController, $this->url[1])) {
                $this->currentMethod = $this->url[1];
                // On détruit la 2e valeur enregistrée dans le tableau
                unset($this->url[1]);
            }
        }
    }

    public function getParams()
    {
        $this->params = $this->url ? array_values($this->url) : []; // si il y a des valeurs dans $url, elles seront ajoutés sinon le tableau reste vide
    }
}