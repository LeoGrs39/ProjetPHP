<?php

namespace Exceptions;

/**
 * Exception levée lorsqu'un attribut (Element, Origin, UnitClass)
 * ne peut pas être créé ou validé correctement.
 *
 * Permet de distinguer les erreurs métier d'attribut
 * des erreurs techniques générales.
 */
class AttributeCreationException extends \RuntimeException
{
}