<div>
    <div class="p-4">
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
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{str_replace('r','',str_replace('c','',$payment->reference))}}</td>
                <td>{{$payment->unique_id}}</td>
                <td>{{$payment->status}}</td>
                <td>{{$payment->amount}}</td>
                @if($payment->details_id=='reg')
                    <td>Registration</td>
                    <td>Registration</td>
                @elseif($payment->details_id=='app')
                    <td>Portal Registration</td>
                    <td>Portal</td>
                @else
                    <td>{{$payment->details->firstname.' '.$payment->details->lastname}}</td>
                    <td>{{$payment->details->ssn}}</td>
                @endif

            <td>{{$payment->created_at->diffForHumans()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$payments->links()}}
    </div>
</div>
