<div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
           <i class="bx bx-book-open fs-4"></i>&nbsp; Accounting Details <p class="" style="margin-left: auto;">4 A/c's impacted</p>
        </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">	
            <div class="table-responsive table-responsive-scroll  border-0">
                <table class="table table-striped" style="width: 100%;">
                    <thead>
                        <tr>
                            <td>Account Name</td>
                            <td>&#8377 Credit</td>
                            <td>&#8377 Debit</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Round Off</td>
                            <td>&#8377 {{ $totalRoundOff }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>IGST @18%</td>
                            <td>&#8377 {{ $totalIGST18 }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            @foreach($uniqueGstLedgerSources as $gstLedgerSource)
                                <td>{{ $gstLedgerSource }}</td>
                            @endforeach
                            <td>&#8377 {{ $subtotalsamount }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>{{ $voucherItem->party_ledger_name }}</td>
                            <td></td>
                            <td id="totalLedgerAmount"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>