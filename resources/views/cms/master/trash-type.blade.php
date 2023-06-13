@extends('cms.layouts.app', ['pageName' => 'Trash Type'])

@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered w-100" id="table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Weight/Qty</th>
                            <th>Coin/Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trashTypes as $idx => $trashType)
                        <tr>
                            <td><b>{{ $idx+1 }}</b></td>
                            <td>{{ $trashType->name }}</td>
                            <td>{{ $trashType->description }}</td>
                            <td>{{ $trashType->weight_per_qty }}</td>
                            <td>{{ $trashType->coin_per_qty }}</td>
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
</script>
@endsection