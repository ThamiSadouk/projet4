<?php

/**
 * Trait HydratorTrait Assigne les valeurs récupérées dans la BDD aux attributs des objets Comment et Post
 */
trait HydratorTrait
{
    /**
     * Pour chaque donnée on assigne une clé et une valeur
     * @param $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // déclare le setter correspondant à la clé de la donnée
            $method = 'set' . ucfirst($key);
            // si le setter correspondant à la clé existe, on appelle ce setter avec la valeur correspondante
            if(method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}