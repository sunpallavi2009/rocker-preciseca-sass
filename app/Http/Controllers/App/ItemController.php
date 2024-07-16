<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\DataTables\App\ItemDataTable;
use Illuminate\Support\Facades\Log; 

class ItemController extends Controller
{
    
    public function index(ItemDataTable $dataTable)
    {
        return $dataTable->render('app.item.index');
    }

    public function fetchAndStore()
    {
        try {
            $response = Http::get('http://localhost:8080/hsn');

            Log::info('API Request', [
                'url' => 'http://localhost:8080/hsn',
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
                    Item::create([
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
