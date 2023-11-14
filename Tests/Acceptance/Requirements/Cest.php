<?php
declare(strict_types = 1);

namespace LMS\Routes\Tests\Acceptance\Requirements;

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

use LMS\Routes\Tests\Acceptance\Support\AcceptanceTester as Tester;

/**
 * @author Sergey Borulko <borulkosergey@icloud.com>
 */
class Cest
{
    public function ensure_content_type_is_correct_for_subsequent_request(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');

        foreach (range(0, 2) as $step) {
            $I->sendGET('https://routes.ddev.site/api/demo_tca_test');
            $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
            $I->seeResponseContainsJson(['success' => true]);
        }
    }

    public function custom_path_has_been_included(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo_tca_test');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function yaml_root_format_has_been_included(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/yaml');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    /**
     * Since v10 it's probably should be deleted.
     */
    public function custom_format_applied(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendPOST('https://routes.ddev.site/api/demo/custom/view');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
//        $I->seeResponseContainsJson(['ok' => true]);
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function https_protocol_requirement_applied(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/https/only');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function https_protocol_requirement_required(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('http://routes.ddev.site/api/demo/https/only');

        $I->dontSeeResponseContains('success');
    }

    public function host_requirement_required(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/custom/host');

        $I->dontSeeResponseContains('success');
        $I->seeResponseCodeIs(200);
    }

    public function proper_host_requirement_applied(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://m.routes.ddev.site/api/demo/custom/host');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['success' => true]);
    }

    public function params_default_values_applied(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/test/with_params');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['title' => 'default-title', 'description' => 'default-description']);
    }

    public function requirement_integer_only_applied(Tester $I)
    {
        $I->haveHttpHeader('Accept', 'application/json');
        $I->sendGET('https://routes.ddev.site/api/demo/photos/1');

        $I->seeHttpHeader('Content-Type', 'application/json; charset=utf-8');
        $I->seeResponseContainsJson(['uid' => 1, 'title' => 'Title 1']);
    }

    public function response_format_is_html_when_accept_header_missing(Tester $I)
    {
        $I->sendGET('https://routes.ddev.site/api/demo/photos');

        $I->seeHttpHeader('Content-Type', 'text/html; charset=utf-8');
    }
}
