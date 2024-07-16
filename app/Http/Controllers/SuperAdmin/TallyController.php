<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyGroup;
use Illuminate\Support\Facades\Auth;
use App\DataTables\App\CompanyDataTable;
use Illuminate\Support\Facades\Log; 

class TallyController extends Controller
{

    public function tallyGroupJsonImport(Request $request)
{
    try {
        $jsonData = $request->getContent();
        $fileName = 'tally_groups_data_' . date('YmdHis') . '.json';

        $jsonFilePath = storage_path('app/' . $fileName);
        file_put_contents($jsonFilePath, $jsonData);

        $jsonData = file_get_contents($jsonFilePath);
        $data = json_decode($jsonData, true);

        if (!isset($data['TALLYMESSAGE'])) {
            throw new \Exception('Invalid JSON structure.');
        }

        foreach ($data['TALLYMESSAGE'] as $entry) {
            if (isset($entry['GROUP'])) {
                $groupData = $entry['GROUP'];

                // Handle the name field correctly
                $nameField = $groupData['LANGUAGENAME.LIST']['NAME.LIST']['NAME'] ?? null;

                if (is_array($nameField)) {
                    $nameField = implode(', ', $nameField);
                }

                $tallyGroup = TallyGroup::create([
                    'guid' => $groupData['GUID'] ?? null,
                    'parent' => $groupData['PARENT'] ?? null,
                    'grp_debit_parent' => $groupData['GRPDEBITPARENT'] ?? null,
                    'grp_credit_parent' => $groupData['GRPCREDITPARENT'] ?? null,
                    'affects_stock' => $groupData['AFFECTSSTOCK'] ?? null,
                    'alter_id' => $groupData['ALTERID'] ?? null,
                    'name' => $nameField,
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


    public function index(CompanyDataTable $dataTable)
    {
        return $dataTable->render('app.company.index');
    }

    public function fetchAndStore()
    {
        try {
            $response = Http::get('http://localhost:8080/company');

            Log::info('API Request', [
                'url' => 'http://localhost:8080/company',
                'response' => $response->body(),
                'status' => $response->status(),
            ]);

            if ($response->successful()) {
                $data = str_getcsv(trim($response->body()), ',', '"');
                $data = array_filter($data, function ($value) {
                    return !empty(trim($value));
                });

                Log::info('Fetched Data', ['data' => $data]);

                if (!empty($data)) {
                    TallyCompany::create([
                        'data' => json_encode($data)
                    ]);

                    return redirect()->back()->with('success', __('Data fetched and stored successfully.'));
                } else {
                    return redirect()->back()->with('error', __('No data fetched.'));
                }
            } else {
                return redirect()->back()->with('error', __('Failed to fetch data: ') . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error fetching and storing data', ['exception' => $e]);

            return redirect()->back()->with('error', __('An error occurred: ') . $e->getMessage());
        }
    }
    
}
