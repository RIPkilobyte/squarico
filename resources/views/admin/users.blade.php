@extends('app')
@section('content')

@include('header1')

<div class="container mt-5">
    @include('errors')
    <div class="position-absolute" style="width: 300px;">
        <select class="form-control users_select">
            <option value="all">All</option>
            <option value="attention">Attention</option>
            <option value="investment">Investment</option>
            <option value="approved">Approved</option>
            <option value="deleted">Deleted</option>
        </select>
    </div>
    <table id="table1" class="usersTable table table-bordered table-hover table-cursor-pointer py-3">
        <thead>
            <tr>
                <th>#</th>
                <th></th>
                <th>Name</th>
                <th>Investment</th>
                <th>Current Projects</th>
                <th>Note</th>
                <th width="10">Test</th>
                <th width="10">Verif</th>
                <th width="10">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th></th>
                <th>Name</th>
                <th>Investment</th>
                <th>Current Projects</th>
                <th>Note</th>
                <th>Test</th>
                <th>Verif</th>
                <th>Status</th>
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
			dom: '<"top"f>rt<"bottom"Blp><"clear">',
			serverSide: true,
			autoWidth: true,
			responsive: false,
			lengthChange: false,
			lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
			columns: [
				{data: 'id'},
                {data: 'attention'},
                {data: 'name'},
                {data: 'investment'},
                {data: 'projects'},
                {data: 'notes'},
                {data: 'test'},
                {data: 'verif'},
                {data: 'status'},
			],
			processing: true,
			language: {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			},
			ajax: {
				url: url,
				data: function (d) {
					d.filter = $(".users_select").val()
				},
			},
			buttons: [
				"copy","csv","excel","pdf","print","colvis",
				{
					text: 'Add user',
					action: function ( e, dt, node, config ) {
						window.location.href = '{{ route('user', 0) }}';
					}
				}
			],
			order: [[ 0, "desc" ]],
			'createdRow': function( row, data, dataIndex ) {
				if(data.approved) {
					$(row).addClass('bg-greenLight');
				} else if (data.deleted) {
					$(row).addClass('bg-redLight');
				}
			}
		};
		table = $("#table1").DataTable(initTable);
    }

    InitializeTable('{{ route('users.datatable') }}');

	$("#table1 tbody").on('click', 'tr', function(e){
		var data = table.row( this ).data();
		window.location.href = '/user/view/'+data.id;
	});

	$(".users_select").on('change', function(){
		table.rows().remove();
		$("#table1").dataTable().fnDestroy();
        InitializeTable('{{ route('users.datatable') }}');
        $('.dt-buttons').addClass('position-absolute');
	});

    $('.dt-buttons').addClass('position-absolute');

});
</script>
@endpush
@endsection
