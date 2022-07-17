<?php
/*
 * Produced: Wed Jun 22 2022
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2022 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Http\Controllers;

use App\Models\Fax;
use Illuminate\Http\Request;
use Twilio\TwiML\FaxResponse;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FaxController extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  /**
   * Handle initial fax receive
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // Create new Fax with data
    $fax = new Fax();
    $fax->from = $request->input("From");
    $fax->to = $request->input("To");
    $fax->sid = $request->input("Sid");
    $fax->media_url = $request->input("MediaUrl");
    $fax->save();

    // Generate TwilML response
    $response = new FaxResponse();
    $response->receive([
      "action" => route("fax.store", $fax->id),
      "method" => "POST",
      "storeMedia" => "true",
    ]);

    return $response;
  }

  /**
   * Store fax body
   *
   * @param \Illuminate\Http\Request $request
   * @param int $faxId
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, int $faxId)
  {
    if (($fax = Fax::where([["id", "=", $faxId], ["content", "=", null]])->first())) {
      $fax->content = base64_encode($request->getContent());
      $fax->save();
    }

    return new VoiceResponse();
  }
}
