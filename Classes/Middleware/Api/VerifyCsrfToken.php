<?php
declare(strict_types = 1);

namespace LMS\Routes\Middleware\Api;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\FormProtection\FormProtectionFactory;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class VerifyCsrfToken extends AbstractRouteMiddleware
{
    /**
     * {@inheritDoc}
     */
    public function process(): void
    {
        $csrf = $this->getRequestToken();
        $user = (string)$this->user->getUser();
        $action = $this->getActionBasedOnEnv();

        $protector = GeneralUtility::makeInstance(FormProtectionFactory::class)
            ->createForType('frontend');

        if ($protector->validateToken($csrf, 'routes', $action, $user)) {
            return;
        }

        $this->deny('CSRF token mismatch.', 401);
    }

    private function getRequestToken(): string
    {
        return $this->getRequest()->getHeaderLine('X-CSRF-TOKEN');
    }

    private function getActionBasedOnEnv(): string
    {
        $user = (string)$this->user->getUser();

        if (Environment::getContext()->isProduction()) {
            return $this->registry->get('tx_routes', $user);
        }

        return 'api';
    }
}
