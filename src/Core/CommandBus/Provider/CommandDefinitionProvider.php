<?php
/**
 * 2007-2019 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2019 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\PrestaShop\Core\CommandBus\Provider;

use ReflectionClass;
use ReflectionException;

/**
 * Provides all Commands & Queries with descriptions
 */
final class CommandDefinitionProvider
{
    /**
     * @param string $commandName
     *
     * @return CommandDefinition
     *
     * @throws ReflectionException
     */
    public function getDefinition($commandName)
    {
        return new CommandDefinition(
            $commandName,
            $this->getType($commandName),
            $this->getDescription($commandName)
        );
    }

    /**
     * Checks whether the command is of type Query or Command by provided name
     *
     * @param string $commandName
     *
     * @return string
     */
    private function getType($commandName)
    {
        if (strpos($commandName, '\Command\\')) {
            return 'Command';
        }

        return 'Query';
    }

    /**
     * @param string $commandName
     *
     * @return string|string[]|null
     *
     * @throws ReflectionException
     */
    private function getDescription($commandName)
    {
        return preg_replace('/[\*\/]/', '', (new ReflectionClass($commandName))->getDocComment());

    }
}
