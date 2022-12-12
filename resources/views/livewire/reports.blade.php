<div>
    <div class="p-5">
        <h3 class="p-1">Report of Total Income</h3>
        <h4 class="p-1">Start Day</h4>
        <div class="form-control">

            <input type="date" wire:model="start" />
        </div>
        <h4 class="p-1">End Day</h4>
        <div class="form-control">

            <input type="date" wire:model="end" />
        </div>
        <h4 class="pt-5 p-1">Total Amount</h4>
        <p class="p-1">${{$total}}</p>
    </div>
</div>
