<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyCompany;
use App\Models\TallyGroup;
use App\Models\TallyLedger;
use App\Models\TallyStockItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class LedgerController extends Controller
{

    public function masterJsonImport(Request $request)
    {
        try {
            $jsonData = $request->getContent();
            $fileName = 'tally_groups_data_' . date('YmdHis') . '.json';

            $jsonFilePath = storage_path('app/' . $fileName);
            file_put_contents($jsonFilePath, $jsonData);

            $jsonData = file_get_contents($jsonFilePath);
            $data = json_decode($jsonData, true);

            if (!isset($data['ENVELOPE']['BODY']['IMPORTDATA']['REQUESTDATA']['TALLYMESSAGE'])) {
                throw new \Exception('Invalid JSON structure.');
            }

            $messages = $data['ENVELOPE']['BODY']['IMPORTDATA']['REQUESTDATA']['TALLYMESSAGE'];

            // Track company GUIDs to ensure they are inserted only once
            $companyGuids = [];

            foreach ($messages as $message) {
                if (isset($message['COMPANY'])) {
                    $companyData = $message['COMPANY']['REMOTECMPINFO.LIST'];

                    // Check if company GUID already exists
                    $companyGuid = $companyData['NAME'];
                    if (!in_array($companyGuid, $companyGuids)) {
                        $company = TallyCompany::create([
                            'guid' => $companyGuid,
                            'name' => $companyData['REMOTECMPNAME'] ?? null,
                            'state' => $companyData['REMOTECMPSTATE'] ?? null,
                        ]);

                        if (!$company) {
                            throw new \Exception('Failed to create tally company record.');
                        }

                        $companyGuids[] = $companyGuid;
                    }
                }
            }

            foreach ($messages as $message) {
                if (isset($message['GROUP'])) {
                    $groupData = $message['GROUP'];

                    // Extract necessary fields from the GROUP data
                    // $guid = $groupData['GUID'] ?? null;
                    // $companyGuid = substr($guid, 0, 36); // Extract company GUID from group GUID

                    // Check if company GUID exists in tally_companies table
                    if (!in_array($companyGuid, $companyGuids)) {
                        throw new \Exception('Company GUID not found in tally_companies table.');
                    }

                    $tallyGroup = TallyGroup::create([
                        'guid' => $groupData['GUID'] ?? null,
                        'company_guid' => $companyGuid,
                        'parent' => $groupData['PARENT'] ?? null,
                        'affects_stock' => $groupData['AFFECTSSTOCK'] ?? null,
                        'alter_id' => $groupData['ALTERID'] ?? null,
                        'name' => $groupData['LANGUAGENAME.LIST']['NAME.LIST']['NAME'] ?? null,
                    ]);

                    if (!$tallyGroup) {
                        throw new \Exception('Failed to create tally group record.');
                    }
                }
            }

            return response()->json(['message' => 'Tally groups data saved successfully.']);

        } catch (\Exception $e) {
            Log::error('Error importing data: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
