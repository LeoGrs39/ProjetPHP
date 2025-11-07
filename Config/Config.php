<?php
namespace Config;

use Exception;

class Config {
    private static ?array $param = null;

    // Renvoie la valeur d'un paramètre de configuration
    public static function get(string $nom, $valeurParDefaut = null) {
        $params = self::getParameter();
        return $params[$nom] ?? $valeurParDefaut;
    }

    // Charge le tableau des paramètres au besoin
    private static function getParameter(): array {
        if (self::$param === null) {
            $cheminFichier = "Config/prod.ini";
            if (!file_exists($cheminFichier)) {
                $cheminFichier = "Config/dev.ini";
            }
            if (!file_exists($cheminFichier)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            } else {
                // false => on ne veut pas de sections imbriquées
                self::$param = parse_ini_file($cheminFichier, false, INI_SCANNER_TYPED);
            }
        }
        return self::$param;
    }
}