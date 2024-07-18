<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\TallyGroup;
use App\Models\TallyLedger;
use App\Models\TallyOtherLedger;
use App\Models\TallyStockItem;
use Illuminate\Support\Facades\Auth;
use App\DataTables\TallyGroupDataTable;
use App\DataTables\TallyLedgerDataTable;
use App\DataTables\TallyOtherLedgerDataTable;
use App\DataTables\TallyStockItemDataTable;
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

    public function index(TallyGroupDataTable $dataTable)
    {
        return $dataTable->render('superadmin.tallydata.index');
    }


    public function tallyLedgerJsonImport(Request $request)
    {
        try {
            Log::info('Starting JSON import process.');

            // Receive JSON data from the request
            $jsonData = $request->getContent();
            Log::info('Received JSON data.');

            // Decode JSON data into an associative array
            $data = json_decode($jsonData, true);

            // Check if TALLYMESSAGE exists in the data
            if (!isset($data['TALLYMESSAGE'])) {
                throw new \Exception('Invalid JSON structure.');
            }

            // Extract TALLYMESSAGE
            $tallyMessage = $data['TALLYMESSAGE'];

            // Check if LEDGER exists in TALLYMESSAGE
            if (!isset($tallyMessage['LEDGER'])) {
                throw new \Exception('Ledger data not found.');
            }

            // Extract LEDGER data
            $ledgerData = $tallyMessage['LEDGER'];

            // Extract specific fields
            // $guid = $ledgerData['GUID'] ?? null;
            // $currencyName = $ledgerData['CURRENCYNAME'] ?? null;
            // $priorStateName = $ledgerData['PRIORSTATENAME'] ?? null;
            // $incomeTaxNumber = $ledgerData['INCOMETAXNUMBER'] ?? null;
            // $parent = $ledgerData['PARENT'] ?? null;
            // $tcsApplicable = $ledgerData['TCSAPPLICABLE'] ?? null;
            // $taxClassificationName = html_entity_decode($ledgerData['TAXCLASSIFICATIONNAME'] ?? null);
            // $taxType = $ledgerData['TAXTYPE'] ?? null;
            // $countryOfResidence = $ledgerData['COUNTRYOFRESIDENCE'] ?? null;
            // $ledgerCountryIsdCode = $ledgerData['LEDGERCOUNTRYISDCODE'] ?? null;
            // $gstType = html_entity_decode($ledgerData['GSTTYPE'] ?? null);
            // $appropriateFor = html_entity_decode($ledgerData['APPROPRIATEFOR'] ?? null);
            // $gstNatureOfSupply = html_entity_decode($ledgerData['GSTNATUREOFSUPPLY'] ?? null);
            // $serviceCategory = html_entity_decode($ledgerData['SERVICECATEGORY'] ?? null);
            // $partyBusinessStyle = $ledgerData['PARTYBUSINESSSTYLE'] ?? null;
            // $isBillWiseOn = $ledgerData['ISBILLWISEON'] ?? null;
            // $isCostCentresOn = $ledgerData['ISCOSTCENTRESON'] ?? null;
            // $alterId = $ledgerData['ALTERID'] ?? null;
            // $openingBalance = $ledgerData['OPENINGBALANCE'] ?? null;

            // Handle GSTDETAILS
            $gstDetails = $ledgerData['GSTDETAILS.LIST'] ?? null;
            $applicableFrom = isset($gstDetails['APPLICABLEFROM']) ? Carbon::createFromFormat('Ymd', $gstDetails['APPLICABLEFROM'])->format('Y-m-d') : null;
            // Add more handling as per your requirements for GSTDETAILS

            // Handle LANGUAGE and NAME.LIST
            // $languageName = $ledgerData['LANGUAGENAME.LIST']['NAME.LIST']['NAME'] ?? null;
            // $languageId = $ledgerData['LANGUAGENAME.LIST']['LANGUAGEID'] ?? null;

            // Handle LEDMAILINGDETAILS
            $mailingName = $ledgerData['LEDMAILINGDETAILS.LIST']['MAILINGNAME'] ?? null;
            $addressList = $ledgerData['LEDMAILINGDETAILS.LIST']['ADDRESS.LIST']['ADDRESS'] ?? null;
            $address = is_array($addressList) ? implode(', ', $addressList) : null;
            $pincode = $ledgerData['LEDMAILINGDETAILS.LIST']['PINCODE'] ?? null;
            $state = $ledgerData['LEDMAILINGDETAILS.LIST']['STATE'] ?? null;
            $country = $ledgerData['LEDMAILINGDETAILS.LIST']['COUNTRY'] ?? null;


            // Handle GSTDETAILS.LIST
            $gstDetailsList = $ledgerData['GSTDETAILS.LIST'] ?? null;
            $applicableFrom = isset($gstDetailsList['APPLICABLEFROM']) ? Carbon::createFromFormat('Ymd', $gstDetailsList['APPLICABLEFROM'])->format('Y-m-d') : null;
            $srcOfGstDetails = $gstDetailsList['SRCOFGSTDETAILS'] ?? null;
            $gstCalcSlabOnMrp = $gstDetailsList['GSTCALCSLABONMRP'] ?? null;
            $isReverseChargeApplicable = $gstDetailsList['ISREVERSECHARGEAPPLICABLE'] ?? null;
            $isNonGstGoods = $gstDetailsList['ISNONGSTGOODS'] ?? null;
            $gstIneligibleItc = $gstDetailsList['GSTINELIGIBLEITC'] ?? null;
            $includeExpForSlabCalc = $gstDetailsList['INCLUDEEXPFORSLABCALC'] ?? null;

            $stateWiseDetailsList = $gstDetailsList['STATEWISEDETAILS.LIST'] ?? null;
            $rateDetailsList = $stateWiseDetailsList['RATEDETAILS.LIST'] ?? [];
            $gstRateDetails = [];
            foreach ($rateDetailsList as $rateDetail) {
                $gstRateDetails[] = [
                    'gst_rate_duty_head' => $rateDetail['GSTRATEDUTYHEAD'] ?? null,
                    'gst_rate_evaluation_type' => $rateDetail['GSTRATEVALUATIONTYPE'] ?? null,
                ];
            }

            // Create TallyLedger record
            $tallyLedger = TallyLedger::create([
                'guid' => $ledgerData['GUID'] ?? null,
                'currency_name' => $ledgerData['CURRENCYNAME'] ?? null,
                'prior_state_name' => $ledgerData['PRIORSTATENAME'] ?? null,
                'income_tax_number' => $ledgerData['INCOMETAXNUMBER'] ?? null,
                'parent' => $ledgerData['PARENT'] ?? null,
                'tcs_applicable' => $ledgerData['TCSAPPLICABLE'] ?? null,
                'tax_classification_name' => html_entity_decode($ledgerData['TAXCLASSIFICATIONNAME'] ?? null),
                'tax_type' => $ledgerData['TAXTYPE'] ?? null,
                'country_of_residence' => $ledgerData['COUNTRYOFRESIDENCE'] ?? null,
                'ledger_country_isd_code' => $ledgerData['LEDGERCOUNTRYISDCODE'] ?? null,
                'gst_type' => html_entity_decode($ledgerData['GSTTYPE'] ?? null),
                'appropriate_for' => html_entity_decode($ledgerData['APPROPRIATEFOR'] ?? null),
                'gst_nature_of_supply' => html_entity_decode($ledgerData['GSTNATUREOFSUPPLY'] ?? null),
                'service_category' => html_entity_decode($ledgerData['SERVICECATEGORY'] ?? null),
                'party_business_style' => $ledgerData['PARTYBUSINESSSTYLE'] ?? null,
                'is_bill_wise_on' => $ledgerData['ISBILLWISEON'] ?? null,
                'is_cost_centres_on' => $ledgerData['ISCOSTCENTRESON'] ?? null,
                'alter_id' => $ledgerData['ALTERID'] ?? null,
                'opening_balance' => $ledgerData['OPENINGBALANCE'] ?? null,
                'language_name' => $ledgerData['LANGUAGENAME.LIST']['NAME.LIST']['NAME'] ?? null,
                'language_id' => $ledgerData['LANGUAGENAME.LIST']['LANGUAGEID'] ?? null,
                'applicable_from' => $applicableFrom,
                'mailing_name' => $mailingName,
                'address' => $address,
                'pincode' => $pincode,
                'state' => $state,
                'country' => $country,
                'gst_applicable_from' => $applicableFrom,
                'src_of_gst_details' => $srcOfGstDetails,
                'gst_calc_slab_on_mrp' => $gstCalcSlabOnMrp,
                'is_reverse_charge_applicable' => $isReverseChargeApplicable,
                'is_non_gst_goods' => $isNonGstGoods,
                'gst_ineligible_itc' => $gstIneligibleItc,
                'include_exp_for_slab_calc' => $includeExpForSlabCalc,
                'gst_rate_details' => json_encode($gstRateDetails), // Ensure $gstRateDetails is correctly populated
            ]);

            if (!$tallyLedger) {
                throw new \Exception('Failed to create tally ledger record.');
            }

            Log::info('GST Rate Details:', $gstRateDetails);
            Log::info('Created ledger record: ' . $tallyLedger->id);
            Log::info('Tally ledgers data saved successfully.');

            return response()->json(['message' => 'Tally ledgers data saved successfully.']);

        } catch (\Exception $e) {
            Log::error('Error importing data: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    public function ledgerShow(TallyLedgerDataTable $dataTable)
    {
        return $dataTable->render('superadmin.tallydata.ledger');
    }


    public function tallyOtherLedgerJsonImport(Request $request)
    {
        try {
            $jsonData = $request->getContent();
            $fileName = 'tally_other_ledgers_data_' . date('YmdHis') . '.json';

            $jsonFilePath = storage_path('app/' . $fileName);
            file_put_contents($jsonFilePath, $jsonData);

            $jsonData = file_get_contents($jsonFilePath);
            $data = json_decode($jsonData, true);

            if (!isset($data['TALLYMESSAGE'])) {
                throw new \Exception('Invalid JSON structure.');
            }

            foreach ($data['TALLYMESSAGE'] as $entry) {
                if (isset($entry['LEDGER'])) {
                    $ledgerData = $entry['LEDGER'];

                    // Handle the name field correctly
                    $nameField = $ledgerData['LANGUAGENAME.LIST']['NAME.LIST']['NAME'] ?? null;
                    if (is_array($nameField)) {
                        $nameField = implode(', ', $nameField);
                    }

                    // Convert APPLICABLEFROM to date
                    $applicableFrom = null;
                    if (isset($ledgerData['LEDGSTREGDETAILS.LIST'][0]['APPLICABLEFROM'])) {
                        $applicableFrom = Carbon::createFromFormat('Ymd', $ledgerData['LEDGSTREGDETAILS.LIST'][0]['APPLICABLEFROM'])->format('Y-m-d');
                    }

                    // Handle address field correctly
                    $address = null;
                    if (isset($ledgerData['LEDMAILINGDETAILS.LIST'][0]['ADDRESS.LIST']['ADDRESS'])) {
                        $address = implode(', ', $ledgerData['LEDMAILINGDETAILS.LIST'][0]['ADDRESS.LIST']['ADDRESS']);
                    }

                    $mailingapplicableFrom = null;
                    if (isset($ledgerData['LEDMAILINGDETAILS.LIST'][0]['APPLICABLEFROM'])) {
                        $mailingapplicableFrom = Carbon::createFromFormat('Ymd', $ledgerData['LEDMAILINGDETAILS.LIST'][0]['APPLICABLEFROM'])->format('Y-m-d');
                    }

                    // Creating Tally Other Ledger entry
                    $tallyOtherLedger = TallyOtherLedger::create([
                        'guid' => $ledgerData['GUID'] ?? null,
                        'currency_name' => $ledgerData['CURRENCYNAME'] ?? null,
                        'prior_state_name' => $ledgerData['PRIORSTATENAME'] ?? null,
                        'income_tax_number' => $ledgerData['INCOMETAXNUMBER'] ?? null,
                        'gst_registration_type' => $ledgerData['GSTREGISTRATIONTYPE'] ?? null,
                        'parent' => $ledgerData['PARENT'] ?? null,
                        'tax_classification_name' => html_entity_decode($ledgerData['TAXCLASSIFICATIONNAME'] ?? null),
                        'tax_type' => $ledgerData['TAXTYPE'] ?? null,
                        'gst_type' => html_entity_decode($ledgerData['GSTTYPE'] ?? null),
                        'appropriate_for' => html_entity_decode($ledgerData['APPROPRIATEFOR'] ?? null),
                        'service_category' => html_entity_decode($ledgerData['SERVICECATEGORY'] ?? null),
                        'excise_ledger_classification' => html_entity_decode($ledgerData['EXCISELEDGERCLASSIFICATION'] ?? null),
                        'excise_duty_type' => html_entity_decode($ledgerData['EXCISEDUTYTYPE'] ?? null),
                        'excise_nature_of_purchase' => html_entity_decode($ledgerData['EXCISENATUREOFPURCHASE'] ?? null),
                        'ledger_fbt_category' => html_entity_decode($ledgerData['LEDGERFBTCATEGORY'] ?? null),
                        'is_bill_wise_on' => $ledgerData['ISBILLWISEON'] ?? null,
                        'is_cost_centres_on' => $ledgerData['ISCOSTCENTRESON'] ?? null,
                        'alter_id' => $ledgerData['ALTERID'] ?? null,
                        'name' => $nameField,
                        'applicable_from' => $applicableFrom,
                        'gstn_no' => $ledgerData['PARTYGSTIN'] ?? null,
                        'address' => $address,
                        'mailing_applicable_from' => $mailingapplicableFrom,
                        'pincode' => $ledgerData['LEDMAILINGDETAILS.LIST'][0]['PINCODE'] ?? null,
                        'mailing_name' => html_entity_decode($ledgerData['LEDMAILINGDETAILS.LIST'][0]['MAILINGNAME'] ?? null),
                        'state' => html_entity_decode($ledgerData['LEDMAILINGDETAILS.LIST'][0]['STATE'] ?? null),
                        'country' => html_entity_decode($ledgerData['LEDMAILINGDETAILS.LIST'][0]['COUNTRY'] ?? null),
                    ]);

                    if (!$tallyOtherLedger) {
                        throw new \Exception('Failed to create tally other ledger record.');
                    }
                }
            }

            return response()->json(['message' => 'Tally other ledgers data saved successfully.']);

        } catch (\Exception $e) {
            Log::error('Error importing data: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function otherLedgerShow(TallyOtherLedgerDataTable $dataTable)
    {
        return $dataTable->render('superadmin.tallydata.otherLedger');
    }

    public function tallyStockItemJsonImport(Request $request)
    {
        try {
            $jsonData = $request->getContent();
            $fileName = 'tally_stock_items_data_' . date('YmdHis') . '.json';

            $jsonFilePath = storage_path('app/' . $fileName);
            file_put_contents($jsonFilePath, $jsonData);

            $jsonData = file_get_contents($jsonFilePath);
            $data = json_decode($jsonData, true);

            if (!isset($data['TALLYMESSAGE']['STOCKITEM'])) {
                throw new \Exception('Invalid JSON structure.');
            }

            $stockItemData = $data['TALLYMESSAGE']['STOCKITEM'];

            // Handle the name field correctly
            $nameField = $stockItemData['LANGUAGENAME.LIST']['NAME.LIST']['NAME'] ?? null;
            if (is_array($nameField)) {
                $nameField = implode(', ', $nameField);
            }

            $tallyStockItem = TallyStockItem::create([
                'guid' => $stockItemData['GUID'] ?? null,
                'parent' => $stockItemData['PARENT'] ?? null,
                'category' => html_entity_decode($stockItemData['CATEGORY'] ?? null),
                'gst_applicable' => html_entity_decode($stockItemData['GSTAPPLICABLE'] ?? null),
                'tax_classification_name' => html_entity_decode($stockItemData['TAXCLASSIFICATIONNAME'] ?? null),
                'gst_type_of_supply' => $stockItemData['GSTTYPEOFSUPPLY'] ?? null,
                'excise_applicability' => html_entity_decode($stockItemData['EXCISEAPPLICABILITY'] ?? null),
                'vat_applicable' => html_entity_decode($stockItemData['VATAPPLICABLE'] ?? null),
                'costing_method' => $stockItemData['COSTINGMETHOD'] ?? null,
                'valuation_method' => $stockItemData['VALUATIONMETHOD'] ?? null,
                'base_units' => $stockItemData['BASEUNITS'] ?? null,
                'additional_units' => html_entity_decode($stockItemData['ADDITIONALUNITS'] ?? null),
                'excise_item_classification' => html_entity_decode($stockItemData['EXCISEITEMCLASSIFICATION'] ?? null),
                'vat_base_unit' => $stockItemData['VATBASEUNIT'] ?? null,
                'is_cost_centres_on' => $stockItemData['ISCOSTCENTRESON'] ?? null,
                'is_batch_wise_on' => $stockItemData['ISBATCHWISEON'] ?? null,
                'alter_id' => $stockItemData['ALTERID'] ?? null,
                'opening_balance' => $stockItemData['OPENINGBALANCE'] ?? null,
                'opening_value' => $stockItemData['OPENINGVALUE'] ?? null,
                'opening_rate' => $stockItemData['OPENINGRATE'] ?? null,
                'gst_details' => $stockItemData['GSTDETAILS.LIST'] ?? null,
                'hsn_details' => $stockItemData['HSNDETAILS.LIST'] ?? null,
                'language_name' => $nameField,
                'language_id' => $stockItemData['LANGUAGENAME.LIST']['LANGUAGEID'] ?? null,
                'batch_allocations' => $stockItemData['BATCHALLOCATIONS.LIST'] ?? null,
            ]);

            if (!$tallyStockItem) {
                throw new \Exception('Failed to create tally stock item record.');
            }

            return response()->json(['message' => 'Tally stock item data saved successfully.']);

        } catch (\Exception $e) {
            Log::error('Error importing data: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function stockItemShow(TallyStockItemDataTable $dataTable)
    {
        return $dataTable->render('superadmin.tallydata.stockItem');
    }
    
}
