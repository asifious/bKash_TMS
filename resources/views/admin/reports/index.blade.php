@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-3"><a href="{{ route('admin.reports.transactions') }}" class="btn btn-block btn-info">Transaction Report</a></div>
    <div class="col-md-3"><a href="{{ route('admin.reports.invoices') }}" class="btn btn-block btn-primary">Invoice Report</a></div>
    <div class="col-md-3"><a href="{{ route('admin.reports.users') }}" class="btn btn-block btn-success">User Report</a></div>
    <div class="col-md-3"><a href="{{ route('admin.reports.accounts') }}" class="btn btn-block btn-warning">Account Report</a></div>
</div>
@endsection
