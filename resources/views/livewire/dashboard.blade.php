<div>
    <h2>Transactions</h2>
    <table  class="table table-striped">
        <thead>
            <tr>
                <th>Phone</th>
                <th>Paynow Reference</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Name</th>
                <th>SSN</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{$payment->reference}}</td>
                <td>{{$payment->unique_id}}</td>
                <td>{{$payment->status}}</td>
                <td>{{$payment->amount}}</td>
                <td>{{$payment->client->details->firstname.' '.$payment->client->details->lastname}}</td>
                <td>{{$payment->client->details->ssn}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$payments->links()}}
</div>
