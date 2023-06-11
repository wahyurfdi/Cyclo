@extends('cms.layouts.app', ['pageName' => 'Transaction'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="table">
                    <thead>
                        <tr>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Customer</th>
                            <th rowspan="2">Date</th>
                            <th rowspan="2">Pick Up</th>
                            <th rowspan="1" colspan="3" class="text-center" width="20%">Total</th>
                            <th rowspan="2">Status</th>
                        </tr>
                        <tr>
                            <th>Qty</th>
                            <th>Weight</th>
                            <th>Coin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashTransactions as $transaction)
                        <tr>
                            <td><b>{{ $transaction->code }}</b></td>
                            <td>{{ $transaction->customer_name }}</td>
                            <td>{{ date('Y-m-d', strtotime($transaction->created_at)) }}</td>
                            <td>
                                {{ $transaction->pickup_name }} ({{ $transaction->pickup_telp }})
                                <br>
                                {{ $transaction->pickup_address }} {{ !empty($transaction->pickup_location_detail) ? '('.$transaction->pickup_location_detail.')' : '' }}
                            </td>
                            <td>{{ $transaction->total_qty }}</td>
                            <td>{{ $transaction->total_weight }}</td>
                            <td>{{ $transaction->total_coin }}</td>
                            <td>
                                @if(in_array($transaction->status_code, ['PENDING', 'PROCESS']))
                                <div class="input-group status-field">
                                    <select class="form-select status-code">
                                        <option value="CANCELED">CANCELED</option>
                                        <option value="PENDING" {{ $transaction->status_code == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                        <option value="PROCESS" {{ $transaction->status_code == 'PROCESS' ? 'selected' : '' }}>ON GOING</option>
                                        <option value="COMPLETED">COMPLETED</option>
                                    </select>
                                    <button class="btn btn-warning btn-status" data-trx-code="{{ $transaction->code }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </div>
                                @else
                                    @if($transaction->status_code == 'COMPLETED')
                                        <span class="text-success">COMPLETED</span>
                                    @else
                                        <span class="text-danger">CANCELED</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $('#table').DataTable({
        order: []
    })

    $('.btn-status').on('click', function() {
        let td = $(this).closest('td'),
            trxCode = $(this).data('trx-code'),
            statusField = $(this).closest('.status-field'),
            statusCode = statusField.find('.status-code').val()

        $.ajax({
            type: 'PUT',
            url: '/cms/trash/transaction/status',
            data: {
                _token: '{{ csrf_token() }}',
                trash_transaction_code: trxCode,
                status_code: statusCode
            },
            success: function(result) {
                if(result.status == 'OK') {
                    if(statusCode == 'COMPLETED') {
                        td.html('<span class="text-success">COMPLETED</span>')
                    } else if(statusCode == 'CANCELED') {
                        td.html('<span class="text-danger">CANCELED</span>')
                    }
                }

                alert(result.message)
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText)
            }
        })
    })
</script>
@endsection