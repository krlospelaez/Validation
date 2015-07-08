<?php

/*
 * This file is part of Respect/Validation.
 *
 * (c) Alexandre Gomes Gaigalas <alexandre@gaigalas.net>
 *
 * For the full copyright and license information, please view the "LICENSE.md"
 * file that was distributed with this source code.
 */

namespace Respect\Validation\Exceptions;

class LengthException extends ValidationException
{
    const BOTH = 0;
    const LOWER = 1;
    const GREATER = 2;

    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::BOTH => '{{name}} debe tener una longitud entre {{minValue}} and {{maxValue}}',
            self::LOWER => '{{name}} debe tener una longitud mayor a {{minValue}}',
            self::GREATER => '{{name}} debe tener una longitud menor a {{maxValue}}',
        ),
        self::MODE_NEGATIVE => array(
            self::BOTH => '{{name}} no debe tener una longitud entre {{minValue}} and {{maxValue}}',
            self::LOWER => '{{name}} no debe tener una longitud mayor a {{minValue}}',
            self::GREATER => '{{name}} no debe tener una longitud mayor a {{maxValue}}',
        ),
    );

    public function configure($name, array $params = array())
    {
        $params['minValue'] = static::stringify($params['minValue']);
        $params['maxValue'] = static::stringify($params['maxValue']);

        return parent::configure($name, $params);
    }

    public function chooseTemplate()
    {
        if (!$this->getParam('minValue')) {
            return static::GREATER;
        } elseif (!$this->getParam('maxValue')) {
            return static::LOWER;
        } else {
            return static::BOTH;
        }
    }
}
