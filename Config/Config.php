<?php
namespace Config;

use Exception;

/**
 * Class Config
 * * Classe utilitaire statique pour la gestion de la configuration de l'application.
 * * Elle charge les paramètres depuis un fichier INI (`prod.ini` ou `dev.ini`)
 * * et les stocke en mémoire pour éviter des lectures disques répétées.
 */
class Config {
    /** * @var array|null Stockage statique des paramètres une fois chargés (Singleton).
     */
    private static ?array $param = null;

    /**
     * Récupère la valeur d'un paramètre de configuration.
     *
     * @param string $nom Le nom de la clé (ex: 'dsn', 'user') définie dans le fichier INI.
     * @param mixed $valeurParDefaut Valeur à retourner si la clé n'existe pas (null par défaut).
     * @return mixed La valeur du paramètre ou la valeur par défaut.
     */
    public static function get(string $nom, $valeurParDefaut = null) {
        $params = self::getParameter();
        return $params[$nom] ?? $valeurParDefaut;
    }

    /**
     * Charge et retourne le tableau complet des paramètres.
     * * Vérifie l'existence de 'prod.ini' en priorité, sinon 'dev.ini'.
     * * Si les paramètres sont déjà chargés en mémoire, ils sont retournés directement.
     *
     * @return array Le tableau associatif des paramètres.
     * @throws Exception Si aucun fichier de configuration (.ini) n'est trouvé.
     */
    private static function getParameter(): array {
        if (self::$param === null) {
            $cheminFichier = "Config/prod.ini";
            if (!file_exists($cheminFichier)) {
                $cheminFichier = "Config/dev.ini";
            }
            if (!file_exists($cheminFichier)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            } else {
                // INI_SCANNER_TYPED permet de convertir automatiquement les entiers et booléens
                self::$param = parse_ini_file($cheminFichier, false, INI_SCANNER_TYPED);
            }
        }
        return self::$param;
    }
}