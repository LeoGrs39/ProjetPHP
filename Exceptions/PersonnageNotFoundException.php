<?php

namespace Exceptions;

/**
 * Exception lancée lorsqu'un personnage demandé n'existe pas en base de données.
 *
 * Utilisée principalement dans les opérations de lecture ou de mise à jour
 * lorsqu'un identifiant n'est pas trouvé ou lorsqu'une récupération échoue.
 */
class PersonnageNotFoundException extends \RuntimeException
{
}