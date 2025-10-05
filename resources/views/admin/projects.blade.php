@extends('app')
@section('content')

@include('header1')

<div class="container my-5">
    @include('errors')
    <table id="table1" class="table table-bordered table-hover table-cursor-pointer">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Project description</th>
                <th>Start date</th>
                <th>Deadline</th>
                <th>SQ feets</th>
                <th>Price, £</th>
                <th>Investments</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Project description</th>
                <th>Start date</th>
                <th>Deadline</th>
                <th>SQ feets</th>
                <th>Price, £</th>
                <th>Investments</th>
            </tr>
        </tfoot>
    </table>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script>
$().ready(function(){
    var table;

    function InitializeTable(url) {
		var initTable = {
			dom: '<"top"Bf>rt<"bottom"lp><"clear">',
			serverSide: true,
			autoWidth: true,
			responsive: false,
			lengthChange: false,
			lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
			columns: [
				{data: 'id'},
                {data: 'name'},
                {data: 'description'},
                {data: 'start_at'},
                {data: 'deadline'},
                {data: 'fts'},
                {data: 'price'},
                {data: 'profit'},
			],
			processing: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			},
			ajax: {
				url: url
			},
			buttons: [
				{
					text: 'Add new project',
					action: function ( e, dt, node, config ) {
						window.location.href = '{{ route('project', 0) }}';
					}
				}
			],
			order: [[ 0, "desc" ]]
		};
		table = $("#table1").DataTable(initTable);
    }

    InitializeTable('{{ route('projects.datatable') }}');

	$("#table1 tbody").on('click', 'tr', function(e){
		var data = table.row( this ).data();
		window.location.href = '/project/view/'+data.id;
	});
});
</script>
@endpush
@endsection
