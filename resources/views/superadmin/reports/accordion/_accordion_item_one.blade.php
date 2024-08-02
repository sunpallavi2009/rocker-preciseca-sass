<div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <i class="bx bx-group fs-4"></i>&nbsp; Party Details <p class="" style="margin-left: auto;">Bill to: {{ $voucherItem->party_ledger_name }}</p>
        </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">	
            <p class="mb-0 font-16">Bill to</p>
            <strong class="mb-0 font-16">{{ $voucherItem->party_ledger_name }}</strong>
            @foreach($ledgerData as $ledgerData)
                <p class="mb-0 font-16">{{ $ledgerData->address }}</p>
                <p class="mb-0 font-16">{{ $ledgerData->state }}</p>
            @endforeach
            Place of supply<p class="mb-0 font-16">{{ $voucherItem->place_of_supply }}</p>
        </div>
    </div>
</div>