@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Invoices</div>
    <div class="card-body">
        <a href="{{ route('user.invoices.create') }}" class="btn btn-sm btn-success mb-2">New Invoice</a>
        <table class="table table-sm table-bordered">
            <thead><tr><th>No</th><th>Date</th><th>Customer</th><th>Amount</th><th>Action</th></tr></thead>
            <tbody>
                @foreach($invoices as $inv)
                    <tr>
                        <td>{{ $inv->invoice_no }}</td>
                        <td>{{ $inv->invoice_date }}</td>
                        <td>{{ $inv->customer_name }}</td>
                        <td>{{ number_format($inv->amount,2) }}</td>
                        <td>
                            <div class="card-tools">
                                <a href="{{ route('user.invoices.show',$inv->id) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('user.invoices.edit',$inv->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $invoices->links() }}
    </div>
</div>
@endsection
