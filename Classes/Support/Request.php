<?php
declare(strict_types = 1);

namespace LMS\Routes\Support;

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

use Psr\Http\Message\ServerRequestInterface as ExtbaseRequest;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Request
{
    private ExtbaseRequest $request;

    public function setOriginalRequest(ExtbaseRequest $request)
    {
        $this->request = new \TYPO3\CMS\Extbase\Mvc\Request($request);
    }

    private function initialize(string $controllerFQCN): ExtbaseRequest
    {
        $request = $this->request;

        return $request->withControllerObjectName($controllerFQCN);
    }

    public function getControllerNameBasedOn(string $controllerFQCN): string
    {
        return $this->initialize($controllerFQCN)->getControllerName();
    }

    public function getExtensionNameBasedOn(string $controllerFQCN): string
    {
        return $this->initialize($controllerFQCN)->getControllerExtensionName();
    }

    public function getVendorNameBasedOn(string $controllerFQCN): string
    {
        return explode('\\', $controllerFQCN)[0];
    }
}
