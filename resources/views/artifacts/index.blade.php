@extends('layouts.master')
@section('title', 'My Artifacts')
@section('page-styles')
    <style type="text/css">
        #artifacts-table td, #artifacts-table td img { vertical-align: middle !important; }
        #artifacts-table_wrapper { position: relative; }
        #artifacts-table_processing {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba( 0,0,0,0.2 );
            z-index: 1000;
            margin: 0 !important;
            top: 0;
            left: 0;
        }
    </style>
@endsection
@section('page-header', 'My Artifacts')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="table-header">My Artifacts</div>
            <div>
                <table id="artifacts-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">
                                <label class="pos-rel">
                                    <input type="checkbox" class="ace">
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>Title</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('plugin-scripts')
    <script src="/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="/assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
@endsection
@section('page-scripts')
    <script>
        (function($){
            $('#artifacts-table').dataTable({
                serverSide:  true,
                bAutoWidth:  false,
                ajax:        '/artifacts/json',
                deferRender: true,
                processing:  true,
                pagingType:  'full_numbers',
                columnDefs:  [
                    {
                        name:       'checkbox',
                        targets:    0,
                        data:       'checkbox',
                        type:       'string',
                        className:  'center',
                        searchable: false,
                        orderable:  false
                    },
                    {
                        name:       'title',
                        targets:    1,
                        data:       'title',
                        type:       'string',
                        render:     {display: 'display', filter: 'filter', sort: 'sort'},
                        searchable: true,
                        orderable:  true
                    },
                    {
                        name:       'type',
                        targets:    2,
                        data:       'type',
                        type:       'string',
                        render:     {display: 'display', filter: 'filter', sort: 'sort'},
                        searchable: true,
                        orderable:  true
                    },
                    {
                        name:       'actions',
                        targets:    3,
                        data:       'actions',
                        type:       'string',
                        searchable: false,
                        orderable:  false
                    }
                ]
            });
            $('#artifacts-table th input:checkbox').on('click', function(){
                var that = this;
                $(this).closest('table').find('tr > td:first-child input:checkbox').each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                })
            });
        })(jQuery);
    </script>
@endsection